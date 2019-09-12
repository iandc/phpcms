#!/bin/bash

APP_NAME="phpcms_utf8"
APP_BRANCH="master"
APP_PATH="/home/www/pc_utf8"

cd $APP_PATH

wget https://codeload.github.com/iandc/${APP_NAME}/zip/${APP_BRANCH}
unzip $APP_BRANCH

cp -rf ${APP_NAME}-dev/* ./

rm -rf $APP_BRANCH
rm -rf ${APP_NAME}-dev

chown -R php-fpm:php-fpm *

chmod -R 0755 *
chmod 0777 ./ ./index.html
chmod -R 0777 ./html ./caches ./uploadfile ./phpsso_server/caches ./phpsso_server/uploadfile

find ./ -type d -name .svn | xargs -i rm -rf {}
find ./  -name "*.php~" | xargs -i rm -rf {}
find ./ -name "*.md" | xargs -i rm -rf {}
find ./ -name "*.bak" | xargs -i rm -rf {}

