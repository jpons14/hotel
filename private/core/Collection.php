<?php

/**
 * Functionalities for the child classes of BD
 * @see DB
 * Class Collection
 */
class Collection {
    private $items = [];

    public $data = [];

    private $className;

    /**
     * Example
     * [0] => id
     * [1] => name
     * @var
     */
    private $scheme;


    private $arrayOfItems;

    /**
     * Collection constructor.
     * @param $className
     * @param $arrayOfItems
     * @param $scheme
     */
    public function __construct( $className, $arrayOfItems, $scheme) {
        $this->className = $className;
        $this->arrayOfItems = $arrayOfItems;
        $this->scheme = $scheme;
        $this->generate();
    }

    private function generate()
    {
        foreach ($this->arrayOfItems as $arrayOfItem) {
            $className = $this->className;
            $tmpObject = new $className;
            foreach ($arrayOfItem as $index => $item) {
                $key = $this->scheme[$index];
                $tmpObject->$key = $item;
            }
            $this->data[] = $tmpObject;
        }
    }

    public function toArray()
    {
        $arr = [];
        foreach ($this->data as $datum) {
            $arr[] = $datum->toArray();
        }
        return $arr;
    }

    public function addItem( $item ) {
        $this->items[] = $item;
    }

    public function get(  ) {
        return $this->items;
    }

    /**
     * Takes out of the array of objects the giving key
     * @param $key
     * @return $this Collection
     * TODO: @JosepPons
     */
    public function pop( $key ) {
        foreach( $this->items as $index => $item ) {
            foreach( $item as $in => $it ) {
                if($in == $key) {
                    $this->items[ $index ]->$in = null;
                }
            }
        }
        return $this;
    }

}