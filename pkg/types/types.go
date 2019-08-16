package types

// User 用户类
type RegisterReq struct {
	ID         string `json:"id"`
	Name       string `json:"name"`
	Gender     int    `json:"gender"`
	Phone      string `json:"phone"`
	Password   string `json:"password"`
	Permission int    `json:"permission"`
	Email      string `json:"email"`
}

// LoginReq 登录请求参数类
type LoginReq struct {
	ID       string `json:"id"`
	Password string `json:"password"`
}

type LoginResp struct {
	ID    string `json:"id"`
	Token string `json:"token"`
}

type LoginClaim struct {
	ID         string `json:"id"`
	Name       string `json:"username"`
	Permission int    `json:"permission"`
}

type SingleChoiceReq struct {
	Name    string `json:"name"`
	Author  string `json:"author"`
	Type    string `json:"type"`
	Content string `json:"content"`
	Choise1 string `json:"choise1"`
	Choise2 string `json:"choise2"`
	Choise3 string `json:"choise3"`
	Choise4 string `json:"choise4"`
	Choise5 string `json:"choise5"`
	Choise6 string `json:"choise6"`
	Choise7 string `json:"choise7"`
	Choise8 string `json:"choise8"`
	Answer  string `json:"answer"`
}

type SingleChoiceResp struct {
	ID string `json:"id"`
	SingleChoiceReq
}
