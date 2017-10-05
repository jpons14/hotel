<?php


class Controller {
    protected $session = false;

    protected $private;

    public function __construct( $private ) {
        $this->private = $private;
        if( $private ) {
            $this->session = new Session();
        }
    }
}