package main

import (
	"flag"
	"os"

	"github.com/lrx0014/ExamSys/pkg/models/question"

	log "github.com/golang/glog"

	"github.com/codegangsta/cli"

	"github.com/lrx0014/ExamSys/pkg/config"
	"github.com/lrx0014/ExamSys/pkg/models/user"
	"github.com/lrx0014/ExamSys/pkg/server"
	"github.com/lrx0014/ExamSys/pkg/utils"
)

func main() {
	flag.Parse()
	defer log.Flush()

	app := cli.NewApp()
	app.Name = "ExamSys-Backend"
	app.Usage = "Start the ExamSys-Backend components"
	app.Version = "v2"
	app.Action = func(c *cli.Context) {

		conf := &config.Config{}
		path := os.Getenv("config")
		if path == "" {
			conf = config.NewForEnv()
		} else {
			conf = config.NewForINI(path)
		}

		log.Infoln("Connect and Migrate database")
		db, err := utils.CreateMySQLClient(conf)
		err = db.AutoMigrate(&user.User{}, &question.SingleChoice{}).Error
		if err != nil {
			log.Errorf("failed to Migrate database: %v", err)
			return
		}

		log.Infoln("Connect and Migrate database [DONE]")
		defer db.Close()

		s, err := server.New(conf, db)
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
