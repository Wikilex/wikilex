#!/bin/bash -e
export LANGUAGE=fr_FR.UTF-8

GITROOT="$(dirname $(dirname $(realpath $0)))"
DRUSH="$GITROOT/vendor/bin/drush"

# git pull the dev
cd ${GITROOT}
git pull
git submodule update --init

# Switch to the docroot
cd www

# Gulp for the appropriate theme
export DISABLE_NOTIFIER=true;
for theme in themes/custom/wikilex; do
  cd ${theme}
  [ -d node_modules ] || npm install
  gulp build
  cd -
done

${DRUSH} updb -y
${DRUSH} entity-updates -y
${DRUSH} config-import -y
${DRUSH} cache-rebuild
