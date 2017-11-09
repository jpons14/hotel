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

    protected function menu(){
        $user = new User( $this->session->getVar( 'userEmail' ) );
        new View( [ 'header' ] );
        new View( [], [], [ 'MenuWidget' => [
            'userType' => $this->session->getVar( 'userType' )
        ] ] );
    }
}