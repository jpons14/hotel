<?php 
class UserPermissions {
    private $vars;

    public function __construct($vars){
        $this->vars = $vars;
    }


    public function isNotMember(){
        return $GLOBALS[ 'usersPermission' ][ $this->vars[ 'userType' ] ] == $GLOBALS[ 'usersPermission' ][ 'non-member' ];
    }

    public function isMember(){
        return $GLOBALS[ 'usersPermission' ][ $this->vars[ 'userType' ] ] >= $GLOBALS[ 'usersPermission' ][ 'member' ];
    }

    public function isHotelier(){
        return $GLOBALS[ 'usersPermission' ][ $this->vars[ 'userType' ] ] >= $GLOBALS[ 'usersPermission' ][ 'hotelier' ] ;
    }

    public function isRoot(){
        return  $GLOBALS[ 'usersPermission' ][ $this->vars[ 'userType' ] ] >= $GLOBALS[ 'usersPermission' ][ 'root' ];
    }
}