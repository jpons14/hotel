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

foreach ( glob( __DIR__ . '/private/core/*.php' ) as $item ) {
    require_once $item;
}

foreach ( glob( __DIR__ . '/private/interfaces/*.php' ) as $item ) {
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