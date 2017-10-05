<?php

/**
 * Created by PhpStorm.
 * User: josep
 * Date: 12/06/2017
 * Time: 17:26
 */
class BookParamether extends DB {

    private $new;

    private $normal;

    private $old;

    public function __construct( $charset = 'UTF8' ) {
        parent::__construct( $charset );
        $this->setTable( 'book_paramether' );
        $this->setFields( [ 'conservation', 'days' ] );

        $this->refresh();
    }

    // from the values of the DB to the attributes
    public function refresh() {
        $all = $this->getAll();

        $this->new = $all[ 0 ][ 1 ];
        $this->normal = $all[ 1 ][ 1 ];
        $this->old = $all[ 2 ][ 1 ];
    }

    public function __get( $what ) {
        if( !isset( $this->$what ) ) {
            $this->refresh();
        }

        return $this->$what;
    }


    public function getAll() {
        return $this->select();
    }

    public function getDaysByConservation( $conservation ) {
        return $this->where( 'conservation', $conservation );
    }

}