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
                    <input class="form-control" type="text" placeholder="Name" name="name" value="' . $this->vars[ 'userName' ] . '"/>
                </div>
                <div class="form-group">
                <label for="roomType"></label>
                    <select class="form-control" name="roomType" id="roomType"> 
                    ';
        $this->generateOptionsRoomTypes($string);
        $string .= '
                    </select>
                </div>
                <div class="form-group">
                    <select class="form-control" name="roomType2" id="roomType2">   
                    <option value="" selected disabled>Select a room type</option>  
                                </select>
                                </div>
                <div class="form-group">
                    <select class="form-control" name="roomType3" id="roomType3">   
                    <option value="" selected disabled>Select a room type</option>  
                            
                            </select>        
                      </div>
                <input class="btn btn-default" type="submit" value="Update user!"/>
            </form>
        </div>';

        return $string;

    }

}