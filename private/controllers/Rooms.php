<?php

class Rooms extends Controller {

    public function __construct( $private ) {
        parent::__construct( $private );
    }

    public function index(  ) {
        echo 'index';
    }
}