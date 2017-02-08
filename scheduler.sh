#!/usr/bin/env bash

TODAY=$(date "+%Y-%d-%m")
TODAY_LOG="scheduler_${TODAY}.log"
YESTERDAY=$(date "+%Y-%d-%m" -d "yesterday")
YESTERDAY_LOG="scheduler_${YESTERDAY}.log"

if [ -f /home/forge/dashboardersheaven.com/storage/logs/${YESTERDAY_LOG} ]; then
    rm /home/forge/dashboardersheaven.com/storage/logs/${YESTERDAY_LOG}
fi

if [ ! -f /home/forge/dashboardersheaven.com/storage/logs/${TODAY_LOG} ]; then
    touch /home/forge/dashboardersheaven.com/storage/logs/${TODAY_LOG}
fi

php /home/forge/dashboardersheaven.com/artisan schedule:run >> /home/forge/dashboardersheaven.com/storage/logs/${TODAY_LOG}