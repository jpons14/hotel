<?php


class Bookings extends Controller {
    public function __construct( $private ) {
        parent::__construct( $private );
    }

    public function index() {
        $booking = new Booking();
        $booking->getAllBookings();
        $elements = $booking->getAllBookings( [ 'id', 'fk_users_dni_dni', 'start_date', 'end_date' ] );
//        $returneds = $booking->getAllBookings( [ 'returned' ] );


//        $book = new Book();
//        $books = $book->getAll();

        foreach( $elements as $index => $element ) {
            if( $returneds[ $index ][ 0 ] == 1 ) {
                $elements[ $index ][ 2 ] = '<div class="alert alert-success"> ' . $elements[ $index ][ 2 ] . '</div>';
            }
            // if it's in the return day -> orange, if its late -> red
            if( strtotime( date( 'm/d/Y' ) ) == strtotime( $element[ 4 ] ) ) {
                $elements[ $index ][ 4 ] = '<div class="alert alert-warning">' . $element[ 4 ] . '</div>';
            } elseif( strtotime( date( 'm/d/Y' ) ) > strtotime( $element[ 4 ] ) ) {
                $elements[ $index ][ 4 ] = '<div class="alert alert-danger">' . $element[ 4 ] . '</div>';
            }

        }


        $user = new User( $this->session->getVar( 'userEmail' ) );
        $users = $user->getAllUsers( [ 'email' ] );


        new View( [ 'header' ] );
        new View( [], [], [ 'MenuWidget' => [
            'userType' => $this->session->getVar( 'userType' )
        ] ] );

        new View( [ 'bookingsSearch' ] );

        new View( [], [], [ 'TableWidget' => [
            'fields' => [ 'id', 'User Email', 'Book Name', 'Pick Up', 'Pick Off', 'Return' ],
            'values' => $elements,
            'editable' => true,
            'editURI' => '/bookings/return?id=',
            'editNum' => 0
        ] ] );
    }

    public function return () {
        $booking = new Booking();
        if( isset( $_GET[ 'id' ] ) ) {
            $booking->return( $_GET[ 'id' ] );
        }

        header( 'Location: ' . FORM_ACTION . '/bookings/index' );

    }

    public function booking() {
        $pickUp = $_POST[ 'pickUp' ];

        $toSum = '';

        $book = new Book();
        $conservation = $book->getConservationById( $_GET[ 'bookId' ] );

        $paramethers = new BookParamether();


        if( $conservation == 'old' ) {
            $toSum = "+{$paramethers->old}days";
        } elseif( $conservation == 'normal' ) {
            $toSum = "+{$paramethers->normal}days";
        } else {
            $toSum = "+{$paramethers->new}days";
        }

        $pickOff = date( 'm/d/Y', strtotime( $pickUp . $toSum ) );
        $elements = [
            'pick_up' => $_POST[ 'pickUp' ],
            'pick_off' => $pickOff,
            'user_email' => $this->session->getVar( 'userEmail' ),
            'book_id' => $_GET[ 'bookId' ]
        ];
        $booking = new Booking();
        $booking->newBooking( $elements );
        header( 'Location: ' . FORM_ACTION . '/books/details?id=' . $_GET[ 'bookId' ] );
    }

    public function by() {
        new View( [ 'header' ] );
        new View( [], [], [ 'MenuWidget' => [
            'userType' => $this->session->getVar( 'userType' )
        ] ] );

        $tp = [];

        switch( $_POST[ 'what' ] ) {
            case 'userEmail':
                $tp = $this->byUserEmail( $_POST[ 'text' ] );
                break;
            case 'bookId':
                $tp = $this->byBookId( $_POST[ 'text' ] );
                break;
            case 'notReturned':
                $tp = $this->byNotReturned('past');
                break;
            case 'todayReturn':
                $tp = $this->byNotReturned('today');
                break;
            default:
                if(!isset($_POST['text'])){
                    $_POST['text'] = $_GET['text'];
                }
                $tp = $this->byBookId( $_POST[ 'text' ] );
                break;
        }

        new View( [ 'bookingsSearch' ], [], [ 'TableWidget' => [
            'fields' => [ 'id', 'User Email', 'Book Name', 'Pick Up', 'Pick Off', 'Return' ],
            'values' => $tp,
            'editable' => true,
            'editURI' => '/bookings/return?id=',
                'editNum' => 0
        ] ] );

    }

