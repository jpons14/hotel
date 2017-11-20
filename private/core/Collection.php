<?php

/**
 * Functionalities for the child classes of BD
 * @see DB
 * Class Collection
 */
class Collection {
    private $items = [];
    public function __construct(  ) {
    }

    public function addItem( $item ) {
        $this->items[] = $item;
    }

    /**
     * Takes out of the array of objects the giving key
     * @param $key
     */
    public function pop( $key ) {
        foreach( $this->items as $index => $item ) {

        }
    }

}