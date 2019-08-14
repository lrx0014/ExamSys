package user

import (
	"fmt"
	"log"

	"github.com/boltdb/bolt"
	"github.com/lrx0014/ExamSys/pkg/types"
	uuid "github.com/satori/go.uuid"
)

// UserManager implements the methods of user management.
type UserManager struct{}

var _ UserManagerInterface = &UserManager{}

const (
	dbName     = "ExamSys.db"
	userBucket = "user"
)

func NewUserManager() *UserManager {
	return &UserManager{}
}

// Register 插入用户，先检查是否存在用户，如果没有则存入
func (u *UserManager) Register(phone string, pwd string) error {
	if u.CheckUser(phone) {
		return fmt.Errorf("用户已存在！")
	}

	db, err := bolt.Open(dbName, 0600, nil)
	if err != nil {
		log.Fatal(err)
	}
	defer db.Close()
	err = db.Update(func(tx *bolt.Tx) error {
		bucket, err := tx.CreateBucketIfNotExists([]byte(userBucket))
		if err != nil {
			return err
		}

		uidObj := uuid.NewV4()
		uid := uidObj.String()

		user := types.User{
			Phone:  phone,
			Id:     uid,
			Name:   phone,
			Pwd:    pwd,
			Gender: "0",
		}

		if user.Phone == "15800000000" {
			user.Permission = "1"
		} else {
			user.Permission = "0"
		}
		err = bucket.Put([]byte(uid), dumpUser(user))
		return err
	})

	return err
}

// CheckUser 检查用户是否存在
func (u *UserManager) CheckUser(phone string) bool {
	db, err := bolt.Open(dbName, 0600, nil)
	if err != nil {
		log.Fatal(err)
	}
	defer db.Close()

	result := false

	err = db.View(func(tx *bolt.Tx) error {
		bucket := tx.Bucket([]byte(userBucket))
		if bucket == nil {
			return fmt.Errorf(" userBuket is null")
		}
		c := bucket.Cursor()
		for k, v := c.First(); k != nil; k, v = c.Next() {
			userTemp := loadUser(v)
			if phone == userTemp.Phone {
				result = true
				break
			}
		}
		return nil
	})
	return result
}

// LoginCheck 登录验证
func (u *UserManager) LoginCheck(loginReq types.LoginReq) (bool, types.User, error) {
	db, err := bolt.Open(dbName, 0600, nil)
	if err != nil {
		log.Fatal(err)
	}
	defer db.Close()

	resultUser := types.User{}
	resultBool := false
	err = db.View(func(tx *bolt.Tx) error {
		bucket := tx.Bucket([]byte(userBucket))
		if bucket == nil {
			return fmt.Errorf(" userBuket is null")
		}
		c := bucket.Cursor()
		for k, v := c.First(); k != nil; k, v = c.Next() {
			userTemp := loadUser(v)
			if loginReq.Phone == userTemp.Phone && loginReq.Pwd == userTemp.Pwd {
				resultUser = userTemp
				resultBool = true
				break
			}
		}
		if !resultBool {
			return fmt.Errorf("用户信息错误!")
		} else {
			return nil
		}
	})
	return resultBool, resultUser, err
}

// UpdateUser 更新用户信息
func (u *UserManager) UpdateUser(editUser types.EditUserReq) (types.User, error) {
	db, err := bolt.Open(dbName, 0600, nil)
	if err != nil {
		log.Fatal(err)
	}
	defer db.Close()

	var result types.User
	err = db.Update(func(tx *bolt.Tx) error {
		bucket, err := tx.CreateBucketIfNotExists([]byte(userBucket))
		if err != nil {
			return err
		}

		v := bucket.Get([]byte(editUser.UserId))
		if v == nil {
			return fmt.Errorf("user not exits")
		}

		result = loadUser(v)
		result.Name = editUser.UserName
		result.Gender = editUser.UserGender
		return bucket.Put([]byte(result.Id), dumpUser(result))
	})

	return result, err
}

//ResetPwd 重置密码
func (u *UserManager) ResetPwd(mobile string, pwd string) error {
	if !u.CheckUser(mobile) {
		return fmt.Errorf("用户不存在！")
	}

	db, err := bolt.Open(dbName, 0600, nil)
	if err != nil {
		log.Fatal(err)
	}
	defer db.Close()

	err = db.Update(func(tx *bolt.Tx) error {
		bucket := tx.Bucket([]byte(userBucket))
		if bucket == nil {
			return fmt.Errorf(" userBuket is null")
		}
		c := bucket.Cursor()
		for k, v := c.First(); k != nil; k, v = c.Next() {
			userTemp := loadUser(v)
			if mobile == userTemp.Phone {
				userTemp.Pwd = pwd
				return bucket.Put([]byte(userTemp.Id), dumpUser(userTemp))
			}
		}
		return nil
	})
	return err
}
