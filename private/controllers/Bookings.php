<?php


use PHPMailer\PHPMailer\PHPMailer;

class Bookings extends Controller
{
    use DateComparator;

    public function __construct($private)
    {
        parent::__construct($private);
    }


    public function showForms()
    {
        $this->menu();
        new View(['header', 'bookingForm']);
    }

    /**
     * To know which is the index you should check the constructor of each class
     * Get All bookings
     * Get
     */
    public function checkAvailableRooms()
    {
        $this->menu();
        new View(['showDates'], [
                'startDate' => $_POST['start_date'],
                'endDate' => $_POST['end_date']
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

        # Loop through all the room types
        foreach ($allRoomTypes as $key => $item) {
            $rooms = new Room();
            $roomsList = $rooms->whereFkRoomTypesIdNameId($item[0]);

            foreach ($roomsList as $roomArray) {
                $tmpRoom = new Room();
                $tmpRoom->setData($roomArray);
                if ($tmpRoom->booked == '1') {
                    // Check availability of this room
                    $bookingsByRoomId = $booking->getBookingsByRoomId($tmpRoom->id);
                    foreach ($bookingsByRoomId as $value) {
                        $boolean = $booking->isBetweenDates($value->start_date, $_POST['start_date'], $_POST['end_date']);
                        $boolean2 = $booking->isBetweenDates($value->end_date, $_POST['start_date'], $_POST['end_date']);
                        if (!$boolean && !$boolean2) {
                            # If i set this key will not be repeated the values
                            $resultAllRoomTypes[$item[1]] = $item;
                        }

                    }
                } else {
                    $resultAllRoomTypes[] = $item;
                }
            }

            // If the room types don't have any room available take it out of the array
            $counter = 0;
            foreach ($roomsList as $room) {
                if ($item[1] == $room[6]) {
                    if ($room[6])
                        $counter++;
                }
            }
            if ($counter == 0)
                unset($allRoomTypes[$key]);
        }
        echo '<pre>$resultAllRoomTypes' . print_r($resultAllRoomTypes, true) . '</pre>';
        new View(['roomTypesListJavascript'], [], ['roomsTypesListWidget' => [
            'data' => $resultAllRoomTypes
        ]]);

    }

    public function sendMails()
    {
        $hashDni = hash('ripemd160', $_POST['dni']);
        $booking = new Booking();
        try {
            $bookingID = $booking->insertAndGetInsertedId([
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
        } catch (DBException $e) {
        }

        //        $b = $booking->allByUser2($_POST['dni']);
        $this->session->setVar('bid', $bookingID);

        $mail = new PHPmailer(true);
        try {
            $mail->SMTPDebug = 2;                                 // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp.mailtrap.io';  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'b60d9737a082fa';                 // SMTP username
            $mail->Password = 'dd045f921efd0a';             // SMTP password
            $mail->Subject = 'ola k ase';
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 465;
            $mail->CharSet = "UTF-8";                          // TCP port to connect to

            //Recipients
            $mail->setFrom('daw2jponspons@iesjoanramis.org', 'Josep');
            $mail->addAddress($_POST['email'], 'Joe User');     // Add a recipient

            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Here is the subject';
            $mail->Body = "Hello <a href='http://hotel.dev/bookings/confirmBookingDNIForm?dni=$hashDni&bid={$bookingID}'>Confirm</a>";
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }
        //        $user = new User($_POST['email'], '', $_POST['dni'], true);

        header('Location: ' . FORM_ACTION . '/');
    }

    public function confirmBookingDNIForm()
    {
        $this->menu();
        $bid = $this->session->getVar('bid');
        echo '<pre>$bid' . print_r($bid, true) . '</pre>';

        new View(['confirmBookingDNIForm'], ['dni' => $_GET['dni'], 'bid' => $_GET['bid']]);
    }

    public function confirmBookingDNI()
    {
        $this->menu();
        if (hash('ripemd160', $_POST['dni']) == $_GET['dni']) {
            $booking = new Booking();
            $booking->update(['confirmed' => '1'], $_GET['bid']);
            new VIew(['confirmed'], ['message' => 'PERFECT Booking confirmed']);
        } else {
            new VIew(['confirmed'], ['message' => 'ERROR the DNI introduced is not correct']);
        }
    }

    public function confirmBooking()
    {
        $this->menu();
        $roomType = new RoomType();
        $roomTypes = $roomType->getById($_GET['room_type_id']);

        $days = strtotime($_GET['end_date']) - strtotime($_GET['start_date']);
        $numberDays = $days / 86400;

        new View(['confirmBooking'], [
            'startDate' => $_GET['start_date'],
            'endDate' => $_GET['end_date'],
            'roomType' => $roomTypes[0][1],
            'price' => $numberDays * $roomTypes [2],
        ]);

    }

    public function loginByDNIForm()
    {
        $this->menu();
        new View(['loginByDNIForm']);
    }

    public function loginByDNI()
    {
        $this->menu();
        $booking = new Booking();
        $bookings = $booking->where('fk_users_dni_dni', $_POST['dni']);
        echo '<pre>$bookings[0]' . print_r($bookings, true) . '</pre>';
        //        new View( [], [], [ 'TableWidget' => [
        //            'id' => $bookings->id
        //        ] ] );
    }

    public function index()
    {
        $this->menu();

        try {
            $booking = new Booking();
            $booking->getAllBookings();
            $elements = $booking->getAllBookings(['id', 'start_date', 'end_date', 'fk_users_dni_dni', 'room_type']);


            new View(['bookingsSearch'], ['patterns' => 'name,start_date,end_date,dni,room_type,adults_number,children_number']);

            new View([], [], ['TableWidget' => [
                'fields' => ['id', 'start_date', 'end_date', 'room_type', 'fk_users_dni_dni', 'edit', 'delete'],
                'values' => $elements,
                'editable' => true,
                'editURI' => '/bookings/edit?id=',
                'editNum' => 0,
                'deletable' => true,
                'deleteURI' => '/bookings/destroy?id=',
                'deleteNum' => 0
            ]]);
        } catch (DBException $e) {
        }
    }

    public function return()
    {
        try {
            $booking = new Booking();
            if (isset($_GET['id'])) {
                $booking->return($_GET['id']);
            }

            header('Location: ' . FORM_ACTION . '/bookings/index');

        } catch (DBException $e) {
        }
    }

    public function booking()
    {
        $pickUp = $_POST['pickUp'];

        $toSum = '';

        $book = new Book();
        $conservation = $book->getConservationById($_GET['bookId']);

        $paramethers = new BookParamether();


        if ($conservation == 'old') {
            $toSum = "+{$paramethers->old}days";
        } elseif ($conservation == 'normal') {
            $toSum = "+{$paramethers->normal}days";
        } else {
            $toSum = "+{$paramethers->new}days";
        }

        $pickOff = date('m/d/Y', strtotime($pickUp . $toSum));
        $elements = [
            'pick_up' => $_POST['pickUp'],
            'pick_off' => $pickOff,
            'user_email' => $this->session->getVar('userEmail'),
            'book_id' => $_GET['bookId']
        ];
        $booking = new Booking();
        $booking->newBooking($elements);
        header('Location: ' . FORM_ACTION . '/books/details?id=' . $_GET['bookId']);
    }


    public function by()
    {
        $this->menu();
        $searcher = explode(':', $_REQUEST['textSearcher']);
        $_REQUEST['key'] = $searcher[0];
        $_REQUEST['value'] = $searcher[1];

        $tp = $this->byKeyValue($_REQUEST['key'], $_REQUEST['value']);

//        switch ($_REQUEST['key']) {
//            case 'start_date':
//                $tp = $this->byKeyValue($_REQUEST['key'], $_REQUEST['value']);
//                break;
//            case 'bookId':
//                $tp = $this->byBookId($_POST['text']);
//                break;
//            case 'notReturned':
//                $tp = $this->byNotReturned('past');
//                break;
//            case 'todayReturn':
//                $tp = $this->byNotReturned('today');
//                break;
//            default:
//                if (!isset($_POST['text'])) {
//                    $_POST['text'] = $_GET['text'];
//                }
//                $tp = $this->byBookId($_POST['text']);
//                break;
//        }

        new View(['bookingsSearch'], [], ['TableWidget' => [
            'fields' => ['id', 'Start Date', 'End Date', 'User DNI', 'Room Type'],
            'values' => $tp,
            'editable' => true,
            'editURI' => '/bookings/return?id=',
            'editNum' => 0
        ]]);

    }

    private function byKeyValue($key, $value)
    {
        try {
            $booking = new Booking();
            $bookings = $booking->where($key, $value, ['id', 'start_date', 'end_date', 'fk_users_dni_dni', 'room_type']);
            // Remove result of fk_users_dni_dni
            foreach ($bookings as $k => $b) {
                unset($bookings[$k][count($b) - 1]);
            }
            return $bookings;
        } catch (DBException $e) {
        }
    }

    public function byUserEmail($text)
    {
        try {
            $booking = new Booking();
            $bookings = $booking->byEmail($text);

            return $bookings;
        } catch (DBException $e) {
        }
    }

    public function byBookId($text = '')
    {
        if ($text == '') {
            if (!isset($_POST['text'])) {
                $_POST['text'] = $_GET['text'];
            }
            $text = $_POST['text'];

            $booking = new Booking();
            $bookings = $booking->byBookId($text);

            return $bookings;
        } else {
            $booking = new Booking();
            $bookings = $booking->byBookId($text);

            return $bookings;
        }
    }

    // need to search by e-mail too
    public function byNotReturned($pastOrToday = 'past')
    {
        $b = new Booking();
        $bookings = $b->getAllBookings();

        $return = [];


        foreach ($bookings as $index => $booking) {
            if ($pastOrToday == 'past') {
                if (strtotime(date('m/d/Y')) > strtotime($booking[4])) {
                    $return[] = $booking;
                }
            } elseif ($pastOrToday == 'today') {
                if (strtotime(date('m/d/Y')) == strtotime($booking[4])) {
                    $return[] = $booking;
                }
            }
        }

        return $return;
    }


    public function currentUser()
    {
        try {
            $booking = new Booking();
            $history = $booking->bookingsWhere('fk_users_dni_dni', $this->session->getVar('userDNI'), ['id', 'start_date', 'end_date', 'confirmed']);

            new View(['header'], [], ['MenuWidget' => [
                'userType' => $this->session->getVar('userType')
            ]]);

            new View(['bookingsSearchOnlyID', 'tmpPushJS'], [], ['TableWidget' => [
                'fields' => ['id', 'Start Date', 'End Date', 'Confirmed', 'Edit', 'Delete'],
                'values' => $history,
                'editable' => true,
                'editURI' => '/bookings/edit?id=',
                'editNum' => 0,
                'deletable' => true,
                'deleteURI' => '/bookings/destroy?id=',
                'deleteNum' => 0
            ]]);
        } catch (DBException $e) {
        }
    }

    /**
     * @throws Exception
     */
    public function edit()
    {

        $this->menu();
        $booking = new Booking();
        $currentBooking = $booking->getBookingById($_GET['id'], ['start_date', 'end_date', 'room_type']);
        $history = $booking->bookingsWhere('fk_users_dni_dni', $this->session->getVar('userDNI'), ['id']);

        $array = [];

        foreach ($history as $item) {
            $array[] = $item[0];
        }

        if (!in_array($_GET['id'], $array))
            throw new Exception('You aren\'t the owner of this booking', 403);

        new View(['editBooking', 'editBookingJS'], [
            'id' => $_GET['id'] ?? '',
            'start_date' => $currentBooking[0],
            'end_date' => $currentBooking[1],
            'roomType' => $currentBooking[2],
        ]);
    }


    public function update()
    {

        $booking = new Booking();
        $numberOfRooms = $booking->howManyRoomsAvaliable($_REQUEST['room_type'], $_REQUEST['start_date'], $_REQUEST['end_date']);

        if ($numberOfRooms > 0) {
            try {
                $booking->update(['start_date' => $_REQUEST['start_date'], 'end_date' => $_REQUEST['end_date']], $_REQUEST['id']);
                header('Location: ' . FORM_ACTION . '/bookings/currentUser');
            } catch (DBException $e) {
            }
        }

//        $booking = new Booking();
//        # TODO: @JosepPons if date is not between another booking
//        echo '<pre>$_REQUEST' . print_r($_REQUEST, true) . '</pre>';
////        die;
//        try {
//            $roomType = $booking->where('id', $_GET['id'], ['room_type']);
//            $bookings = $booking->where('room_type', $roomType[0][0], ['id', 'start_date', 'end_date']);
//            echo '<pre>$roomType' . print_r($roomType, true) . '</pre>';
//            echo '<pre>$bookings' . print_r($bookings, true) . '</pre>';
//            $betweens = [];
//            foreach ($bookings as $item) {
//                $betweens[] = $this->dateBetween(['start_date' => $item[1], 'end_date' => $item[2]], ['start_date' => $_REQUEST['start_date'], 'end_date' => $_REQUEST['end_date']]);
//            }
//            if (in_array(true, $betweens)){
//                var_dump($betweens);
//            }
//            die;
//            /**
//             * TODO: @JosepPons Look all bookings that it has the same room type and then check that non of the bookings has the dates between
//             */
//            $booking->update(['start_date' => $_POST['start_date'], 'end_date' => $_POST['end_date']], $_GET['id']);
//        } catch (DBException $e) {
//        }
//        header('Location: ' . FORM_ACTION . '/bookings/currentUser');

    }

    public function destroy()
    {
        try {
            $booking = new Booking();
            if (!empty($_GET['id'])) {
                $booking->destroy((int)$_GET['id']);
            }
        } catch (DBException $e) {
        }
        header('Location: ' . FORM_ACTION . '/bookings/currentUser');
    }

    public function toOtherUser()
    {
        new View(['header']);
        new View([], [], ['MenuWidget' => [
            'userType' => $this->session->getVar('userType')
        ]]);

        new View(['toOtherUserBooking']);

    }

    public function bookToOther()
    {
        echo '<pre>$_POST' . print_r($_POST, true) . '</pre>';


        $pickUp = $_POST['pickUp'];

        $toSum = '';

        $book = new Book();
        $conservation = $book->getConservationById($_POST['bookId']);

        $paramethers = new BookParamether();


        if ($conservation == 'old') {
            $toSum = "+{$paramethers->old}days";
        } elseif ($conservation == 'normal') {
            $toSum = "+{$paramethers->normal}days";
        } else {
            $toSum = "+{$paramethers->new}days";
        }


        $pickOff = date('m/d/Y', strtotime($pickUp . $toSum));
        $elements = [
            'pick_up' => $_POST['pickUp'],
            'pick_off' => $pickOff,
            'user_email' => $_POST['userEmail'],
            'book_id' => $_POST['bookId']
        ];
        $booking = new Booking();
        $booking->newBooking($elements);
        header('Location: ' . FORM_ACTION . '/bookings/toOtherUser');
    }

}