<?php

use Whoops\Handler\JsonResponseHandler;
use Whoops\Handler\PrettyPageHandler;


/**
 * This class will manage Everything
 * Class Bootstrap
 */
class Bootstrap {


    public function __construct() {

        $run     = new Whoops\Run;
        $handler = new PrettyPageHandler;

// Set the title of the error page:
        $handler->setPageTitle("Whoops! There was a problem.");
        $run->pushHandler($handler);

        if (Whoops\Util\Misc::isAjaxRequest()) {
            $run->pushHandler(new JsonResponseHandler);
        }

        $run->register();


        $uri = urldecode(
            parse_url( $_SERVER[ 'REQUEST_URI' ], PHP_URL_PATH )
        );
        $uri = explode( '/', $uri );
        $count = count( $uri );

        if( isset( $_GET[ 'controller' ] ) ) {
            $_GET[ 'controller' ] = ucwords( $uri[ $count - 2 ] );
        } else {
            $_GET[ 'controller' ] = 'Bookings';
        }
        if( isset( $_GET[ 'action' ] ) ) {
            $_GET[ 'action' ] = $uri[ $count - 1 ];
        } else {
            $_GET[ 'action' ] = 'showForms';
        }


        $security = new Security( $_GET[ 'controller' ], $_GET[ 'action' ] );
        try {
            if( $security->checkPermissions() ) {
                $this->callController( $security->private );
            }
        } catch( PermissionException $e ) {
            setcookie('nep_get', json_encode($_GET), time() + (60 * 20), '/');
            echo '<pre>$_GET' . print_r( $_GET, true ) . '</pre>';
            echo $e->showException();
        }
    }


    public function callController( $private ) {
        if( isset( $_GET[ 'controller' ] ) && isset( $_GET[ 'action' ] ) ) {
            $tmp = new $_GET[ 'controller' ]( $private );
            $action = $_GET[ 'action' ];
            $tmp->$action();

            return true;
        }

        return true;
    }

}