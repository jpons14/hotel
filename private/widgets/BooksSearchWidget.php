<?php

class BooksSearchWidget extends FatherWidget {

    public function __construct( $vars ) {
        parent::__construct( $vars );
    }

    public function __toString() {
        $return = '<div class="container">
        <form action="' . FORM_ACTION . '/books/all" method="GET">
        <div class="row">
            <div class="col-md-9">
                <input type="text" class="col-md-12 form-control" name="search" placeholder="Name | ISBN"/>
            </div>
            <div class="col-md-3">
                <input type="submit" value="Search" class="btn btn-default">
            </div>
            </div>
        </form>
        ';


        $return .= '</div><hr/>';

        return $return;

    }
}