    public function byUserEmail( $text ) {
        $booking = new Booking();
        $bookings = $booking->byEmail( $text );

        return $bookings;
    }

    public function byBookId( $text = '' ) {
        if( $text == '' ) {
            if(!isset($_POST['text'])){
                $_POST['text'] = $_GET['text'];
            }
            $text = $_POST[ 'text' ];

            $booking = new Booking();
            $bookings = $booking->byBookId( $text );

            return $bookings;
        } else {
            $booking = new Booking();
            $bookings = $booking->byBookId( $text );

            return $bookings;
        }
    }

    // need to search by e-mail too
    public function byNotReturned($pastOrToday = 'past') {
        $b = new Booking();
        $bookings = $b->getAllBookings();

        $return = [];


        foreach( $bookings as $index => $booking ) {
            if ($pastOrToday == 'past') {
                if( strtotime( date( 'm/d/Y' ) ) > strtotime( $booking[ 4 ] ) ) {
                    $return[] = $booking;
                }
            } elseif($pastOrToday == 'today'){
                if( strtotime( date( 'm/d/Y' ) ) == strtotime( $booking[ 4 ] ) ) {
                    $return[] = $booking;
                }
            }
        }
        return $return;
    }


    public function currentUser() {
        $booking = new Booking();
        $history = $booking->allByUser( $this->session->getVar( 'userEmail' ) );

        foreach( $history as $index => $item ) {


            if( strtotime( date( 'm/d/Y' ) ) == strtotime( $item[ 4 ] ) ) {
                $history[ $index ][ 4 ] = '<div class="alert alert-warning">' . $item[ 4 ] . '</div>';
            } elseif( strtotime( date( 'm/d/Y' ) ) > strtotime( $item[ 4 ] ) ) {
                $history[ $index ][ 4 ] = '<div class="alert alert-danger">' . $item[ 4 ] . '</div>';
            }
        }

        new View( [ 'header' ], [], [ 'MenuWidget' => [
            'userType' => $this->session->getVar( 'userType' )
        ] ] );

        new View( [ 'bookingsSearchOnlyID' ], [], [ 'TableWidget' => [
            'fields' => [ 'id', 'Book ID', 'User Email', 'Pick Up', 'Pick Off' ],
            'values' => $history
        ] ] );
    }

    public function toOtherUser(  ) {
        new View( [ 'header' ] );
        new View( [], [], [ 'MenuWidget' => [
            'userType' => $this->session->getVar( 'userType' )
        ] ] );

        new View(['toOtherUserBooking']);

    }

    public function bookToOther(  ) {
        echo '<pre>$_POST' . print_r( $_POST, true ) . '</pre>';


        $pickUp = $_POST[ 'pickUp' ];

        $toSum = '';

        $book = new Book();
        $conservation = $book->getConservationById( $_POST[ 'bookId' ] );

        $paramethers = new BookParamether();


        if( $conservation == 'old' ) {
            $toSum = "+{$paramethers->old}days";
        } elseif( $conservation == 'normal' ) {
            $toSum = "+{$paramethers->normal}days";
        } else {
            $toSum = "+{$paramethers->new}days";
        }


        $pickOff = date( 'm/d/Y', strtotime( $pickUp . $toSum ) );
        $elements = [
            'pick_up' => $_POST[ 'pickUp' ],
            'pick_off' => $pickOff,
            'user_email' => $_POST['userEmail'],
            'book_id' => $_POST[ 'bookId' ]
        ];
        $booking = new Booking();
        $booking->newBooking( $elements );
        header('Location: ' . FORM_ACTION . '/bookings/toOtherUser');
    }

}