package questionset

import (
	"fmt"

	log "github.com/golang/glog"
	"github.com/jinzhu/gorm"
	"github.com/lrx0014/ExamSys/pkg/config"
	"github.com/lrx0014/ExamSys/pkg/types"
)

type QuestionSetManager struct {
	DBClient *gorm.DB
}

var _ types.QuestionSetManagerInterface = &QuestionSetManager{}

func NewQuestionSetManager(conf *config.Config, db *gorm.DB) *QuestionSetManager {
	return &QuestionSetManager{
		DBClient: db,
	}
}

func (this *QuestionSetManager) Create(set types.QuestionSetBody) (string, error) {
	exist, err := this.CheckQuestionSet(set.SetName)
	if err != nil {
		log.Errorf("Failed to check questionSet status: %v", err)
		return "", err
	}
	if exist {
		return "", fmt.Errorf("QuestionSet [%s] already exist", set.SetName)
	}

	for _, v := range set.SetItems {
		item := &QuestionSet{
			QuestionName: v.QuestionName,
			SetName:      set.SetName,
			SetAuthor:    set.SetAuthor,
			Score:        v.Score,
			Type:         set.Type,
		}

		err = this.DBClient.Create(&item).Error
		if err != nil {
			log.Errorf("Failed to write questionSet into db: %v", err)
			return "", err
		}
	}

	return set.SetName, nil
}

func (this *QuestionSetManager) Update(set types.QuestionSetBody) error {
	return nil
}

func (this *QuestionSetManager) Delete(name string) error {
	var questionSet QuestionSet
	err := this.DBClient.Where(&QuestionSet{SetName: name}).First(&questionSet).Error
	if gorm.IsRecordNotFoundError(err) {
		log.Errorf("QuestionSet [%s] not exist: %v", name, err)
		return err
	}
	if err != nil {
		log.Errorf("Failed to get info of QuestionSet: [%s]: %v", name, err)
		return err
	}

	err = this.DBClient.Delete(&QuestionSet{}, "set_name=?", name).Error
	if err != nil {
		log.Errorf("Failed to delete QuestionSet: [%s]: %v", name, err)
		return err
	}
	return nil
}

func (this *QuestionSetManager) Get(name string) (types.QuestionSetBody, error) {
	var result types.QuestionSetBody
	return result, nil
}

func (this *QuestionSetManager) CheckQuestionSet(name string) (bool, error) {
	var questionset QuestionSet
	err := this.DBClient.Where(&QuestionSet{SetName: name}).First(&questionset).Error
	if gorm.IsRecordNotFoundError(err) {
		log.Warningf("QuestionSet [%s] not exist: %v", name, err)
		return false, nil
	}
	if err != nil {
		log.Errorf("Failed to get info of QuestionSet: [%s]: %v", name, err)
		return false, err
	}

	return true, nil
}
