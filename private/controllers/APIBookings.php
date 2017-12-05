<?php

class APIBookings extends Controller implements ResourceInterface
{

    use DateComparator;

    public function __construct($private)
    {
        parent::__construct($private);
    }

    /**
     * Display a listing of the resource.
     * @return mixed
     */
    public function index()
    {
        try {
            $booking = new Booking();
            $history = $booking->bookingsWhere('fk_users_dni_dni', $this->session->getVar('userDNI'), ['id', 'start_date', 'end_date', 'confirmed']);

            header('Content-Type: application/json');
            echo json_encode($history);
        } catch (DBException $e) {
        }
    }

    /**
     * Show the form for creating a new resource.
     * @return mixed
     */
    public function create()
    {
        // TODO: Implement create() method.
    }

    /**
     * Store a newly created resource in storage.
     * @return mixed
     */
    public function store()
    {
        // TODO: Implement store() method.
    }

    /**
     * Display the specified resource.
     * @return mixed
     */
    public function show()
    {
        // TODO: Implement show() method.
    }

    /**
     * Show the form for editing the specified resource.
     * @return mixed
     */
    public function edit()
    {
        // TODO: Implement edit() method.
    }

    /**
     * Update the specified resource in storage.
     * @return mixed
     */
    public function update()
    {
        // TODO: Implement update() method.
    }

    /**
     * Remove the specified resource from storage.
     * @return mixed
     */
    public function destroy()
    {
        // TODO: Implement destroy() method.
    }

    public function calculatePrice()
    {
        $room = new Room();
        $rooms = $room->whereFkRoomTypesIdNameId($_GET['roomType']);

        $counter = 0;
        $booking = new Booking();

        $betweens = [];


        try {
//            $roomType = $booking->where('id', $_GET['roomType'], ['room_type']);
//            echo '<pre>$roomType' . print_r($roomType, true) . '</pre>';
            $bookings = $booking->where('room_type', $_GET['roomType'], ['id', 'start_date', 'end_date']);
            foreach ($bookings as $item) {
                $betweens[] = $this->dateBetween(['start_date' => $item[1], 'end_date' => $item[2]], ['start_date' => $_REQUEST['start_date'], 'end_date' => $_REQUEST['end_date']]);
            }

//            if (in_array(true, $betweens)){
                $howmanyrooms = $room->where('fk_roomtypes_id_name', $_GET['roomType'], ['id']);
                echo '<pre>$howManyRooms' . print_r($howmanyrooms, true) . '</pre>';
//            }



        } catch (DBException $e) {
            echo $e->getMessage();
        }


        foreach ($rooms->toArray() as $item) {
            if ($item['booked'] == 0) {
                $counter++;
            } else {
                try {
                    $bookings = $booking->where('room_type', $item['fk_roomtypes_id_name'], ['id', 'start_date', 'end_date']);
                    foreach ($bookings as $book) {
                        $bool = $booking->isBetweenDates($_GET['start_date'], $book[1], $book[2]);
                        if ($bool)
                            $counter++;
                    }
                } catch (DBException $e) {
                }
            }
        }


//        header('Content-Type: application/json');
//        if ($counter > 0) {
//            echo json_encode([$rooms->toArray()]);
//            echo json_encode(['number_rooms' => $counter]);
//        } else {
//            echo json_encode(['number_rooms' => 'no']);
//        }
        try {
            $roomType = new RoomType();
            $prices = $roomType->where('id', $_GET['roomType'], ['price']);
            $booking = new Booking();
            $days = strtotime($_GET['end_date']) - strtotime($_GET['start_date']);
            $numberDays = $days / 86400;

            header('Content-Type: application/json');
            echo json_encode(['price' => $prices[0][0] * $numberDays, 'number_rooms' => $counter]);
            return json_encode(['price' => $prices, 'number_rooms' => $counter]);
        } catch (DBException $e) {
        }
    }

}