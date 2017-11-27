<?php

class UserType extends DB{
    public function __construct() {
        parent::__construct();
        $this->setTable('usertypes');
        $this->setFields(['id', 'usertypename', 'permissions']);
    }

    public function getAll(  ) {
        $result = [];
        foreach( $this->select() as $key => $item ) {
            $result[$item[1]] = $item[0];
        }
        return $result;
    }

}