FROM alpine:3.7

RUN apk add --no-cache postfix rsyslog python py2-pip
RUN pip install beanstalkc PyYAML

RUN rm /etc/postfix/master.cf /etc/postfix/main.cf /etc/postfix/virtual /etc/postfix/transport /etc/postfix/aliases /etc/rsyslog.conf
RUN touch /etc/postfix/aliases

ADD postfix/conf/* /etc/postfix/
ADD rsyslog/conf/rsyslog.conf /etc

RUN mkdir /var/spool/scripts
RUN mkdir /var/mail
ADD postfix/scripts/email-process.py /var/spool/scripts/
ADD postfix/scripts/start.sh /usr/local/bin
RUN chmod 777 /usr/local/bin/start.sh
RUN chmod 777 /var/spool/scripts/email-process.py

RUN chown root:root /var/spool/postfix/pid
RUN chown root:root /var/spool/postfix
RUN chown postfix:postfix /var/mail
RUN chown -R postfix:postfix /var/spool/scripts

RUN postmap /etc/postfix/virtual
RUN postmap /etc/postfix/transport
RUN postmap /etc/postfix/aliases

CMD /usr/local/bin/start.sh

EXPOSE 25
