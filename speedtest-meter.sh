#!/bin/bash
cd /var/tmp
speedtest --csv > /var/tmp/speedtest.csv
#cat /var/tmp/speedtest.csv
mysqlimport --fields-terminated-by=, --local -u speedtest -pspeedtest speedtest /var/tmp/speedtest.csv 
rm /var/tmp/speedtest.csv
