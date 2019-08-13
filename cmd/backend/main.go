package main

import (
	"flag"
	"os"

	log "github.com/golang/glog"

	"github.com/codegangsta/cli"

	"github.com/lrx0014/ExamSys/pkg/apis/config"
	"github.com/lrx0014/ExamSys/pkg/server"
)

func main() {
	flag.Parse()
	defer log.Flush()

	app := cli.NewApp()
	app.Name = "ExamSys-Backend"
	app.Usage = "Start the ExamSys-Backend components"
	app.Version = "v2"
	app.Action = func(c *cli.Context) {

		conf := config.NewForEnv()

		s, err := server.New(conf)
		if err != nil {
			log.Errorf("failed to start server: %v", err)
			return
		}
		s.Run()
	}

	if err := app.Run(os.Args); err != nil {
		log.Errorf("failed to run image-builder: %v", err)
	}
}
