package user

import (
	"fmt"
	"log"

	"github.com/boltdb/bolt"
	"github.com/lrx0014/ExamSys/pkg/types"
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
func (u *UserManager) Register(userReq types.User) error {
	if u.CheckUser(userReq.Id) {
		return fmt.Errorf("user not exist")
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

		user := types.User{
			Phone:      userReq.Phone,
			Id:         userReq.Id,
			Name:       userReq.Name,
			Pwd:        userReq.Pwd,
			Gender:     userReq.Gender,
			Permission: userReq.Permission,
		}

		err = bucket.Put([]byte(userReq.Id), dumpUser(user))
		return err
	})

	return err
}

// CheckUser 检查用户是否存在
func (u *UserManager) CheckUser(id string) bool {
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
			if id == userTemp.Id {
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
			return fmt.Errorf("user info error")
		}
		return nil
	})
	return resultBool, resultUser, err
}
