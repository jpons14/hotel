<?php

trait Apiable{
    /**
     * Set the header to application/json
     * @param array $data
     * @param string $dataType
     */
    public function response(array $data, $dataType = 'json')
    {
        header('Content-Type: application/json');
        $this->$dataType($data);
    }

    /**
     * @param array $data
     */
    private function json(array $data)
    {
        echo json_encode($data, JSON_FORCE_OBJECT);
    }

}