<?php

class AllBooksWidget extends FatherWidget {
    public function __construct( $vars ) {
        parent::__construct( $vars );
    }

    public function __toString() {
        $return = '<div class="container">';
        foreach( $this->vars[ 'ids' ] as $key => $book ) {
            $return .= '<pre>';
            $return .= print_r( $this->vars[ 'books' ][ $key ], true ) . ' <a href="' . $GLOBALS[ 'formAction' ] . '/books/addNew?id=' . $book . '" <i class="fa fa-floppy-o fa-2x" aria-hidden="true"></i></a></pre>';
        }
        $return .= '</div>';

        return $return;
    }
}