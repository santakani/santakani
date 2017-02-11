#!/bin/bash

#-------------------------------------------------------------------------------
# Initialize Environment
#-------------------------------------------------------------------------------
# 1. Create missing files and directories
# 2. Initialize file system permission
# 3. Configure Apache server
#
# Only after that, you can use artisan commands. Otherwise, error throws.
# You still need to use artisan commands to migrate database and fill seeds.
# You still need to use gulp commands to compile front-end scripts
#

echo "Initialize Local Development Environment"



echo "#1 Creating files and directories"

touch storage/logs/laravel.log
mkdir public/storage
mkdir public/storage/images
mkdir public/storage/avatars

echo "Done!"

echo "#2 Initializing file system permission"

sudo chgrp -R www storage public/storage bootstrap/cache/ bootstrap/cache/*.php
sudo chmod -R ug-x+rwX,o-wx+rX storage public/storage bootstrap/cache/ bootstrap/cache/*.php

echo "Done!"

echo "Use artisan and gulp commands to build database and compile assets"
