package config

func DefaultsConfig() *Config {
	cfg := &Config{
		LogLevelString: "INFO",
		Port:           "8888",
	}
	return cfg
}
