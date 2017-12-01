<?php
return [
    'Users' => [
        'doLogout' => 100,
        'unregister' => 100,
        'edit' => 100,
        'update' => 100,
        'allUsers' => 200,
        'editCurrent' => 100,
        'create' => 200,

    ],
    'Books' => [
        'index' => 100,
        'home' => 1,
        'all' => 1,
        'search' => 1,
        'details' => 1,
        'by' => 1
    ],
    'Bookings' => [
        'showForms' => 1,
        'sendMails' => 1,
        'confirmBooking' => 100,
        'edit' => 100,
        'update' => 100,
        'destroy' => 100,
        'confirmBookingDNIForm' => 1,
        'confirmBookingDNI' => 1,
        'loginByDNI' => 1,
        'loginByDNIForm' => 1,
        'checkAvailableRooms' => 1,
        'index' => 200,
        'booking' => 100,
        'by' => 100,
        'byUserEmail' => 100,
        'currentUser' => 100,
        'byBookId' => 100,
        'return' => 200,
        'toOtherUser' => 200,
        'bookToOther' => 200

    ],
    'BooksParamethers' => [
        'index' => 300
    ],
    'Rooms' => [
        'index' => 200,
        'create' => 200,
        'edit' => 200,
        'update' => 200
    ],
    'RoomTypes' => [
        'index' => 200,
        'create' => 200,
        'store' => 200,
        'edit' => 200,
        'update' => 200,
        'destroy' => 200
    ],
    'APIRoomsTypes' => [
        'index' => 100
    ],
    'APIBookings' => [
        'index' => 100,
        'calculatePrice' => 100
    ]
];