<?php

class RoomTypes extends Controller
{
    use Navigator;

    public function __construct($private)
    {
        parent::__construct($private);
    }

    public function index()
    {
        $this->menu();
        $roomType = new RoomType();
        $roomTypes = $roomType->getAll();
        new View(['createRoomButton', 'confirmation'], [], ['TableWidget' => [
            'fields' => ['id', 'name', 'price', 'edit', 'delete'],
            'values' => $roomTypes,
            'editable' => true,
            'editURI' => '/roomTypes/edit?id=',
            'editNum' => 0,
            'deletable' => true,
            'deleteURI' => '/roomTypes/destroy?id=',
            'deleteNum' => 0
        ]]);
        new View(['createRoomButton']);
    }

    public function create()
    {
        $this->menu();
        new View(['createRoomType']);
    }

    public function store()
    {
        $roomType = new RoomType();
        $roomType->insert(['name' => $_POST['name'] ?? '', 'price' => $_POST['price'] ?? 0]);
        header('Location: ' . FORM_ACTION . '/roomTypes/index');
    }

    public function edit()
    {
        $this->menu();
        $roomType = new RoomType();
        $roomType = $roomType->getById($_GET['id'] ?? '');
        new View(['editRoomType'], ['id' => $roomType[0], 'name' => $roomType[1], 'price' => $roomType[2]]);
    }

    public function update()
    {
        $this->menu();
        $roomTypes = new RoomType();
        $roomTypes->update(['name' => $_POST['name'] ?? 'undefined', 'price' => $_POST['price'] ?? 0], $_GET['id']);
        header('Location: ' . FORM_ACTION . '/roomTypes/index');
    }

    public function destroy()
    {
        $roomType = new RoomType();
        $roomType->destroy((int)$_GET['id'] ?? '');
        header('Location: ' . FORM_ACTION . '/roomTypes/index');
    }

}