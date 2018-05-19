FROM tutum/lamp:latest

RUN rm -fr /app

COPY ExamSys/ /app
COPY mysql-setup.sh /mysql-setup.sh
COPY Create_DB.sql /Create_DB.sql

ENV MYSQL_PASS admin

CMD ["/run.sh"]

EXPOSE 80 3306

