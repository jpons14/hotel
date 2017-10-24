<?php

class Room extends DB {
    public function __construct( ) {
        parent::__construct( );
        $this->setTable('rooms');
        $this->setFields(['id', 'fk_roomtypes_id_name', 'adults_max_number', 'children_max_number', 'name']);
    }

    public function getAll(  ) {
        return $this->select();
    }

    public function getOnParamether( $paramether ) {
        if(!is_string($paramether) || $paramether === '')
            throw new NoCompatibleVarTypeException('$paramether must be a string');

        return $this->select([$paramether]);
    }

}