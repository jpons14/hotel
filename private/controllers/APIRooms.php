<?php

class APIRooms extends Controller implements ResourceInterface {

    /**
     * method of call
     * @var
     */
    private $method;

    public function __construct( $private ) {
        parent::__construct( $private );
        $this->method = $_SERVER['REQUEST_METHOD'];
    }


    /**
     * Display a listing of the resource.
     * @return mixed
     */
    public function index() {
        // TODO: Implement index() method.
    }

    /**
     * Show the form for creating a new resource.
     * @return mixed
     */
    public function create() {
        // TODO: Implement create() method.
    }

    /**
     * Store a newly created resource in storage.
     * @return mixed
     */
    public function store() {
        // TODO: Implement store() method.
    }

    /**
     * Display the specified resource.
     * @return mixed
     */
    public function show() {
        // TODO: Implement show() method.
    }

    /**
     * Show the form for editing the specified resource.
     * @return mixed
     */
    public function edit() {
        $room = new Room();
        $roomData = $room->getById($_GET['id']);
        header('Content-Type: application/json');
        echo json_encode($roomData);
        return json_encode($roomData);
    }

    /**
     * Update the specified resource in storage.
     * @return mixed
     */
    public function update() {
        // TODO: Implement update() method.
    }

    /**
     * Remove the specified resource from storage.
     * @return mixed
     */
    public function destroy() {
        // TODO: Implement destroy() method.
    }
}