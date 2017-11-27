<?php


class DBException extends Exception implements Throwable {
    public function __construct( $message ) {
        parent::__construct( $message );
    }

//    public function showException() {
//        echo '<div style="background-color: #ff3833; border: black 2px solid; font-size: 2em"> ' . $this->message . '</div>';
//        exit();
//    }

}