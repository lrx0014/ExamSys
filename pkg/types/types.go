package types

// UserManagerInterface defines the methods of user management.
type UserManagerInterface interface {
	Register(register RegisterReq) (bool, error)
	CheckUser(id string) (bool, error)
	LoginCheck(login LoginReq) (bool, LoginResp, error)
}

// User 用户类
type RegisterReq struct {
	ID         string `json:"id"`
	Name       string `json:"name"`
	Gender     int    `json:"gender"`
	Phone      string `json:"phone"`
	Password   string `json:"password"`
	Permission int    `json:"permission"`
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
