<?php


class CreateRoomWidget extends FatherWidget {
    public function __construct( $vars ) {
        parent::__construct( $vars );
    }


    public function __toString() {
        $string = '<br /><div class="container">
            <form action="' . $GLOBALS[ 'formAction' ] . '/rooms/store" method="POST">
                <div class="form-group">
                    <input class="form-control" type="text" placeholder="Name" name="name" value="' . $this->vars[ 'userName' ] . '"/>
                </div>
                <div class="form-group">
                <label for="userType"></label>
                    <select class="form-control" name="userType" id="userType">
                        <option value="member">member</option>
                        <option value="librarian">librarian</option>
                        <option value="root">root</option>
                    </select>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="address" placeholder="Address" value="tmp no working">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="phone" placeholder="Phone" value="tmp no working">
                </div>
                <input class="btn btn-default" type="submit" value="Update user!"/>
            </form>
        </div>';

        return $string;

    }

}