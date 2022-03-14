<?php

return [
    'default' => 'mysql',
    'drivers' => [
        'mysql' => [
            'queue' => 'system_jobs',
            'broker' => 'rabbitmq',
            'model' => \nikitakilpa\SystemJob\Drivers\Mysql\Models\SystemJob::class,
            'create_service' => 'create_service_mysql'
        ],
        'mongodb' => [
            'queue' => 'system_jobs',
            'broker' => 'rabbitmq',
            'model' => \nikitakilpa\SystemJob\Drivers\Mongodb\Models\SystemJob::class,
            'create_service' => 'create_service_mongodb'
        ]
    ]
];
