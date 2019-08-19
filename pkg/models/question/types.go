package question

import "time"

type SingleChoice struct {
	ID        string `gorm:"primary_key"`
	Name      string
	Author    string
	Type      string
	Content   string
	Choise1   string
	Choise2   string
	Choise3   string
	Choise4   string
	Choise5   string
	Choise6   string
	Choise7   string
	Choise8   string
	Answer    string
	CreatedAt time.Time
	UpdatedAt time.Time
}
