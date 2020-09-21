#!/bin/bash
cd /var/tmp
/usr/bin/speedtest --csv > /var/tmp/speedtest.csv
/usr/bin/mysqlimport --fields-terminated-by=, --local -u speedtest -pspeedtest speedtest /var/tmp/speedtest.csv 
/bin/rm /var/tmp/speedtest.csv
