<?php

class Session {
    public function __construct() {
        if( session_status() == PHP_SESSION_NONE ) {
            session_start();
        }
    }

    public function show() {
        echo '<pre>$_SESSION' . print_r( $_SESSION, true ) . '</pre>';
    }

    public function getVar( $key ) {
        return $_SESSION[ $key ];
    }

    public static function getStaticVar( $key ) {
        return $_SESSION[ $key ];
    }

    public function setVar( $key, $value ) {
        $_SESSION[ $key ] = $value;
    }

    public function destroyVars() {
        foreach( $_SESSION as $index => $item ) {
            unset( $_SESSION[ 'index' ] );
        }
    }

    public function destroy() {
        $this->destroyVars();
        session_destroy();
        session_unset();
    }

}