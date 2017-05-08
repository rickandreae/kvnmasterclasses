<?php

use Phalcon\Loader;
use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Url as UrlProvider;
use Phalcon\Mvc\Application;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;
use Phalcon\Mvc\View\Engine\Volt;
use Phalcon\Session\Adapter\Files as Session;

// ...

require_once __DIR__ . '\mpdf\vendor\autoload.php';
require_once __DIR__ . '\mpdf\mpdf.php';
require_once __DIR__ . '\swiftmailer-5.x\lib\swift_required.php';

// Create the Transport
$transport = Swift_SmtpTransport::newInstance('smtp.kvnmasterclasses.nl', 25)
  ->setUsername('e')
  ->setPassword('e')
  ;

// Create the Mailer using your created Transport
$mailer = Swift_Mailer::newInstance($transport);


$loader = new Loader();

$loader->registerDirs(
    [
        "../app/controllers/",
        "../app/models/",
        "../app/forms/",
    ]
);

$loader->register();


// Create a DI
$di = new FactoryDefault();

// Register Volt as a service
$di->set(
    "voltService",
    function ($view, $di) {
        $volt = new Volt($view, $di);

        $volt->setOptions(
            [
                "compiledPath"      => "../cache/volt/",
                "compiledExtension" => ".compiled",
            ]
        );

        return $volt;
    }
);

// Setup the view component
$di->set(
    "view",
    function () {
        $view = new View();

        $view->setViewsDir("../app/views/");

        $view->registerEngines([
                ".phtml" => "voltService",
            ]);

        return $view;
    }
);


$di->setShared(
    "session",
    function () {
        $session = new \Phalcon\Session\Adapter\Files();

        $session->start();

        return $session;
    }
);

// Setup the database service
$di->set(
    "db",
    function () {
        return new DbAdapter(
            [
                "host"     => "localhost",
                "username" => "root",
                "password" => "",
                "dbname"   => "kphalcon",
                "charset"  => "utf8",
            ]
        );
    }
);


// Setup a base URI so that all generated URIs include the "tutorial" folder
$di->set(
    "url",
    function () {
        $url = new UrlProvider();

        $url->setBaseUri("/kphalcon/");

        return $url;
    }
);

$application = new Application($di);

try {
    // Handle the request
    $response = $application->handle();

    $response->send();
} catch (\Exception $e) {
    echo "Exception: ", $e->getMessage();
}



