#!/bin/bash

SOURCE="${BASH_SOURCE[0]}"
while [ -h "$SOURCE" ]; do
  TARGET="$(readlink "$SOURCE")"
  if [[ $TARGET == /* ]]; then
    SOURCE="$TARGET"
  else
    DIR="$( dirname "$SOURCE" )"
    SOURCE="$DIR/$TARGET"
  fi
done
DIR="$( cd -P "$( dirname "$SOURCE" )" >/dev/null 2>&1 && pwd )"
cd "$DIR/.."
DIR_PATH=$PWD

npm run admin-css

curl -k "https://raw.githubusercontent.com/twbs/bootstrap/v5.3.3/dist/js/bootstrap.bundle.min.js" > "$DIR_PATH/src/themes/admin_future/js/bootstrap.bundle.min.js"
curl -k "https://raw.githubusercontent.com/twbs/bootstrap/v5.3.3/dist/js/bootstrap.bundle.min.js.map" > "$DIR_PATH/src/themes/admin_future/js/bootstrap.bundle.min.js.map"

#sed -i 's/bootstrap.bundle.min.js.map/\/themes\/admin_future\/js\/bootstrap.bundle.min.js.map/g' $DIR_PATH/src/themes/admin_future/js/bootstrap.bundle.min.js

find "$DIR_PATH/src/themes/admin_future/webfonts" -type f -name "fa-*" | xargs /bin/rm -f
cp -r "$DIR_PATH/node_modules/@fortawesome/fontawesome-free/webfonts/." "$DIR_PATH/src/themes/admin_future/webfonts/"