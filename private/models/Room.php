<?php

class Room extends DB implements ArrayAccess {

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

    public function whereFkRoomTypesIdNameId( $id ) {
        $data = $this->where( 'fk_roomtypes_id_name', $id );
        $this->setData($data[0]);
        return $data;
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

    /**
     * Whether a offset exists
     * @link http://php.net/manual/en/arrayaccess.offsetexists.php
     * @param mixed $offset <p>
     * An offset to check for.
     * </p>
     * @return boolean true on success or false on failure.
     * </p>
     * <p>
     * The return value will be casted to boolean if non-boolean was returned.
     * @since 5.0.0
     */
    public function offsetExists( $offset ) {
        // TODO: Implement offsetExists() method.
    }

    /**
     * Offset to retrieve
     * @link http://php.net/manual/en/arrayaccess.offsetget.php
     * @param mixed $offset <p>
     * The offset to retrieve.
     * </p>
     * @return mixed Can return all value types.
     * @since 5.0.0
     */
    public function offsetGet( $offset ) {
        // TODO: Implement offsetGet() method.
    }

    /**
     * Offset to set
     * @link http://php.net/manual/en/arrayaccess.offsetset.php
     * @param mixed $offset <p>
     * The offset to assign the value to.
     * </p>
     * @param mixed $value <p>
     * The value to set.
     * </p>
     * @return void
     * @since 5.0.0
     */
    public function offsetSet( $offset, $value ) {
    }

    /**
     * Offset to unset
     * @link http://php.net/manual/en/arrayaccess.offsetunset.php
     * @param mixed $offset <p>
     * The offset to unset.
     * </p>
     * @return void
     * @since 5.0.0
     */
    public function offsetUnset( $offset ) {
        // TODO: Implement offsetUnset() method.
    }
}