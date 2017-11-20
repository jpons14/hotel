<?php


/**
 * This class will manage Everything
 * Class Bootstrap
 */
class Bootstrap {


    public function __construct() {
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
            echo '<pre>$_GET' . print_r( $_GET, true ) . '</pre>';
            setcookie('nep_get', json_encode($_GET), time() + (60 * 20), '/');
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