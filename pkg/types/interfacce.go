package types

// UserManagerInterface defines the methods of user management.
type UserManagerInterface interface {
	Register(register RegisterReq) (bool, error)
	CheckUser(id string) (bool, error)
	LoginCheck(login LoginReq) (*LoginClaim, error)
}

type QuestionManagerInterface interface {
	Create(ques SingleChoiceReq) (string, error)
	Update(ques SingleChoiceReq) error
	Delete(name string) error
	Get(name string) (SingleChoiceResp, error)
}

type QuestionSetManagerInterface interface {
	Create(set QuestionSetBody) (string, error)
	Update(set QuestionSetBody) error
	Delete(name string) error
	Get(name string) (QuestionSetBody, error)
}
