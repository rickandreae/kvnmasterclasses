<?php

return new \Phalcon\Config(array(
'database' => array(
    'adapter' => 'Mysql',
    'host' => 'localhost',
    'username' => 'root',
    'password' => '',
    'dbname' => 'kphalcon'
),
'application' => array(
    'controllersDir' => _DIR_ . '/../../controllers/',
    'modelsDir' => _DIR_  . '/../../models/',
    'formsDir' => _DIR_  . '/../../forms/',
    'viewsDir' => _DIR_  . '/../../views/',
    'libraryDir' => _DIR_  . '/../../library/',
    'pluginsDir' => _DIR_  . '/../../plugins/',
    'cacheDir' => _DIR_  . '/../../cache/',
    'baseUri' => '/kphalcon/',
    'publicUrl' => 'vokuro.phalconphp.com',
    'debug' => '0',
),
'mail' => array(
    'fromName' => 'Phalcon Term',
    'fromEmail' => 'fcopensuse@gmail.com',
    'smtp' => array(
        'server' => 'smtp.gmail.com',
        'port' => 465,
        'security' => 'ssl',
        'username' => 'fcopensuse@gmail.com',
        'password' => 'aaaa'
    )
),
));