<?php


use PHPMailer\PHPMailer\PHPMailer;

class Bookings extends Controller {
    public function __construct( $private ) {
        parent::__construct( $private );
    }


    public function showForms() {
        $this->menu();
        new View( [ 'header', 'bookingForm' ] );
    }

    /**
     * To know which is the index you should check the constructor of each class
     * Get All bookings
     * Get
     */
    public function checkAvailableRooms() {
        $this->menu();
        new View( [ 'showDates' ], [
                'startDate' => $_POST[ 'start_date' ],
                'endDate' => $_POST[ 'end_date' ]
            ]
        );

        $booking = new Booking();
        //        $bookings = $booking->getBookingById(1)->start_date;
        $roomTypes = new RoomType();
        /**
         * Check if in the room type is there any room with a booking between the specified dates
         */

        $allRoomTypes = $roomTypes->getAll();

        $resultAllRoomTypes = [];


        foreach( $allRoomTypes as $key => $item ) {
            $rooms = new Room();
            $roomsList = $rooms->where( 'fk_roomtypes_id_name', $item[ 0 ] );

            foreach( $roomsList as $roomArray ) {
                $tmpRoom = new Room();
                $tmpRoom->setData( $roomArray );
                if( $tmpRoom->booked == '1' ) {
                    // Check availability of this room
                    $bookingsByRoomId = $booking->getBookingsByRoomId( $tmpRoom->id );
                    foreach( $bookingsByRoomId as $value ) {
                        $boolean = $booking->isBetweenDates( $value->start_date, $_POST[ 'start_date' ], $_POST[ 'end_date' ] );
                        $boolean2 = $booking->isBetweenDates( $value->end_date, $_POST[ 'start_date' ], $_POST[ 'end_date' ] );
                        if( !$boolean && !$boolean2 ) {
                            $resultAllRoomTypes[] = $item;
                        }

                    }
                } else {
                    $resultAllRoomTypes[] = $item;
                }
            }

            // If the room types don't have any room available take it out of the array
            $counter = 0;
            foreach( $roomsList as $room ) {
                if( $item[ 1 ] == $room[ 6 ] ) {
                    if( $room[ 6 ] )
                        $counter++;
                }
            }
            if( $counter == 0 )
                unset( $allRoomTypes[ $key ] );
        }

        new View( [ 'roomTypesListJavascript' ], [], [ 'roomsTypesListWidget' => [
            'data' => $resultAllRoomTypes
        ] ] );

    }

    public function sendMails() {
        $hashDni = hash('ripemd160', $_POST['dni']);
        $booking = new Booking();
        $booking->insert([
            'start_date' => $_GET['start_date'],
            'end_date' => $_GET['end_date'],
            'confirmed' => '0',
            'paid' => '0',
            'pay_method' => 'visa',
            'adults_number' => 2,
            'children_number' => 0,
            'fk_users_dni_dni' => $_POST['dni'],
            'fk_rooms_id_name' => 1,
            'room_type' => $_GET['room_type_id']
        ]);
        
        $mail = new PHPmailer( true );
        try {
            $mail->SMTPDebug = 2;                                 // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp.mailtrap.io';  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'b60d9737a082fa';                 // SMTP username
            $mail->Password = 'dd045f921efd0a';             // SMTP password
            //            $mail->setFrom('daw2jponspons@iesjoanramis.org', 'josep');
            $mail->Subject = 'ola k ase';
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 465;
            $mail->CharSet = "UTF-8";                          // TCP port to connect to

            //Recipients
            $mail->setFrom( 'daw2jponspons@iesjoanramis.org', 'Josep' );
            $mail->addAddress( $_POST['email'], 'Joe User' );     // Add a recipient
            //            $mail->addAddress('ellen@example.com');               // Name is optional
            //            $mail->addReplyTo('info@example.com', 'Information');
            //            $mail->addCC('cc@example.com');
            //            $mail->addBCC('bcc@example.com');

            //Attachments
            //            $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
            //            $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

            //Content
            $mail->isHTML( true );                                  // Set email format to HTML
            $mail->Subject = 'Here is the subject';
            $mail->Body = "<a href='http://hotel.dev/bookings/confirmBookingDNIForm?dni=$hashDni'>Confirm</a>";
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            echo 'Message has been sent';
        } catch( Exception $e ) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }
        header('Location: ' . FORM_ACTION . '/');
    }

    public function confirmBookingDNIForm(  ) {
        $this->menu();
        new View(['confirmBookingDNIForm'], ['dni' => $_GET['dni']]);
    }

    public function confirmBookingDNI(  ) {
        $this->menu();
        if(hash('ripemd160', $_POST['dni']) == $_GET['dni']){
            $booking = new Booking();
            $booking->update(['confirmed' => '1'], 2);
            new VIew(['confirmed'], ['message' => 'PERFECT Booking confirmed']);
        } else {
            new VIew(['confirmed'], ['message' => 'ERROR the DNI introduced is not correct']);
        }
    }

    public function confirmBooking() {
        $this->menu();
        $roomType = new RoomType();
        $roomTypes = $roomType->getById( $_GET[ 'room_type_id' ] );

        $days = strtotime($_GET['end_date']) - strtotime($_GET['start_date']);
        $numberDays = $days/86400;

        new View( [ 'confirmBooking' ], [
            'startDate' => $_GET[ 'start_date' ],
            'endDate' => $_GET[ 'end_date' ],
            'roomType' => $roomTypes[0][1],
            'price' => $numberDays * $roomTypes[0][2],
        ] );

    }

    public function index() {
        $booking = new Booking();
        $booking->getAllBookings();
        $elements = $booking->getAllBookings( [ 'id', 'fk_users_dni_dni', 'start_date', 'end_date' ] );

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

    public function return() {
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
                $tp = $this->byNotReturned( 'past' );
                break;
            case 'todayReturn':
                $tp = $this->byNotReturned( 'today' );
                break;
            default:
                if( !isset( $_POST[ 'text' ] ) ) {
                    $_POST[ 'text' ] = $_GET[ 'text' ];
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
            if( !isset( $_POST[ 'text' ] ) ) {
                $_POST[ 'text' ] = $_GET[ 'text' ];
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
    public function byNotReturned( $pastOrToday = 'past' ) {
        $b = new Booking();
        $bookings = $b->getAllBookings();

        $return = [];


        foreach( $bookings as $index => $booking ) {
            if( $pastOrToday == 'past' ) {
                if( strtotime( date( 'm/d/Y' ) ) > strtotime( $booking[ 4 ] ) ) {
                    $return[] = $booking;
                }
            } elseif( $pastOrToday == 'today' ) {
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

    public function toOtherUser() {
        new View( [ 'header' ] );
        new View( [], [], [ 'MenuWidget' => [
            'userType' => $this->session->getVar( 'userType' )
        ] ] );

        new View( [ 'toOtherUserBooking' ] );

    }

    public function bookToOther() {
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
            'user_email' => $_POST[ 'userEmail' ],
            'book_id' => $_POST[ 'bookId' ]
        ];
        $booking = new Booking();
        $booking->newBooking( $elements );
        header( 'Location: ' . FORM_ACTION . '/bookings/toOtherUser' );
    }

}