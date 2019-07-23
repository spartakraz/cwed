#!/bin/bash
# used by development team to chmod project files

chmod 755 js
chmod 755 js/app
chmod 644 js/app/*.js
chmod 755 js/vendor
chmod 755 js/vendor/cmirror
chmod 644 js/vendor/cmirror/*.js
chmod 644 js/vendor/cmirror/*.css
chmod 755 js/vendor/blurt
chmod 644 js/vendor/blurt/*.js
chmod 644 js/vendor/blurt/*.css
chmod 755 css
chmod 644 css/*.css
chmod 755 res
chmod 644 res/*.ico
chmod 755 src
chmod 755 src/app
chmod 755 src/app/ajax
chmod 644 src/app/ajax/*.php
chmod 755 src/app/libraries
chmod 644 src/app/libraries/*.php
chmod 755 src/app/forms
chmod 644 src/app/forms/*.php
chmod 755 src/app/service
chmod 644 src/app/service/*.php
chmod 755 src/vendor
chmod 755 src/vendor/PHPMailer
chmod 644 src/vendor/PHPMailer/*.php
chmod 640 src/vendor/PHPMailer/LICENSE
chmod 640 src/vendor/PHPMailer/VERSION
chmod 755 INSTALL-DATA
chmod 644 INSTALL-DATA/install_data.tar
chmod 644 index.php
chmod 640 README.md
chmod 755 docs
chmod 640 docs/*
chmod 644 .htaccess
chmod 755 install.sh
chmod 755 uninstall.sh

exit $?
