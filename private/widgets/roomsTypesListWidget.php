<?php


class roomsTypesListWidget extends FatherWidget {
    public function __construct( $vars ) {
        parent::__construct( $vars );
    }


    public function __toString() {
        $html = '<div class="container">';
        foreach( $this->vars[ 'data' ] as $datum ) {
            $html .= <<<PHP
<div class="card">
  <div class="card-block">
    $datum[1] with a price of $datum[2]€ <div class="float-right"><a href="$GLOBALS[form_action]/bookings/confirmBooking?room_type_id=$datum[0]" class="btn btn-primary reserve">reserve</a></div>
  </div>
</div>
<hr />
PHP;
        }
        $html .= '</div>';

        return $html;
    }
}