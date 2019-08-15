package config

import (
	"os"

	log "github.com/golang/glog"
	"gopkg.in/ini.v1"
)

func NewForEnv() *Config {
	cfg := DefaultsConfig()

	if val, ok := os.LookupEnv("log_level"); ok {
		cfg.LogLevelString = val
	}

	if val, ok := os.LookupEnv("Port"); ok {
		cfg.Port = val
	}

	if val, ok := os.LookupEnv("CertPath"); ok {
		cfg.CertPath = val
	}

	if val, ok := os.LookupEnv("KeyPath"); ok {
		cfg.KeyPath = val
	}

	if val, ok := os.LookupEnv("DBHost"); ok {
		cfg.DBHost = val
	}

	if val, ok := os.LookupEnv("DBPort"); ok {
		cfg.DBPort = val
	}

	if val, ok := os.LookupEnv("DBName"); ok {
		cfg.DBName = val
	}

	if val, ok := os.LookupEnv("DBUser"); ok {
		cfg.DBUser = val
	}

	if val, ok := os.LookupEnv("DBPassword"); ok {
		cfg.DBPassword = val
	}

	return cfg
}

func NewForINI(path string) *Config {
	result := &Config{}
	cfg, err := ini.Load(path)
	if err != nil {
		log.Errorf("Failed to read config from ini file: %s, caused by: %v", path, err)
		return result
	}

	dbSection, err := cfg.GetSection("db")
	if err != nil {
		log.Errorf("Failed to read config from ini file: %s, caused by: %v", path, err)
		return result
	}

	result.DBHost = dbSection.Key("host").Value()
	result.DBPort = dbSection.Key("port").Value()
	result.DBUser = dbSection.Key("username").Value()
	result.DBPassword = dbSection.Key("password").Value()
	result.DBName = dbSection.Key("dbname").Value()

	dbSection, err = cfg.GetSection("ssl")
	if err != nil {
		log.Errorf("Failed to read config from ini file: %s, caused by: %v", path, err)
		return result
	}

	result.CertPath = dbSection.Key("cert").Value()
	result.KeyPath = dbSection.Key("key").Value()

	dbSection, err = cfg.GetSection("system")
	if err != nil {
		log.Errorf("Failed to read config from ini file: %s, caused by: %v", path, err)
		return result
	}

	result.Port = dbSection.Key("port").Value()
	result.LogLevelString = dbSection.Key("log_level").Value()

	return result
}
