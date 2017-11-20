<?php


class PermissionException extends Exception {
    public function __construct( $message ) {
        parent::__construct( $message );
    }

    public function showException() {
        echo '<div style="background-color: #e95353; border: black 2px solid; font-size: 2em"> ' . $this->message . '</div>';
        echo "<div style='background-color: #e95353; border: black 1px solid; font-size: 2em'><a href='$GLOBALS[formAction]/users/login?from=nep'> Do login to continue </a></div>";
        exit();
    }

}