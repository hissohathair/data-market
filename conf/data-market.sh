#!/bin/sh
#
cd /home/app/data-market
exec chpst -u app node app >/var/log/data-market.log 2>&1