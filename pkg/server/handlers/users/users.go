package users

import (
	"log"
	"net/http"
	"time"

	"github.com/jinzhu/gorm"

	"github.com/lrx0014/ExamSys/pkg/config"

	"github.com/lrx0014/ExamSys/pkg/models/user"

	jwt "github.com/lrx0014/ExamSys/pkg/middleware/jwt"

	jwtgo "github.com/dgrijalva/jwt-go"
	"github.com/gin-gonic/gin"
	"github.com/lrx0014/ExamSys/pkg/types"
)

type UserHandler struct {
	userManager types.UserManagerInterface
}

func newHandler(conf *config.Config, db *gorm.DB) *UserHandler {
	um := user.NewUserManager(conf, db)
	return &UserHandler{
		userManager: um,
	}
}

//InstallHandlers install Handlers
func InstallHandlers(conf *config.Config, db *gorm.DB, normal *gin.RouterGroup, auth *gin.RouterGroup) {
	h := newHandler(conf, db)
	normal.POST("/login", h.Login)
	normal.POST("/register", h.RegisterUser)
	auth.GET("/info", h.GetDataByTime)
}

// Register 注册用户
func (u *UserHandler) RegisterUser(c *gin.Context) {
	var registerInfo types.RegisterReq
	if c.BindJSON(&registerInfo) == nil {
		status, err := u.userManager.Register(registerInfo)
		if err == nil && status == true {
			c.JSON(http.StatusOK, gin.H{
				"status": 0,
				"msg":    "Registry Successfully",
			})
		} else {
			c.JSON(http.StatusOK, gin.H{
				"status": -1,
				"msg":    "Registry Failed: " + err.Error(),
			})
		}
	} else {
		c.JSON(http.StatusBadRequest, gin.H{
			"status": -1,
			"msg":    "Body parsed failed",
		})
	}
}

// LoginResult 登录结果结构
type LoginResult struct {
	Token string `json:"token"`
}

// Login 登录
func (u *UserHandler) Login(c *gin.Context) {
	var loginReq types.LoginReq
	if c.BindJSON(&loginReq) == nil {
		isPass, err := u.userManager.LoginCheck(loginReq)
		if isPass {
			generateToken(c, loginReq)
		} else {
			c.JSON(http.StatusOK, gin.H{
				"status": -1,
				"msg":    "Login Failed," + err.Error(),
			})
		}
	} else {
		c.JSON(http.StatusBadRequest, gin.H{
			"status": -1,
			"msg":    "Body parsed failed",
		})
	}
}

// 生成令牌
func generateToken(c *gin.Context, user types.LoginReq) {
	j := &jwt.JWT{
		SigningKey: []byte("lrx0014"),
	}
	claims := jwt.CustomClaims{
		ID: user.ID,
		StandardClaims: jwtgo.StandardClaims{
			NotBefore: int64(time.Now().Unix() - 1000), // 签名生效时间
			ExpiresAt: int64(time.Now().Unix() + 3600), // 过期时间 一小时
			Issuer:    "lrx0014",                       //签名的发行者
		},
	}

	token, err := j.CreateToken(claims)

	if err != nil {
		c.JSON(http.StatusOK, gin.H{
			"status": -1,
			"msg":    err.Error(),
		})
		return
	}

	log.Println(token)

	data := LoginResult{
		Token: token,
	}
	c.JSON(http.StatusOK, data)
	return
}

// GetDataByTime 一个需要token认证的测试接口
func (u *UserHandler) GetDataByTime(c *gin.Context) {
	claims := c.MustGet("claims").(*jwt.CustomClaims)
	if claims != nil {
		c.JSON(http.StatusOK, gin.H{
			"status": 0,
			"msg":    "token is valid",
			"data":   claims,
		})
	}
}
