<?php

class UserEditProfile extends FatherWidget {
    public function __construct( $vars = [] ) {
        parent::__construct( $vars );
    }

    public function __toString() {

        $type = $this->vars[ 'userType' ];

        $member = '';
        $librarian = '';
        $root = '';

        ## todo: ask
        if( $type == 'member' )
            $member = 'selected';
        if( $type == 'librarian' )
            $librarian = 'selected';
        if( $type == 'root' )
            $root = 'selected';

        $string = '<div class="container">
            <form action="' . $GLOBALS[ 'formAction' ] . '/users/update?email=' . $this->vars[ 'userEmail' ] . '" method="POST">
                <div class="form-group">
                    <input class="form-control" type="text" placeholder="Name" name="name" value="' . $this->vars[ 'userName' ] . '"/>
                </div>
                <div class="form-group">
                <label for="userType"></label>
                    <select class="form-control" name="userType" id="userType">
                        <option ' . $member . ' value="member">member</option>
                        <option ' . $librarian . ' value="librarian">librarian</option>
                        <option ' . $root . ' value="root">root</option>
                    </select>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="address" placeholder="Address" value="' . $this->vars[ 'address' ] . '">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="phone" placeholder="Phone" value="' . $this->vars[ 'phone' ] . '">
                </div>
                <input class="btn btn-default" type="submit" value="Update user!"/>
            </form>
        </div>';

        return $string;
    }

}