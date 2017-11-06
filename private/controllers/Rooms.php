<?php

class Rooms extends Controller implements ResourceInterface {

    public function __construct( $private ) {
        parent::__construct( $private );
    }

    public function index() {
        $user = new User( $this->session->getVar( 'userEmail' ) );
        new View( [ 'header' ] );
        new View( [], [], [ 'MenuWidget' => [
            'userType' => $this->session->getVar( 'userType' )
        ] ] );

        $room = new Room();
        $all = $room->getAll();

        new View( [ 'roomCreateButton' ], [], [ 'TableWidget' => [
            'fields' => [ 'id', 'Adults max num', 'Children max num', 'Room type name', 'Name', 'Edit', 'Delete' ],
            'values' => $all,
            'editable' => true,
            'editURI' => '/rooms/edit?id=',
            'editNum' => 0,
            'deletable' => true,
            'deleteURI' => '/rooms/destroy?id='
        ] ] );

        new View( [ 'roomCreateButton' ] );

    }

    /**
     * Show create form
     */
    public function create() {
        $user = new User( $this->session->getVar( 'userEmail' ) );
        new View( [ 'header' ] );
        new View( [], [], [ 'MenuWidget' => [
            'userType' => $this->session->getVar( 'userType' )
        ] ] );

        $room = new Room();
        $all = $room->getOnParamether( 'fk_roomtypes_id_name' );

        $roomTypes = new RoomType();

        $types = $roomTypes->name;


        new View( [ 'roomTypesJS' ], [], [ 'CreateRoomWidget' => [
            'roomTypes' => $types
        ] ] );

    }

    /**
     * Will story the information that comes from the crate function (form)
     */
    public function store() {
        $room = new Room();
        $room->addRoom( $_POST );
        header( "Location: " . FORM_ACTION . "/rooms/index" );
    }

    /**
     * Will show the details of the resource
     */
    public function show() {
        $user = new User( $this->session->getVar( 'userEmail' ) );
        new View( [ 'header' ] );
        new View( [], [], [ 'MenuWidget' => [
            'userType' => $this->session->getVar( 'userType' )
        ] ] );
    }

    /**
     * Will show the edit form of the resource
     */
    public function edit() {
        $user = new User( $this->session->getVar( 'userEmail' ) );
        new View( [ 'header' ] );
        new View( [], [], [ 'MenuWidget' => [
            'userType' => $this->session->getVar( 'userType' )
        ] ] );

        $room = new Room();
        $roomData = $room->getById($_GET['id']);

        new View(['roomEdit'], ['id' => $_GET['id']]);

    }

    /**
     * Will update the resource that comes from edit form
     */
    public function update() {

    }


    /**
     * Remove the specified resource from storage
     */
    public function destroy() {

    }

}