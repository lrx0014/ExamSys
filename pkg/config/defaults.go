package config

func DefaultsConfig() *Config {
	cfg := &Config{
		LogLevelString:    "INFO",
		Port:              "8888",
		BasicAuthUser:     "admin",
		BasicAuthPassword: "admin",
	}
	return cfg
}
