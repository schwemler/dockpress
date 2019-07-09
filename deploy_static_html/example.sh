#!/bin/bash

# COPY THIS SCRIPT & SET PROJECT DATA BEFORE EXEC
# PROJECT_NAME should be the same as github user name to deploy

PROJECT_NAME=example

PROJECT_GITHUB_URL=https://github.com/${PROJECT_NAME}/${PROJECT_NAME}.github.io.git
PROJECT_DIR=./../${PROJECT_NAME}_static
rm -Rf $PROJECT_DIR
mkdir -p $PROJECT_DIR
#cd $PROJECT_DIR
git clone $PROJECT_GITHUB_URL $PROJECT_DIR
rm -Rf $PROJECT_DIR/*
#read -n 1 -s -r -p "Press any key to continue"
cp -rf ./html_static/* $PROJECT_DIR
#read -n 1 -s -r -p "Press any key to continue"
cd $PROJECT_DIR
git add .
git status
git commit -m "CLI Deployment"
git push
