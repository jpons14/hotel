<?php
#### TEMPORAL ####

error_reporting( E_ALL ^ E_NOTICE);

// Just used for widgets
$GLOBALS['formAction'] = '';

// Used for everything less widgets
define('FORM_ACTION', '');

define('ABSOLUTE_PATH', '/hotel');

$GLOBALS['systemRoot'] = 'c:wamp64/www' . ABSOLUTE_PATH;
define('SYSTEM_ROOT', 'c:wamp64/www' . ABSOLUTE_PATH);

define('IMG_USERS', 'c:wamp64/www' . ABSOLUTE_PATH     . '/public/assets/img/users/');




$GLOBALS['controllerAndAction'] = include 'private/permissions/controllerAndAction.php';
$GLOBALS['usersPermission'] = include 'private/permissions/users.php';

$GLOBALS['db'] = include 'private/settings/database.php';
include 'httpful.phar';
include 'vendor/autoload.php';


use Whoops\Handler\PrettyPageHandler;
use Whoops\Handler\JsonResponseHandler;

$run     = new Whoops\Run;
$handler = new PrettyPageHandler;

// Set the title of the error page:
$handler->setPageTitle("Whoops! There was a problem.");
$run->pushHandler($handler);

// Add a special handler to deal with AJAX requests with an
// equally-informative JSON response. Since this handler is
// first in the stack, it will be executed before the error
// page handler, and will have a chance to decide if anything
// needs to be done.
if (Whoops\Util\Misc::isAjaxRequest()) {
    $run->pushHandler(new JsonResponseHandler);
}

// Register the handler with PHP, and you're set!
$run->register();



foreach ( glob( __DIR__ . '/private/core/*.php' ) as $item ) {
    require_once $item;
}

foreach ( glob( __DIR__ . '/private/interfaces/*.php' ) as $item ) {
    require_once $item;
}

foreach ( glob( __DIR__ . '/private/traits/*.php' ) as $item ) {
    require_once $item;
}
foreach ( glob( __DIR__ . '/private/controllers/*.php' ) as $item ) {
    require_once $item;
}

foreach ( glob( __DIR__ . '/private/models/*.php' ) as $item ) {
    require_once $item;
}

foreach ( glob( __DIR__ . '/private/views/*.php' ) as $item ) {
    require_once $item;
}

foreach ( glob( __DIR__ . '/private/exceptions/*.php' ) as $item ) {
    require_once $item;
}


$bootstrap = new Bootstrap();