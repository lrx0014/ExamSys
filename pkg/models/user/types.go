package user

import (
	// mysql driver
	"time"

	_ "github.com/jinzhu/gorm/dialects/mysql"
)

type User struct {
	UserID     string `gorm:"primary_key"`
	Name       string
	Gender     int `gorm:"type:tinyint(1)"`
	Phone      string
	Password   string
	Permission int `gorm:"type:tinyint(1)"`
	Email      string
	CreatedAt  time.Time
	UpdatedAt  time.Time
}
