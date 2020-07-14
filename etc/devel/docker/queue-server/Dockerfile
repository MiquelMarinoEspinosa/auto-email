FROM alpine:3.7

RUN apk add --no-cache beanstalkd
RUN apk add --no-cache rsyslog
ADD beanstalk/console/aurora_linux_amd64_v2.1.tar.gz /usr/local/bin
ADD scripts/* /usr/local/bin
RUN chmod 777 /usr/local/bin/start.sh
ADD beanstalk/console/conf/* /
RUN rm /etc/rsyslog.conf
ADD rsyslog/conf/rsyslog.conf /etc

CMD /usr/local/bin/start.sh

EXPOSE 11300
