#!/usr/bin/env bash

TODAY=$(date "+%Y-%d-%m")
TODAY_LOG="scheduler_${today}.log"
YESTERDAY=$(date "+%Y-%d-%m" -d "yesterday")
YESTERDAY_LOG="scheduler_${YESTERDAY}.log"

if [ -f /home/forge/default/storage/logs/${YESTERDAY_LOG} ]; then
    rm /home/forge/default/storage/logs/${YESTERDAY_LOG}
fi

php /home/forge/default/artisan schedule:run > /home/forge/default/storage/logs/${TODAY_LOG}