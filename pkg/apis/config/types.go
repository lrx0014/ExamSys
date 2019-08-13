package config

type Config struct {
	LogLevelString    string
	Port              string
	BasicAuthUser     string
	BasicAuthPassword string
	EnableTracing     string
	JaegerURL         string
	StorageURL        string
	StorageUser       string
	StoragePass       string
	CertPath          string
	KeyPath           string
}
