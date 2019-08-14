package user

import "github.com/lrx0014/ExamSys/pkg/types"

// UserManagerInterface defines the methods of user management.
type UserManagerInterface interface {
	Register(string, string) error
	CheckUser(string) bool
	LoginCheck(types.LoginReq) (bool, types.User, error)
	UpdateUser(types.EditUserReq) (types.User, error)
	ResetPwd(string, string) error
}
