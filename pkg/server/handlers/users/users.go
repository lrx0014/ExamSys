package users

import (
	"log"
	"net/http"
	"time"

	"github.com/lrx0014/ExamSys/pkg/models"

	myjwt "github.com/lrx0014/ExamSys/pkg/middleware"

	jwtgo "github.com/dgrijalva/jwt-go"
	"github.com/gin-gonic/gin"
)

// 注册信息
type RegistInfo struct {
	// 手机号
	Phone string `json:"mobile"`
	// 密码
	Pwd string `json:"pwd"`
}

//InstallHandlers install Handlers
func InstallHandlers(routerGroup *gin.RouterGroup) {
	routerGroup.POST("/v2/login", Login)
	routerGroup.POST("/v2/register", RegisterUser)
}

// Register 注册用户
func RegisterUser(c *gin.Context) {
	var registerInfo RegistInfo
	if c.BindJSON(&registerInfo) == nil {
		err := models.Register(registerInfo.Phone, registerInfo.Pwd)
		if err == nil {
			c.JSON(http.StatusOK, gin.H{
				"status": 0,
				"msg":    "注册成功！",
			})
		} else {
			c.JSON(http.StatusOK, gin.H{
				"status": -1,
				"msg":    "注册失败" + err.Error(),
			})
		}
	} else {
		c.JSON(http.StatusOK, gin.H{
			"status": -1,
			"msg":    "解析数据失败！",
		})
	}
}

// LoginResult 登录结果结构
type LoginResult struct {
	Token string `json:"token"`
	models.User
}

// Login 登录
func Login(c *gin.Context) {
	var loginReq models.LoginReq
	if c.BindJSON(&loginReq) == nil {
		isPass, user, err := models.LoginCheck(loginReq)
		if isPass {
			generateToken(c, user)
		} else {
			c.JSON(http.StatusOK, gin.H{
				"status": -1,
				"msg":    "验证失败," + err.Error(),
			})
		}
	} else {
		c.JSON(http.StatusOK, gin.H{
			"status": -1,
			"msg":    "json 解析失败",
		})
	}
}

// 生成令牌
func generateToken(c *gin.Context, user models.User) {
	j := &myjwt.JWT{
		[]byte("newtrekWang"),
	}
	claims := myjwt.CustomClaims{
		user.Id,
		user.Name,
		user.Phone,
		jwtgo.StandardClaims{
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
		User:  user,
		Token: token,
	}
	c.JSON(http.StatusOK, gin.H{
		"status": 0,
		"msg":    "登录成功！",
		"data":   data,
	})
	return
}

// GetDataByTime 一个需要token认证的测试接口
func GetDataByTime(c *gin.Context) {
	claims := c.MustGet("claims").(*myjwt.CustomClaims)
	if claims != nil {
		c.JSON(http.StatusOK, gin.H{
			"status": 0,
			"msg":    "token有效",
			"data":   claims,
		})
	}
}
