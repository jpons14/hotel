<?php


class BooksParamethersWidget extends FatherWidget {

    public function __construct( $vars ) {
        parent::__construct( $vars );
    }

    public function __toString() {
        $return = '<form method="post" action="' . FORM_ACTION . '/booksParamethers/update"><div class="container">';
        foreach( $this->vars[ 'paramethers' ] as $item ) {
            $return .= '<div class="row"><div class="col-md-6"><input disabled="disabled" class="form-control" type="text" value="' . $item[ 0 ] . '" /></div>';
            $return .= '<div class="col-md-6"><input class="form-control" name="' . $item[ 0 ] . '" type="number" value="' . $item[ 1 ] . '" /></div></div><br />';

        }
        $return .= '<input type="submit" class="btn btn-default" value="Update"></div></form>';

        return $return;
    }
}