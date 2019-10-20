#!/usr/bin/env bash

./remove-data.sh

git pull

./create.sh

./install.sh
