<?php

return array( 
    'install_prefix' => 'dashmeteo',
    'log_path' => 'server.log',
    'database' => array(
        'name' => 'dashmeteo',
        'username' => 'dashmeteo',
        'password' => '---',
        'charset' => 'utf8',
        'options' => array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_PERSISTENT => true
        )
    )
);
