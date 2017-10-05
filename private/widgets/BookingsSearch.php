<?php

class BookingsSearch extends FatherWidget {
    public function __construct( $vars ) {
        parent::__construct( $vars );
    }

    public function __toString() {
        $return = '<div class="container">
        <form action="' . FORM_ACTION . '/bookings/byEmail" class="byEmail" method="POST"></form>
            <select class="form-control" name="email">';

        foreach( $this->vars[ 'users' ] as $var ) {
            $return .= "<option value='$var[0]'>$var[0]</option>";
        }

        $return .= '</select></div><hr/>';

        return $return;
    }
}