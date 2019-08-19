<?php

abstract class FatherWidget {

    protected $vars;

    protected $user;

    public function __construct( $vars ) {
        $this->vars = $vars;
        $this->user = new UserPermissions($vars);
    }

    public abstract function __toString();
}