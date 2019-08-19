package questionset

import "time"

type QuestionSet struct {
	ID           int `gorm:"primary_key;AUTO_INCREMENT"`
	QuestionName string
	SetName      string
	SetAuthor    string
	Score        int
	Type         string
	CreatedAt    time.Time
	UpdatedAt    time.Time
}
