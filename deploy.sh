#!/bin/bash

# Missä kansiossa komento suoritetaan
DIR=$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )

source $DIR/config/environment.sh

echo "Siirretään tiedostot users-palvelimelle..."

# Tämä komento siirtää tiedostot palvelimelta
rsync -z -r $DIR/app $DIR/assets $DIR/config $DIR/lib $DIR/sql $DIR/vendor index.php composer.json $USERNAME@users.cs.helsinki.fi:htdocs/$PROJECT_FOLDER

echo "Valmis!"

echo "Suoritetaan komento php composer.phar dump-autoload..."

# Suoritetaan php composer.phar dump-autoload
ssh $USERNAME@$SERVERADDRESS "
cd $HTMLKOODIT/$PROJECT_FOLDER
php composer.phar dump-autoload
exit"

echo "Valmis! Sovelluksesi on nyt valmiina osoitteessa $USERNAME.users.cs.helsinki.fi/$PROJECT_FOLDER"
