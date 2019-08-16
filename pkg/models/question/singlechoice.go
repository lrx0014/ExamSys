package question

import (
	"fmt"

	log "github.com/golang/glog"
	"github.com/jinzhu/gorm"
	"github.com/lrx0014/ExamSys/pkg/config"
	"github.com/lrx0014/ExamSys/pkg/types"
	uuid "github.com/satori/go.uuid"
)

type QuestionManager struct {
	DBClient *gorm.DB
}

var _ types.QuestionManagerInterface = &QuestionManager{}

func NewQuestionManager(conf *config.Config, db *gorm.DB) *QuestionManager {
	return &QuestionManager{
		DBClient: db,
	}
}

func (this *QuestionManager) Create(req types.SingleChoiceReq) (id string, err error) {
	exist, err := this.CheckQuestionItem(req.Name)
	if err != nil {
		log.Errorf("Failed to check questionItem status: %v", err)
		return "", err
	}
	if exist {
		return "", fmt.Errorf("QuestionName [%s] already exist", req.Name)
	}

	uid := uuid.NewV4()

	questionItem := &SingleChoice{
		ID:      uid.String(),
		Name:    req.Name,
		Author:  req.Author,
		Content: req.Content,
		Type:    req.Type,
		Choise1: req.Choise1,
		Choise2: req.Choise2,
		Choise3: req.Choise3,
		Choise4: req.Choise4,
		Choise5: req.Choise5,
		Choise6: req.Choise6,
		Choise7: req.Choise7,
		Choise8: req.Choise8,
		Answer:  req.Answer,
	}

	err = this.DBClient.Create(&questionItem).Error
	if err != nil {
		log.Errorf("Failed to write questionItem into db: %v", err)
		return "", err
	}

	return uid.String(), nil
}

func (this *QuestionManager) Update(req types.SingleChoiceReq) error {
	var questionItem SingleChoice
	err := this.DBClient.Where(&SingleChoice{Name: req.Name}).First(&questionItem).Error
	if gorm.IsRecordNotFoundError(err) {
		log.Errorf("QuestionItem [%s] not exist: %v", req.Name, err)
		return err
	}
	if err != nil {
		log.Errorf("Failed to get info of QuestionItem: [%s]: %v", req.Name, err)
		return err
	}

	newQues := &SingleChoice{
		Author:  req.Author,
		Content: req.Content,
		Type:    req.Type,
		Choise1: req.Choise1,
		Choise2: req.Choise2,
		Choise3: req.Choise3,
		Choise4: req.Choise4,
		Choise5: req.Choise5,
		Choise6: req.Choise6,
		Choise7: req.Choise7,
		Choise8: req.Choise8,
		Answer:  req.Answer,
	}

	err = this.DBClient.Model(&questionItem).Updates(newQues).Error
	if err != nil {
		log.Errorf("Failed to update QuestionItem: [%s]: %v", req.Name, err)
		return err
	}

	return nil
}

func (this *QuestionManager) Delete(name string) error {
	var questionItem SingleChoice
	err := this.DBClient.Where(&SingleChoice{Name: name}).First(&questionItem).Error
	if gorm.IsRecordNotFoundError(err) {
		log.Errorf("QuestionItem [%s] not exist: %v", name, err)
		return err
	}
	if err != nil {
		log.Errorf("Failed to get info of QuestionItem: [%s]: %v", name, err)
		return err
	}

	err = this.DBClient.Delete(&questionItem).Error
	if err != nil {
		log.Errorf("Failed to delete QuestionItem: [%s]: %v", name, err)
		return err
	}
	return nil
}

func (this *QuestionManager) Get(name string) (types.SingleChoiceResp, error) {
	var questionItem SingleChoice
	err := this.DBClient.Where(&SingleChoice{Name: name}).First(&questionItem).Error
	if gorm.IsRecordNotFoundError(err) {
		log.Errorf("QuestionItem [%s] not exist: %v", name, err)
		return types.SingleChoiceResp{}, err
	}
	if err != nil {
		log.Errorf("Failed to get info of QuestionItem: [%s]: %v", name, err)
		return types.SingleChoiceResp{}, err
	}

	result := types.SingleChoiceResp{
		ID: questionItem.ID,
		SingleChoiceReq: types.SingleChoiceReq{
			Name:    questionItem.Name,
			Author:  questionItem.Author,
			Type:    questionItem.Type,
			Content: questionItem.Content,
			Choise1: questionItem.Choise1,
			Choise2: questionItem.Choise2,
			Choise3: questionItem.Choise3,
			Choise4: questionItem.Choise4,
			Choise5: questionItem.Choise5,
			Choise6: questionItem.Choise6,
			Choise7: questionItem.Choise7,
			Choise8: questionItem.Choise8,
			Answer:  questionItem.Answer,
		},
	}

	return result, nil
}

func (this *QuestionManager) CheckQuestionItem(name string) (bool, error) {
	var questionItem SingleChoice
	err := this.DBClient.Where(&SingleChoice{Name: name}).First(&questionItem).Error
	if gorm.IsRecordNotFoundError(err) {
		log.Warningf("QuestionItem [%s] not exist: %v", name, err)
		return false, nil
	}
	if err != nil {
		log.Errorf("Failed to get info of QuestionItem: [%s]: %v", name, err)
		return false, err
	}

	return true, nil
}
