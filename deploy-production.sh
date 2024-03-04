#!/bin/bash
pkill ssh-agent
eval "$(ssh-agent -s)"
ssh-add ~/.ssh/git_rsa
git pull origin dev
sleep 5s && \ 
    yarn build
sleep 10s && \ 
    APP_ENV=prod APP_DEBUG=0 php bin/console cache:clear