package config

func DefaultsConfig() *Config {
	cfg := &Config{
		LogLevelString:    "INFO",
		Port:              "8989",
		BasicAuthUser:     "admin",
		BasicAuthPassword: "admin",
		EnableTracing:     "false",
	}
	return cfg
}
