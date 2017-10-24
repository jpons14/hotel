<?php

class Book extends DB {
    public function __construct() {
        parent::__construct();
        $this->setTable( 'books' );
        $this->setFields( [ 'id', 'title', 'author', 'description', 'conservation' ] );
    }

    /**
     * @param array $elements
     * @return bool|mysqli_result
     */
    public function addBook( array $elements ) {
        return $this->insert( $elements );
    }

    public function getConservationById( $id ) {

        $return = $this->where( 'id', $id );

        return $return[ 0 ][ 4 ];
    }

    /**\
     * @return array|null
     */
    public function getAll() {
        return $this->select();
    }

    public function searchByName( $name ) {
        return $this->like( 'title', $name );
    }

    public function searchByISBN( $isbn ) {
        return $this->where( 'id', $isbn );
    }


}