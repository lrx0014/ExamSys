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

	if val, ok := os.LookupEnv("BasicAuthUser"); ok {
		cfg.BasicAuthUser = val
	}

	if val, ok := os.LookupEnv("BasicAuthPassword"); ok {
		cfg.BasicAuthPassword = val
	}

	if val, ok := os.LookupEnv("CertPath"); ok {
		cfg.CertPath = val
	}

	if val, ok := os.LookupEnv("KeyPath"); ok {
		cfg.KeyPath = val
	}

	cfg.JaegerURL = os.Getenv("JaegerURL")

	cfg.StorageURL = os.Getenv("StorageURL")
	cfg.StorageUser = os.Getenv("StorageUser")
	cfg.StoragePass = os.Getenv("StoragePass")

	return cfg
}
