<?php

/**
 * Functionalities for the child classes of BD
 * @see DB
 * Class Collection
 */
class Collection {
    private $items = [];
    public function __construct( $arrOfItems = []) {
        $this->items = $arrOfItems;
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