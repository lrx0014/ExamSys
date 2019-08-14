package user

import (
	"github.com/jinzhu/gorm"
	// mysql driver
	_ "github.com/jinzhu/gorm/dialects/mysql"
)

type User struct {
	gorm.Model
	Name       string
	Gender     int `gorm:"type:tinyint(1)"`
	Phone      string
	Password   string
	Permission int `gorm:"type:tinyint(1)"`
	Email      string
}
