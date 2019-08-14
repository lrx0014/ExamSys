package server

import (
	"crypto/tls"
	"net/http"
	_ "net/http/pprof"
	"time"

	log "github.com/golang/glog"

	"github.com/gin-gonic/gin"

	"github.com/lrx0014/ExamSys/pkg/middleware/jwt"

	"github.com/lrx0014/ExamSys/pkg/config"
	usershandlers "github.com/lrx0014/ExamSys/pkg/server/handlers/users"
	versionhandlers "github.com/lrx0014/ExamSys/pkg/server/handlers/version"
)

type Server struct {
	cfg    *config.Config
	engine *gin.Engine
}

func New(cfg *config.Config) (*Server, error) {

	engine := gin.Default()

	s := &Server{
		cfg:    cfg,
		engine: engine,
	}

	s.InstallDefaultHandlers()

	return s, nil
}

func (s *Server) Run() {

	server := &http.Server{
		Addr:           ":" + s.cfg.Port,
		Handler:        http.DefaultServeMux,
		ReadTimeout:    300 * time.Second,
		WriteTimeout:   300 * time.Second,
		MaxHeaderBytes: 1 << 20,
	}

	if s.cfg.CertPath != "" && s.cfg.KeyPath != "" {
		log.Infof("CertPath and KeyPath is not null,try to load certificate and key")
		cer, err := tls.LoadX509KeyPair(s.cfg.CertPath, s.cfg.KeyPath)
		if err != nil {
			log.Errorf("failed to load certificate and key: %v", err)
			return
		}
		tlsconfig := &tls.Config{Certificates: []tls.Certificate{cer}}
		server.TLSConfig = tlsconfig
		log.Infof("Successful import certificate and key, image-builder begins begin to use https")
		log.Fatal(server.ListenAndServeTLS(s.cfg.CertPath, s.cfg.KeyPath))
	} else {
		log.Infof("CertPath and KeyPath is null, image-builder begins to use http")
		log.Fatal(server.ListenAndServe())
	}

}

// InstallDefaultHandlers registers the default set of supported HTTP request
// patterns with the Gin framework.
func (s *Server) InstallDefaultHandlers() {

	http.Handle("/v1/", s.engine)
	http.Handle("/v2/", s.engine)
	http.Handle("/login", s.engine)
	http.Handle("/register", s.engine)
	http.Handle("/ping", s.engine)

	// install healthz
	s.engine.GET("/ping", func(c *gin.Context) {
		c.String(200, "pong")
	})

	normal := s.engine.Group("/")

	// enable basic auth
	authorized := s.engine.Group("/v2")
	authorized.Use(jwt.JWTAuth())

	// install user handlers
	versionhandlers.InstallHandlers(authorized)
	usershandlers.InstallHandlers(normal, authorized)
}
