<?php
interface ResourceInterface{

    /**
     * Display a listing of the resource.
     * @return mixed
     */
    public function index();

    /**
     * Show the form for creating a new resource.
     * @return mixed
     */
    public function create();

    /**
     * Store a newly created resource in storage.
     * @return mixed
     */
    public function store();

    /**
     * Display the specified resource.
     * @return mixed
     */
    public function show();

    /**
     * Show the form for editing the specified resource.
     * @return mixed
     */
    public function edit();

    /**
     * Update the specified resource in storage.
     * @return mixed
     */
    public function update();

    /**
     * Remove the specified resource from storage.
     * @return mixed
     */
    public function destroy();
}