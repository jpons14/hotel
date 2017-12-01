<?php

class APIBookings extends Controller implements ResourceInterface
{

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
        $booking = new Booking();
        $history = $booking->bookingsWhere('fk_users_dni_dni', $this->session->getVar('userDNI'), ['id', 'start_date', 'end_date', 'confirmed']);

        header('Content-Type: application/json');
        echo json_encode($history);
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
                    try {
                        $bookingsByRoomId = $booking->getBookingsByRoomId($tmpRoom->id);

                        foreach ($bookingsByRoomId as $value) {
                            $boolean = $booking->isBetweenDates($value->start_date, $_POST['start_date'], $_POST['end_date']);
                            $boolean2 = $booking->isBetweenDates($value->end_date, $_POST['start_date'], $_POST['end_date']);
                            if (!$boolean && !$boolean2) {
                                # If i set this key will not be repeated the values
                                $resultAllRoomTypes[$item[1]] = $item;
                            }

                        }
                    } catch (DBException $e) {
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


//        try {
//            $roomType = new RoomType();
//            $prices = $roomType->where('id', $_GET['roomType'], ['price']);
//            $booking = new Booking();
//            $booking->
//            $days = strtotime($_GET['end_date']) - strtotime($_GET['start_date']);
//            $numberDays = $days / 86400;
//
//            header('Content-Type: application/json');
//            echo json_encode($prices[0][0] * $numberDays);
//            return json_encode($prices);
//        } catch (DBException $e) {
//        }
    }

}