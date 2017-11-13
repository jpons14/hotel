<?php

class Room extends DB {

    private $id;

    private $fk_roomtypes_id_name;

    private $adults_max_number;

    private $children_max_number;

    private $name;

    /**
     * @var boolean
     */
    private $booked;

    private $roomtype_name;

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

    public function __get( $name ) {
        return $this->$name;
    }


    public function getAll() {
        return $this->select();
    }

    /**
     * @param $id
     * @return Room $this
     */
    public function getById( $id ) {
        $where = $this->where( 'id', $id, $this->fields );
        $this->setData($where);

        return $this;
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

    /**
     * 0 => id
     * 1 => fk_roomtypes_id_name
     * 2 => adults_max_number
     * 3 => children_max_number
     * 4 => room name
     * 5 => booked [0 = no, 1 = yes]
     * 6 => room type real name
     * @param $data
     */
    public function setData( $data ) {
        $this->id = $data[0];
        $this->fk_roomtypes_id_name = $data[1];
        $this->adults_max_number = $data[2];
        $this->children_max_number = $data[3];
        $this->name = $data[4];
        $this->booked = $data[5];
        $this->roomtype_name = $data[6];
    }

}