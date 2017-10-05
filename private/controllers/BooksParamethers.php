<?php

/**
 * Created by PhpStorm.
 * User: josep
 * Date: 12/06/2017
 * Time: 17:41
 */
class BooksParamethers extends Controller {
    public function __construct( $private ) {
        parent::__construct( $private );
    }

    public function index() {
        $paramethers = new BookParamether();
        $para = $paramethers->getAll();
        new View( [ 'header' ] );
        new View( [], [], [ 'MenuWidget' => [
            'userType' => $this->session->getVar( 'userType' )
        ] ] );
        new View( [], [], [ 'BooksParamethersWidget' => [
            'paramethers' => $para
        ] ] );
    }

    public function update() {

        $paramether = new BookParamether();
        foreach( $_POST as $index => $item ) {
            $paramether->update( [ 'days' => $item ], $index, 'conservation' );
        }

        header( 'Location: ' . FORM_ACTION . '/booksParamethers/index' );

    }

}