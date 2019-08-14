package user

import (
	"bytes"
	"compress/flate"
	"io"

	"github.com/lrx0014/ExamSys/pkg/types"
)

// compressByte returns a compressed byte slice.
func compressByte(src []byte) []byte {
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
func decompressByte(src []byte) []byte {
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

// 序列化
func dumpUser(user types.RegisterReq) []byte {
	dumped, _ := user.MarshalJSON()
	return compressByte(dumped)
}

// 反序列化
func loadUser(jsonByte []byte) types.RegisterReq {
	res := types.RegisterReq{}
	res.UnmarshalJSON(decompressByte(jsonByte))
	return res
}
