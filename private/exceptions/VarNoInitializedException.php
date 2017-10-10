<?php


class VarNoInitializedException extends Exception {
    public function __construct( $message ) {
        parent::__construct( $message );
    }

    public function showException() {
        echo '<div style="background-color: #ff5724; border: black 1px solid; font-size: 1.5em"> ' . $this->message . '</div>';
        exit();
    }
}