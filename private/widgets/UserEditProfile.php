<?php

class UserEditProfile extends FatherWidget {
    public function __construct( $vars = [] ) {
        parent::__construct( $vars );
    }

    public function __toString() {

        $type = $this->vars[ 'userType' ];

        $member = '';
        $hotelier = '';
        $root = '';

        ## todo: ask
        if( $type == 'member' )
            $member = 'selected';
        if( $type == 'hotelier' )
            $hotelier = 'selected';
        if( $type == 'root' )
            $root = 'selected';

        $string = '<br /><div class="container">
            <form action="' . $GLOBALS[ 'formAction' ] . '/users/update?email=' . $this->vars[ 'userEmail' ] . '" method="POST">
                <div class="form-group">
                    <input class="form-control" type="text" placeholder="Name" name="name" value="' . $this->vars[ 'userName' ] . '"/>
                </div>
                
                <div class="form-group">
                    <input type="text" class="form-control" name="surnames" placeholder="Address" value="' . $this->vars[ 'surnames' ] . '">
                </div>
                <div class="form-group">
                <label for="userType"></label>
                    <select class="form-control" name="userType" id="userType">
                        <option ' . $member . ' value="member">Member</option>
                        <option ' . $hotelier . ' value="hotelier">Hotelier</option>
                        <option ' . $root . ' value="root">Root</option>
                    </select>
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