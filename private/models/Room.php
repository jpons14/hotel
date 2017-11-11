<?php

class Room extends DB {
    /**
     * 0 => id
     * 1 => fk_roomtypes_id_name
     * 2 => adults_max_number
     * 3 => children_max_number
     * 4 => room name
     * 5 => booked [0 = no, 1 = yes]
     * 6 => room type real name
     * Room constructor.
     */
    public function __construct() {
        parent::__construct();
        $this->setTable( 'rooms' );
        $this->setFields( [ 'id', 'fk_roomtypes_id_name', 'adults_max_number', 'children_max_number', 'name', 'booked' ] );
    }

    public function getAll() {
        return $this->select();
    }

    /**
     * @param $id
     * @return array|null
     */
    public function getById( $id ) {
        return $this->where( 'id', $id, $this->fields );
    }

    /**
     * @param $paramether
     * @return array|null
     * @throws NoCompatibleVarTypeException
     */
    public function getOnParamether( $paramether ) {
        if( !is_string( $paramether ) || $paramether === '' )
            throw new NoCompatibleVarTypeException( '$paramether must be a string' );

        return $this->select( [ $paramether ] );
    }

    /**
     * @param array $values
     */
    public function addRoom( array $values ) {
        $this->insert( $values );
    }


}