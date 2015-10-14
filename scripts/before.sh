#!/bin/bash
#install Apache
#this command will install apache and php, on to newly launched 
#instances and will just get "requirement satisfied"
#on instances that have these installed 
yum install -y httpd24 php56 php56-mysqlnd
#turn chkconfig on for apache to ensure it is started
#when the instance starts up
chkconfig httpd on
#ensure /var/www/html is empty
rm -rf /var/www/html/*
