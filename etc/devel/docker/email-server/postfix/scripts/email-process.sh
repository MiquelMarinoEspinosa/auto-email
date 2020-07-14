#!/bin/sh
while read line
do
   echo $line >> /tmp/email.txt
done
