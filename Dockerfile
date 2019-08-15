FROM golang AS build-env
ADD . /go/src/github.com/lrx0014/ExamSys
RUN go build github.com/lrx0014/ExamSys/cmd/backend

FROM golang
COPY --from=build-env /go/backend /backend
ENV TZ Asia/Shanghai
EXPOSE 8888
CMD ["/backend"]

