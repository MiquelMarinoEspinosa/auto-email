# Autoemail
Demo application to parse emails as stream

This code show how to configure the postfix transports to execute a python script every time the postfix recieve an email.
The python send the content of the email to a benstalk queue to process the email and parse it.
The message does not stay in the postfix server.
This way you have an email that sends as an stream every message that the server recieves.
