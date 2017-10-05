<?php
#### TEMPORAL ####

//error_reporting( E_ALL ^ E_NOTICE);
// Just used for widgets
$GLOBALS['formAction'] = '/';

// Used for everything less widgets
define('FORM_ACTION', '/');

$GLOBALS['systemRoot'] = '' . FORM_ACTION;
define('SYSTEM_ROOT', '' . FORM_ACTION);

define('IMG_USERS', '' . FORM_ACTION . '/public/assets/img/users/');




$GLOBALS['controllerAndAction'] = include 'private/permissions/controllerAndAction.php';
$GLOBALS['usersPermission'] = include 'private/permissions/users.php';

$GLOBALS['db'] = include 'private/settings/database.php';
include 'httpful.phar';

echo 'before bootstrapd'; die;
foreach ( glob( __DIR__ . '/private/core/*.php' ) as $item ) {
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