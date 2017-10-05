<?php

class Security {
    /**
     * $permissions [ controller1 => [ action1, action2], controller2 => [action1, action2]]
     * @var array
     */
    private $controllerAndAction;

    /**
     * @var array
     */
    private $usersPermission;

    /**
     * if private == false = free action
     * @var bool
     */
    public $private = false;


    public function __construct( $controller, $action ) {
        $this->controllerAndAction = $GLOBALS[ 'controllerAndAction' ];
        $this->usersPermission = $GLOBALS[ 'usersPermission' ];
    }

    public function checkPermissions() {
        if( array_key_exists( $_GET[ 'action' ], $this->controllerAndAction[ $_GET[ 'controller' ] ] ) ) {
            // The action is not free so, check if the user has permissions
            $session = new Session();
            if( !isset( $_SESSION[ 'userType' ] ) ) {
                $session->setVar( 'userType', 'non-member' );
                header('Location: ' . FORM_ACTION . '/');
            } else {
                // if has permission
                if( $this->usersPermission[ $_SESSION[ 'userType' ] ] >= $this->controllerAndAction[ $_GET[ 'controller' ] ][ $_GET[ 'action' ] ] ) {
                    $this->private = true;
                    return true; // private although the user has enough permissions
                } else {
                    throw new Exception( 'You don\'t have enough permissions to do that' );

                    return false;
                }
            }
        } else {
            // is free so return true
            $this->private = false;

            return true;
        }

    }

}