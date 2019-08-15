package user

import (
	"fmt"
	"os"

	"github.com/jinzhu/gorm"
	"github.com/lrx0014/ExamSys/pkg/config"
	"github.com/lrx0014/ExamSys/pkg/types"

	log "github.com/golang/glog"
)

// UserManager implements the methods of user management.
type UserManager struct {
	DBClient *gorm.DB
}

var _ types.UserManagerInterface = &UserManager{}

func NewUserManager(conf *config.Config) *UserManager {
	host := conf.DBHost
	port := conf.DBPort
	dbName := conf.DBName
	username := conf.DBUser
	password := conf.DBPassword
	connStr := fmt.Sprintf("%s:%s@(%s:%s)/%s?charset=utf8&parseTime=True&loc=Local", username, password, host, port, dbName)
	db, err := gorm.Open("mysql", connStr)
	if err != nil {
		log.Errorf("Failed to connect to database [%s]: %v", connStr, err)
		os.Exit(-1)
	}
	defer db.Close()
	return &UserManager{
		DBClient: db,
	}
}

func (u *UserManager) Register(register types.RegisterReq) (bool, error) {
	//
	return true, nil
}

func (u *UserManager) CheckUser(id string) (bool, error) {
	//
	return false, nil
}

func (u *UserManager) LoginCheck(login types.LoginReq) (bool, error) {
	//
	return true, nil
}
