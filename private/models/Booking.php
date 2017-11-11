<?php

class Booking extends DB {

    private $conservation;

    private $id;
    private $start_date;
    private $end_date;
    private $confirmed;
    private $pay_method;
    private $paid;
    private $adults_number;
    private $children_number;
    private $room_type;
    private $fk_users_dni;
    private $room_name;


    /**
     * 0 => id
     * 1 => start_date
     * 2 => end_date
     * 3 => confirmed
     * 4 => pay_method
     * 5 => paid
     * 6 => adults_number
     * 7 => children_number
     * 8 => room_type
     * 9 => fk_users_dni
     * 10 => room_name
     * Booking constructor.
     * @param string $charset
     */
    public function __construct( $charset = 'UTF8' ) {
        parent::__construct( $charset );
        $this->setTable( 'bookings' );

        try {
            $this->setFields( [ 'id', 'start_date', 'end_date', 'confirmed', 'pay_method', 'paid', 'adults_number', 'children_number', 'fk_users_dni_dni', 'fk_rooms_id_name', 'room_type'] );
        } catch(VarNoInitializedException $e){
            $e->showException();
        }

        $this->conservation = [
            'old' => 5,
            'normal' => 10,
            'new' => 20
        ];

    }

    public function __get( $name ) {
        return $this->$name;
    }


    /**
     * @param $id
     * @return Booking $this
     */
    public function getBookingById( $id ) {
        if(is_int($id))
            $id = $id . '';

        $data = $this->where('id', $id);
        $this->setData($data);
        return $this;
    }

    public function getAllBookings( $elements = [] ) {
        if(empty($elements) || $elements == [])
            $elements = $this->fields;
        return $this->select( $elements );
    }

    public function allByUser( $userEmail ) {
        return $this->whereOrderBy( 'user_email', $userEmail, 'DESC' );
    }

    public function newBooking( array $elements ) {
        try {
            if( $this->isBooked( $elements ) ) {
                $this->insert( $elements );

                return true;
            } else {
                return false;
            }
        } catch( Exception $exception ) {
            echo '<pre>' . print_r( $exception->getMessage(), true ) . '</pre>';
        }
    }

    /**
     * @param array $elements
     * @return bool
     * @throws Exception
     */
    private function isBooked( array $elements ) {
        $where = $this->where( 'book_id', $elements[ 'book_id' ] );


        // 0-3 pick up
        // 0-4 pick off
        // TODO: refactor
        if( !$this->isBetweenDates( $elements[ 'pick_up' ], $where[ 0 ][ 3 ], $where[ 0 ][ 4 ] ) ) {
            if( !$this->isBetweenDates( $elements[ 'pick_off' ], $where[ 0 ][ 3 ], $where[ 0 ][ 4 ] ) ) {

                return true;
            } else {
                throw new Exception( 'The introduced date of "pick off" is not valid' );
            }
        } else {
            throw new Exception( 'The introduced date of "pick up" is not valid' );
        }

    }

    public function isBetweenDates( $date1, $between1, $between2 ) {
        $date1 = strtotime( $date1 );
        $between1 = strtotime( $between1 );
        $between2 = strtotime( $between2 );
        if( ( $between1 < $date1 ) && ( $between2 > $date1 ) ) {
            return true;
        } else {
            return false;
        }
    }

    public function byEmail( $email ) {
        ## TODO: refactor
        $all = $this->where( 'user_email', $email );
        foreach( $all as $index => $item ) {
            unset( $all[ $index ][ 5 ] );
        }

        return $all;
    }

    public function byBookId( $id ) {
        ## TODO: refactor
        $all = $this->where( 'book_id', $id );
        foreach( $all as $index => $item ) {
            unset( $all[ $index ][ 5 ] );
        }

        return $all;
    }

    public function return( $id ) {
        return $this->update( [ 'returned' => 1 ], $id );
    }

    /**
     *
     * 0 => id
     * 1 => start_date
     * 2 => end_date
     * 3 => confirmed
     * 4 => pay_method
     * 5 => paid
     * 6 => adults_number
     * 7 => children_number
     * 8 => room_type
     * 9 => fk_users_dni
     * 10 => room_name
     * @param $data
     */
    private function setData( $data ) {
        $this->id = $data[0];
        $this->start_date = $data[1];
        $this->end_date = $data[2];
        $this->confirmed = $data[3];
        $this->pay_method = $data[4];
        $this->paid = $data[5];
        $this->adults_number = $data[6];
        $this->children_number = $data[7];
        $this->room_type = $data[8];
        $this->fk_users_dni = $data[9];
        $this->room_name = $data[10];
    }

}