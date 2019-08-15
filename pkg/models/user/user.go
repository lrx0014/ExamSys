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
	db, err := initDB(conf)
	if err != nil {
		log.Errorf("Failed to connect to database: %v", err)
		os.Exit(-1)
	}
	return &UserManager{
		DBClient: db,
	}
}

func initDB(conf *config.Config) (*gorm.DB, error) {
	host := conf.DBHost
	port := conf.DBPort
	dbName := conf.DBName
	username := conf.DBUser
	password := conf.DBPassword
	connStr := fmt.Sprintf("%s:%s@(%s:%s)/%s?charset=utf8&parseTime=True&loc=Local", username, password, host, port, dbName)
	db, err := gorm.Open("mysql", connStr)
	if err != nil {
		log.Errorf("Failed to connect to database [%s]: %v", connStr, err)
		return nil, err
	}

	db.AutoMigrate(&User{})

	return db, nil
}

func (u *UserManager) Register(register types.RegisterReq) (bool, error) {
	exist, err := u.CheckUser(register.ID)
	if err != nil {
		log.Errorf("Failed to check user status: %v", err)
		return false, err
	}
	if exist {
		return false, fmt.Errorf("User [%s] already exist", register.ID)
	}

	user := User{
		UserID:     register.ID,
		Name:       register.Name,
		Gender:     register.Gender,
		Phone:      register.Phone,
		Password:   register.Password,
		Permission: register.Permission,
		Email:      register.Email,
	}

	err = u.DBClient.Create(&user).Error
	if err != nil {
		log.Errorf("Failed to write data into db: %v", err)
		return false, err
	}

	return true, nil
}

func (u *UserManager) CheckUser(id string) (bool, error) {
	var user User
	err := u.DBClient.Where(&User{UserID: id}).First(&user).Error
	if gorm.IsRecordNotFoundError(err) {
		log.Warningf("User [%s] not exist: %v", id, err)
		return false, nil
	}
	if err != nil {
		log.Errorf("Failed to get info of user: [%s]: %v", id, err)
		return false, err
	}

	return true, nil
}

func (u *UserManager) LoginCheck(login types.LoginReq) (bool, error) {
	if login.ID == "" || login.Password == "" {
		return false, fmt.Errorf("id or password cannot be empty")
	}
	var user User
	err := u.DBClient.Where(&User{UserID: login.ID, Password: login.Password}).First(&user).Error
	if gorm.IsRecordNotFoundError(err) {
		return false, fmt.Errorf("password wrong or user not exist")
	}
	if err != nil {
		log.Errorf("Failed to get info of user: [%s]: %v", login.ID, err)
		return false, err
	}

	return true, nil
}
