package models

import (
	"bytes"
	"compress/flate"
	"fmt"
	"io"
	"log"

	"github.com/boltdb/bolt"
	uuid "github.com/satori/go.uuid"
)

const (
	dbName     = "ExamSys.db"
	userBucket = "user"
)

// User 用户类
type User struct {
	Id         string `json:"userId"`
	Name       string `json:"userName"`
	Gender     string `json:"gender"`
	Phone      string `json:"userMobile"`
	Pwd        string `json:"pwd"`
	Permission string `json:"permission"`
}

// LoginReq 登录请求参数类
type LoginReq struct {
	Phone string `json:"mobile"`
	Pwd   string `json:"pwd"`
}

// 序列化
func dumpUser(user User) []byte {
	dumped, _ := user.MarshalJSON()
	return CompressByte(dumped)
}

// 反序列化
func loadUser(jsonByte []byte) User {
	res := User{}
	res.UnmarshalJSON(DecompressByte(jsonByte))
	return res
}

// Register 插入用户，先检查是否存在用户，如果没有则存入
func Register(phone string, pwd string) error {
	if CheckUser(phone) {
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

		user := User{
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
func CheckUser(phone string) bool {
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
func LoginCheck(loginReq LoginReq) (bool, User, error) {
	db, err := bolt.Open(dbName, 0600, nil)
	if err != nil {
		log.Fatal(err)
	}
	defer db.Close()

	resultUser := User{}
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

// EditUserReq 更新用户信息数据类
type EditUserReq struct {
	UserId     string `json:"userId"`
	UserName   string `json:"userName"`
	UserGender string `json:"gender"`
}

// UpdateUser 更新用户信息
func UpdateUser(editUser EditUserReq) (User, error) {
	db, err := bolt.Open(dbName, 0600, nil)
	if err != nil {
		log.Fatal(err)
	}
	defer db.Close()

	var result User
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
func ResetPwd(mobile string, pwd string) error {
	if !CheckUser(mobile) {
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

// compressByte returns a compressed byte slice.
func CompressByte(src []byte) []byte {
	compressedData := new(bytes.Buffer)
	compress(src, compressedData, 9)
	return compressedData.Bytes()
}

// compress uses flate to compress a byte slice to a corresponding level
func compress(src []byte, dest io.Writer, level int) {
	compressor, _ := flate.NewWriter(dest, level)
	compressor.Write(src)
	compressor.Close()
}

// decompressByte returns a decompressed byte slice.
func DecompressByte(src []byte) []byte {
	compressedData := bytes.NewBuffer(src)
	deCompressedData := new(bytes.Buffer)
	decompress(compressedData, deCompressedData)
	return deCompressedData.Bytes()
}

// compress uses flate to decompress an io.Reader
func decompress(src io.Reader, dest io.Writer) {
	decompressor := flate.NewReader(src)
	io.Copy(dest, decompressor)
	decompressor.Close()
}
