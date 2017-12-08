<?php
/**
 * Created by PhpStorm.
 * User: josep
 * Date: 24/10/2017
 * Time: 15:34
 */

class RoomType extends DB
{
    public function __construct()
    {
        parent::__construct();
        $this->setTable('roomtypes');
        $this->setFields(['id', 'name', 'price']);
    }

    public function getAll($fields = [])
    {
        try {
            return $this->select($fields);
        } catch (DBException $e) {
        }
    }

    public function getById($id)
    {
        try {
            return $this->find($id)[0];
        } catch (DBException $e) {
        }
    }

    public function __set($name, $value)
    {
        // TODO: Implement __set() method.
    }


    public function __get($name)
    {
        try {
            return $this->select([$name]);
        } catch (DBException $e) {
        }
    }


}