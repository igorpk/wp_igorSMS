# wp_igorSMS
IgorSMS Demonstration Plugin

Overview
========
IgorSMS is a conceptual SMS-sending plugin.

IgorSMS implements an sms queue in a MySQL table (IgorSmsQueue.php). 
Every SMS to be sent is added to the table, and a separate class (IgorSms.php) is used to send the messages.
Currently, there is no actual SMS API interface, and SMSes are sent from the core igor.php file.

However, the sending capability can be triggered from anywhere (most obviously being a cronjob) 

The SMS sending functionality is currently bound to the wp_login action hook, which would send an SMS with every login.

Installation
============
Extract the contents of the .zip file into <webroot>/wp-content/plugins/

Usage
=====
This plugin will automatically start working once activated in the 'Plugins' section of Wordpress.
Once the plugin is activated, logging out and back in will show a message in the admin_notice area with the details of the last recorded SMS.
