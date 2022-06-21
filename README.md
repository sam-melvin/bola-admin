# [BolaSwerte - Manage App](http://bola-manage.bolaswerte.com)

BolaSwerte Manage app created in native PHP, which aims to provide ease of management for Managers and Supervisors alike.


## Technology Stack

- PHP version > 7.4 (Versino is recommended)
- MySQL version x.x.x


## Quick start
This section describe other technologies used and their usage.

### Guide on Database Migration
Our database migration is powered by Phinx. In order to start using Phinx you must
create a phinx configuration file and indicate the needed credentials for it to be able 
to connect to your database.

Create your phinx configuration file:
```bash
cp phinx-default.php phinx.php
```

Set the credentials on your phinx configuration file
```bash
    'development' => [
        'adapter' => 'mysql',
        'host' => 'your_host',
        'name' => 'database_name',
        'user' => 'username',
        'pass' => 'password',
        'port' => '3306',
        'charset' => 'utf8',
    ],
```

To create a new migration script run the following command
```bash
php vendor/bin/phinx create CreateSampleTable
```

This will create a migration script inside db/migrations folder with a filename 
of 20210923002728_create_sample_table.php


To perform a test run for your script you can do the following:
```bash
php vendor/bin/phinx migrate --dry-run
```

This will print the queries to standard output without executing them.


To run or perform the migration. Do the following
```bash
php vendor/bin/phinx migrate
```

This will perform the migration to our database. It will provide the necessary updates
for our database.

To perform a rollback. Do the following
```bash
php vendor/bin/phinx rollback
```

This will revert changes made to our database triggered by the last migrate activity.


## Contributors

- Sam
- GlennQ
- blueant
- GAP
- Creativemindz