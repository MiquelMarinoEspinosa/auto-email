#!/usr/bin/env python
import fileinput, base64, zlib, beanstalkc

mail_content = ''
for line in fileinput.input():
    mail_content = mail_content + line

mail_content = base64.b64encode(zlib.compress(mail_content))
beanstalk = beanstalkc.Connection(host='172.18.0.3', port=11300)
beanstalk.use('bounces-emails')
beanstalk.put(mail_content)
