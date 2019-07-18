#!/usr/bin/env bash
##
# Push to docker hub when running in CircleCI context.
#

if [ -z ${DOCKER_USER+x} ] ; then
    echo "DOCKER_USER and DOCKER_PASS credentials are not set."
else
    echo "Authenticating with docker hub."
    docker login -u $DOCKER_USER -p $DOCKER_PASS
fi

# TODO: Describe the cases being checked here. What is DEPLOY_ANY_BRANCH? It doesn't exist in the codebase.
# TODO: We should consider using branch/tag filters in the .circleci/config.yml

if [ "${DEPLOY_ANY_BRANCH}" != "" ] || [ "${CIRCLE_BRANCH}" == "master" ] || [ ! -z ${CIRCLE_TAG} ]; then
    echo "IMAGE_VERSION_TAG=$CIRCLE_TAG">>.env
    export $(grep -v '^#' .env | xargs)
    . .docker/push.sh
else
    echo "Skipping deployment, no appropriate tags."
fi
