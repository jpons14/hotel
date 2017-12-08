<?php


class AdditionalServices extends Controller
{
    use Redirectable;

    /**
     * AdditionalServices constructor.
     * @param $private
     */
    public function __construct($private)
    {
        parent::__construct($private);
    }

    public function index()
    {
        $this->menu();

        $additionalService = new AdditionalService();
        $additionalServices = $additionalService->all();
        new View(['createAdditionalServiceButton'], [], ['TableWidget' => [
            'fields' => ['Id', 'Additional service name', 'Price', 'Edit', 'Delete'],
            'values' => $additionalServices,
            'editable' => true,
            'editURI' => '/additionalServices/edit?id=',
            'editNum' => 0,
            'deletable' => true,
            'deleteURI' => '/additionalServices/destroy?id=',
            'deleteNum' => 0
        ]]);
    }

    public function create()
    {
        $this->menu();
        new View(['additionalServices/create']);
    }

    public function store()
    {
        $additionalService = new AdditionalService();
        try {
            $additionalService->insert(['text' => $_REQUEST['name'], 'price' => $_REQUEST['price']]);
            $this->redirect('/additionalServices/index');
        } catch (DBException $e) {
        }
    }

    public function edit()
    {
        $this->menu();
        $id = $_GET['id'];
        $additionalService = new AdditionalService();
        try {
            $additionalServices = $additionalService->where('id', $id);
            new View(['additionalServices/edit'], [
                'id' => $additionalServices[0][0],
                'name' => $additionalServices[0][1],
                'price' => $additionalServices[0][2]
            ]);
        } catch (DBException $e) {
        }
    }

    public function update()
    {
        $additionalService = new AdditionalService();
        try {
            $additionalService->update(['text' => $_POST['name'], 'price' => $_POST['price']], $_REQUEST['id']);
            $this->redirect('/additionalServices/index');
        } catch (DBException $e) {
        }
    }

    public function destroy()
    {
        $as = new AdditionalService();
        try {
            $as->destroy((int)$_GET['id']);
            $this->redirect('/additionalServices/index');
        } catch (DBException $e) {
        }
    }

}