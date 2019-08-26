module github.com/lrx0014/ExamSys

go 1.12

require (
	github.com/codegangsta/cli v1.21.0
	github.com/dgrijalva/jwt-go v3.2.0+incompatible
	github.com/gin-contrib/sse v0.0.0-20190301062529-5545eab6dad3
	github.com/gin-gonic/gin v1.4.0
	github.com/go-sql-driver/mysql v1.4.1
	github.com/golang/glog v0.0.0-20160126235308-23def4e6c14b
	github.com/golang/protobuf v1.3.1
	github.com/jinzhu/gorm v1.9.10
	github.com/jinzhu/inflection v1.0.0
	github.com/json-iterator/go v1.1.6
	github.com/mattn/go-isatty v0.0.7
	github.com/modern-go/concurrent v0.0.0-20180306012644-bacd9c7ef1dd
	github.com/modern-go/reflect2 v1.0.1
	github.com/pquerna/ffjson v0.0.0-20190813045741-dac163c6c0a9
	github.com/satori/go.uuid v1.2.0
	github.com/ugorji/go v1.1.4
	golang.org/x/sys v0.0.0-20190813064441-fde4db37ae7a
	google.golang.org/appengine v1.6.1
	gopkg.in/go-playground/validator.v8 v8.18.2
	gopkg.in/ini.v1 v1.46.0
	gopkg.in/yaml.v2 v2.2.2
)

replace github.com/codegangsta/cli v1.21.0 => github.com/urfave/cli v1.21.0
