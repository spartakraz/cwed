#!/bin/bash

readonly SRV_DIR=/srv
readonly DATA_DIR=${SRV_DIR}/cwed.d

if [ -d "${DATA_DIR}" ]; then
	echo "${DATA_DIR} already exists. Now exiting..." >&2
	exit 1
fi

tar xvf INSTALL-DATA/install_data.tar -C ${SRV_DIR}
if [ ! -d "${DATA_DIR}" ]; then
	echo "${DATA_DIR} not found. Now exiting..." >&2
	exit 1
fi

set -e
chmod 755 ${DATA_DIR}
chmod 777 ${DATA_DIR}/users
chmod 777 ${DATA_DIR}/users/testuser
chmod 666 ${DATA_DIR}/users/testuser/*
chmod 666 ${DATA_DIR}/users/logindb.dat
chmod 755 ${DATA_DIR}/config
chmod 666 ${DATA_DIR}/config/cwed.conf
chmod 777 ${DATA_DIR}/temp
chmod 666 ${DATA_DIR}/temp/*

exit $?
