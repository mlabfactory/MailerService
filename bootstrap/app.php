<?php
// Autoload Composer dependencies
use \Illuminate\Support\Carbon as Date;
use Illuminate\Support\Facades\Facade;

require_once __DIR__ . '/../vendor/autoload.php';

// Set up your application configuration
// Initialize slim application
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Set up the logger
require_once __DIR__ . '/../config/logger.php';

// Set up the mailer
require_once __DIR__ . '/../config/mailer.php';

if(env('MAIL_ADMIN_ADDRESS') === null) {
    throw new \Exception('MAIL_ADMIN_ADDRESS is not set in the .env file');
}

// Set up the Facade application
Facade::setFacadeApplication([
    'log' => $logger,
    'date' => new Date(),
    'mailer' => $mailer,
]);
