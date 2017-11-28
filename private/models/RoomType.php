<?php
/**
 * Created by PhpStorm.
 * User: josep
 * Date: 24/10/2017
 * Time: 15:34
 */

class RoomType extends DB{
    public function __construct( ) {
        parent::__construct( );
        $this->setTable('roomtypes');
        $this->setFields(['id', 'name', 'price']);
    }

    public function getAll( $fields = [] ) {
        return $this->select($fields);
    }

    public function getById( $id ) {
        return $this->find($id)[0];
    }

    public function __set( $name, $value ) {
        // TODO: Implement __set() method.
    }


    public function __get( $name ) {
        return $this->select([$name]);
    }


}