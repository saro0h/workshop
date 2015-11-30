# VOD Portal

## Install the application

Configure the database settings in your `parameters.yml`.

    parameters:
        database_driver: pdo_mysql
        database_host: localhost
        database_port: null
        database_name: sf2c15_rest
        database_user: root
        database_password: ~
        locale: en
        secret: ThisTokenIsNeitherSecretButNeededForInsight

Build the dabatase and schema.

    $ cd /path/to/smoovio
    $ php app/console doctrine:database:create
    $ php app/console doctrine:schema:create

Load the data.

    $ mysql -u [user] -p [password] sf2c15_rest < data.sql

Build the featured movies list.

    $ php app/console smoovio:playlist:create_featured

Run PHP built-in web server.

    $ php app/console server:run

Launch the application in your web browser.

    http://localhost:8000/app_dev.php

Wow effect!!!
