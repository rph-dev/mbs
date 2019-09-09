#!/usr/bin/env bash

./stop.sh

docker volume rm mbs_mariadb
echo "remove mariadb complete"

docker network rm mbs_web_net
echo "remove mbs_web network complete"
