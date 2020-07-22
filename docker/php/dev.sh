#!/bin/sh
cd /var/www/jobs/
composer install --dev

echo "Waiting for mysql server"
while ! nc -z db 3306; do   
    sleep 0.1
done


echo "Execute migrations"
/var/www/jobs/bin/console migrations:migrate --no-interaction
if [ $? -eq 0 ]
then
    echo "Migrations finished"
else
    echo "Migrations failed" >&2
    exit 1
fi

echo "Execute import"
/var/www/jobs/bin/console app:job:parse
if [ $? -eq 0 ]
then
    echo "Import Finished"
else
    echo "Import failed" >&2
    exit 1
fi

php-fpm7 -F
exit $?
