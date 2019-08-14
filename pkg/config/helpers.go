package config

import "os"

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
