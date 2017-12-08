<?php


class AdditionalService extends DB
{

    /**
     * AdditionalService constructor.
     * @param string $charset
     */
    public function __construct($charset = 'UTF8')
    {
        try {
            parent::__construct($charset);
            $this->setTable('additional_services');
            $this->setFields(['id', 'text', 'price']);
        } catch (DBException $e) {
        } catch (VarNoInitializedException $e) {
        }

    }

    public function all($fields = [])
    {
        try {
            return $this->select($fields);
        } catch (DBException $e){}
    }

}