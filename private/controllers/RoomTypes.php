<?php

class RoomTypes extends Controller
{
    use Navigator, Redirectable;

    public function __construct($private)
    {
        parent::__construct($private);
    }

    public function index()
    {
        $this->menu();
        $roomType = new RoomType();
        $roomTypes = $roomType->getAll();
        new View(['roomTypes/createRoomTypeButton', 'roomTypes/confirmation'], [], ['TableWidget' => [
            'fields' => ['id', 'name', 'price', 'edit', 'delete'],
            'values' => $roomTypes,
            'editable' => true,
            'editURI' => '/roomTypes/edit?id=',
            'editNum' => 0,
            'deletable' => true,
            'deleteURI' => '/roomTypes/destroy?id=',
            'deleteNum' => 0
        ]]);
        new View(['roomTypes/createRoomTypeButton']);
    }

    public function create()
    {
        $this->menu();
        new View(['roomTypes/create']);
    }

    public function store()
    {
        $roomType = new RoomType();
        try {
            $roomType->insert(['name' => $_POST['name'] ?? '', 'price' => $_POST['price'] ?? 0]);
        } catch (DBException $e){}
        $this->redirect('/roomTypes/index');
    }

    public function edit()
    {
        $this->menu();
        $roomType = new RoomType();
        $roomType = $roomType->getById($_GET['id'] ?? '');
        new View(['roomTypes/edit'], ['id' => $roomType[0], 'name' => $roomType[1], 'price' => $roomType[2]]);
    }

    public function update()
    {
        $this->menu();
        $roomTypes = new RoomType();
        try {
            $roomTypes->update(['name' => $_POST['name'] ?? 'undefined', 'price' => $_POST['price'] ?? 0], $_GET['id']);
        } catch (DBException $e){}
        $this->redirect('/roomTypes/index');
    }

    public function destroy()
    {
        $roomType = new RoomType();
        try {
            $roomType->destroy((int)$_GET['id'] ?? '');
            $this->redirect('/roomTypes/index');
        } catch (DBException $e){}
    }

}