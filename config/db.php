<?php

return [
    'class' => 'yii\db\Connection',
    //Вместо ip хоста, указать свой ip. Это нужно для работы БД на другом устройстве
//    'dsn' => 'pgsql:host=192.168.1.2;dbname=vote_system',
    'dsn' => 'pgsql:host=localhost;dbname=vote_system',
    'username' => 'vote_system',
    'password' => 'admin',
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
