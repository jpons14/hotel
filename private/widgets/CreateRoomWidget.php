<?php


class CreateRoomWidget extends FatherWidget {
    public function __construct( $vars ) {
        parent::__construct( $vars );
    }

    public function generateOptionsRoomTypes( &$string ) {
        foreach( $this->vars as $var ) {
            foreach( $var as $item ) {
                $string .= "<option value='$item[0]'>$item[0]</option>";
            }
        }
    }

    public function __toString() {
        $string = '<br /><div class="container">
            <form action="' . $GLOBALS[ 'formAction' ] . '/rooms/store" method="POST">
                <div class="form-group">
                    <input required="required" class="form-control" type="text" placeholder="Name" name="name" value="' . $this->vars[ 'userName' ] . '"/>
                </div>
                    ';
        $string .= '
                <div class="form-group">
                    <select class="form-control" name="fk_roomtypes_id_name" id="roomType" required="required">   
                    <option value="" selected disabled>Select a room type</option>  
                                </select>
                                </div>
                <div class="form-group">
                    <input required="required" class="form-control" type="number" id="adults_max_num" name="adults_max_number" placeholder="Adults Max Number" />     
                </div>
                <div class="form-group">
                    <input required="required" class="form-control" type="number" id="children_max_num" name="children_max_number" placeholder="Adults Max Number" />     
                </div>
                <input class="btn btn-default" type="submit" value="Create Room"/>
            </form>
        </div>';

        return $string;

    }

}