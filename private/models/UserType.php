<?php

class UserType extends DB{
    public function __construct() {
        parent::__construct();
        $this->setTable('user_types');
        $this->setFields(['user_type_name', 'permissions']);
    }

    public function getAll(  ) {
        $result = [];
        foreach( $this->select() as $key => $item ) {
            $result[$item[0]] = $item[1];
        }
        return $result;
    }

}