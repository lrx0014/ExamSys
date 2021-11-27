FROM tutum/lamp:latest

RUN rm -fr /app

COPY ExamSys/ /app

EXPOSE 80