#!/bin/bash

sleep 5

php artisan migrate

nohup php artisan serve --host=0.0.0.0 --port 8000 &

php artisan redis:subscribe
