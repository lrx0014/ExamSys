package questions

import (
	"fmt"

	"github.com/jinzhu/gorm"

	"github.com/lrx0014/ExamSys/pkg/config"

	"github.com/lrx0014/ExamSys/pkg/models/question"

	"github.com/gin-gonic/gin"
	log "github.com/golang/glog"
	jwt "github.com/lrx0014/ExamSys/pkg/middleware/jwt"
	"github.com/lrx0014/ExamSys/pkg/types"
)

type QuestionHandler struct {
	questionManager types.QuestionManagerInterface
}

func newHandler(conf *config.Config, db *gorm.DB) *QuestionHandler {
	qm := question.NewQuestionManager(conf, db)
	return &QuestionHandler{
		questionManager: qm,
	}
}

//InstallHandlers install Handlers
func InstallHandlers(conf *config.Config, db *gorm.DB, auth *gin.RouterGroup) {
	h := newHandler(conf, db)
	auth.GET("/questions/:name", h.Get)
	auth.POST("/questions", h.Create)
	auth.PUT("/questions/:name", h.Update)
	auth.DELETE("/questions/:name", h.Delete)
}

func (h *QuestionHandler) Get(c *gin.Context) {
	claims := c.MustGet("claims").(*jwt.CustomClaims)
	if claims.Permission < 1 {
		err := fmt.Errorf("permission denied: you are not allowed to access this resource")
		handleError(c, 403, err)
		return
	}
	name := c.Param("name")
	result, err := h.questionManager.Get(name)
	if err != nil {
		log.Errorf("failed to get quetion: %v", err)
		handleError(c, 500, err)
		return
	}
	c.JSON(200, result)
}

func (h *QuestionHandler) Update(c *gin.Context) {
	claims := c.MustGet("claims").(*jwt.CustomClaims)
	if claims.Permission < 1 {
		err := fmt.Errorf("permission denied: you are not allowed to access this resource")
		handleError(c, 403, err)
		return
	}

	name := c.Param("name")
	var req types.SingleChoiceReq
	err := c.BindJSON(&req)
	if err != nil {
		log.Errorf("failed to parse body: %v", err)
		handleError(c, 400, err)
		return
	}
	if name != req.Name {
		err := fmt.Errorf("specified names in path params and body are different")
		handleError(c, 400, err)
		return
	}
	err = h.questionManager.Update(req)
	if err != nil {
		log.Errorf("failed to update questionItem: %v", err)
		handleError(c, 500, err)
		return
	}
	c.JSON(200, struct{}{})
}

func (h *QuestionHandler) Create(c *gin.Context) {
	claims := c.MustGet("claims").(*jwt.CustomClaims)
	if claims.Permission < 1 {
		err := fmt.Errorf("permission denied: you are not allowed to access this resource")
		handleError(c, 403, err)
		return
	}

	var req types.SingleChoiceReq
	err := c.BindJSON(&req)
	if err != nil {
		log.Errorf("failed to parse body: %v", err)
		handleError(c, 400, err)
		return
	}
	id, err := h.questionManager.Create(req)
	if err != nil {
		log.Errorf("failed to create questionItem: %v", err)
		handleError(c, 500, err)
		return
	}

	result := map[string]string{}
	result["id"] = id
	c.JSON(200, result)
}

func (h *QuestionHandler) Delete(c *gin.Context) {
	claims := c.MustGet("claims").(*jwt.CustomClaims)
	if claims.Permission < 1 {
		err := fmt.Errorf("permission denied: you are not allowed to access this resource")
		handleError(c, 403, err)
		return
	}

	name := c.Param("name")
	err := h.questionManager.Delete(name)
	if err != nil {
		log.Errorf("failed to delete questionItem: %v", err)
		handleError(c, 500, err)
		return
	}
	c.JSON(200, struct{}{})
}

func handleError(c *gin.Context, code int, err error) {
	response := map[string]string{}
	response["error"] = err.Error()
	c.JSON(code, response)
}
