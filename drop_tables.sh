#!/bin/bash

source config/environment.sh

echo "Poistetaan tietokantataulut..."

ssh $USERNAME@$SERVERADDRESS "
cd $HTMLKOODIT/$PROJECT_FOLDER/sql
psql < drop_tables.sql
exit"

echo "Valmis!"
