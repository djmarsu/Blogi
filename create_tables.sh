#!/bin/bash

source config/environment.sh

echo "Luodaan tietokantaulut..."

ssh $USERNAME@$SERVERADDRESS "
cd $HTMLKOODIT/$PROJECT_FOLDER/sql
cat drop_tables.sql create_tables.sql | psql -1 -f -
exit"

echo "Valmis!"
