<?php


class UserException extends Exception {
    public function __construct( $message, $url ) {
        session_start();
        $_SESSION[ 'loginError' ] = $message;
        unset( $_COOKIE[ 'PHPSESSID' ] );
        session_destroy();
        header( "Location: $url" );
    }

}