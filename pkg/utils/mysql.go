package utils

import (
	"fmt"

	"github.com/jinzhu/gorm"
	"github.com/lrx0014/ExamSys/pkg/config"

	log "github.com/golang/glog"
)

func CreateMySQLClient(conf *config.Config) (*gorm.DB, error) {
	host := conf.DBHost
	port := conf.DBPort
	dbName := conf.DBName
	username := conf.DBUser
	password := conf.DBPassword
	connStr := fmt.Sprintf("%s:%s@(%s:%s)/%s?charset=utf8&parseTime=True&loc=Local", username, password, host, port, dbName)
	db, err := gorm.Open("mysql", connStr)
	if err != nil {
		log.Errorf("Failed to connect to database [%s]: %v", connStr, err)
		return db, err
	}

	return db, nil
}
