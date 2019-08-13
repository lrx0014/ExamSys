package version

import (
	"net/http"

	"github.com/gin-gonic/gin"
)

type Version struct {
	Ver string `json:"ver"`
}

type handler struct{}

//InstallHandlers install Handlers
func InstallHandlers(routerGroup *gin.RouterGroup) {
	h := &handler{}
	routerGroup.GET("/v2/version", h.handleVersion)
}

func (h *handler) handleVersion(c *gin.Context) {
	c.JSON(http.StatusOK, Version{Ver: "v2"})
}
