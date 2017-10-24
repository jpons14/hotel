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

        new View( ['roomCreateButton'], [], [ 'TableWidget' => [
            'fields' => [ 'id', 'Room type name', 'Adults max num', 'Children max num', 'Name', 'Edit', 'Delete' ],
            'values' => $all,
            'editable' => true,
            'editURI' => '/rooms/edit?id=',
            'editNum' => 2,
            'deletable' => true,
            'deleteURI' => '/rooms/destroy?id='
        ] ] );

        new View( ['roomCreateButton']);

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
        $all = $room->getOnParamether('fk_roomtypes_id_name');

        echo '<pre>$all' . print_r( $all, true ) . '</pre>';
        
        new View([],[],['CreateRoomWidget' => [

        ]]);

    }

    /**
     * Will story the information that comes from the crate function (form)
     */
    public function store() {

    }

    /**
     * Will show the details of the resource
     */
    public function show() {

    }

    /**
     * Will show the edit form of the resource
     */
    public function edit() {

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