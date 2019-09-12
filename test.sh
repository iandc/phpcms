#!/bin/bash

APP_NAME="phpcms_utf8"
APP_BRANCH="dev"
APP_PATH="/home/www/pc_utf8"

cd $APP_PATH

#wget https://codeload.github.com/iandc/${APP_NAME}/zip/${APP_BRANCH}
#unzip $APP_BRANCH

cp -rf ./caches/configs ./caches/configs_bak
cp -rf ./phpsso_server/caches/configs ./phpsso_server/caches/configs_bak

#cp -rf ${APP_NAME}-dev/* ./

cp -rf ./caches/configs_bak/* ./caches/configs
cp -rf ./phpsso_server/caches/configs_bak/* ./phpsso_server/caches/configs

#rm -rf $APP_BRANCH
#rm -rf ${APP_NAME}-dev
#rm -rf ./caches/configs_bak
#rm -rf ./phpsso_server/caches/configs_bak

chown -R php-fpm:php-fpm *

chmod -R 0755 *
chmod 0777 ./ ./index.html
chmod -R 0777 ./html ./caches ./uploadfile ./phpsso_server/caches ./phpsso_server/uploadfile
chmod -R 0777 ./phpcms/templates ./statics

find ./ -type d -name .svn | xargs -i rm -rf {}
find ./  -name "*.php~" | xargs -i rm -rf {}
find ./ -name "*.md" | xargs -i rm -rf {}
find ./ -name "*.bak" | xargs -i rm -rf {}

