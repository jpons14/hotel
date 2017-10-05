<?php

abstract class FatherWidget {

    protected $vars;

    public function __construct( $vars ) {
        $this->vars = $vars;
    }

    public abstract function __toString();
}