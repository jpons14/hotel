<?php
/**
 * Created by PhpStorm.
 * User: josep
 * Date: 08/12/2017
 * Time: 9:31
 */

class APIAdditionalServices extends Controller implements ResourceInterface
{
    use Apiable;

    /**
     * Display a listing of the resource.
     * @return mixed
     */
    public function index()
    {
        $additionalService = new AdditionalService();
        $schema = ['id', 'text', 'price'];
        $additionalServices = $additionalService->all($schema);
        $arr = [];
        foreach ($additionalServices as $key => $item) {
            for ($i = 0; $i < count($item); $i++){
                $arr[$key][$schema[$i]] = $item[$i];
            }
        }
        $this->response($arr);
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
}