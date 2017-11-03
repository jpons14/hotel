<?php

class MenuWidget extends FatherWidget {

    private $return;

    /**
     * kind of user
     * MenuWidget constructor.
     * @param $vars
     */
    public function __construct( $vars ) {
        parent::__construct( $vars );
        $this->return = '';
    }

    private function startMenu() {
        $this->return .= <<<CODE
<nav class="navbar navbar-toggleable-md navbar-light bg-faded" data-spy="affix" data-offset-top="250">
<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
</button>
            <a class="navbar-brand" href="#">JosepHotel</a>
    <div class="container-fluid">

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav ml-auto">
                <li class="nav-item"><a class="nav-link" href="$GLOBALS[formAction]/books/all">List of Books</a></li>    
            </ul>
            <ul class="navbar-nav mr-auto">

            
CODE;
    }

    private function endMenu() {
        $this->return .= <<<CODE
            </ul>
        </div>
    </div>
</nav>
CODE;
    }

    private function addForNonMembers() {
        if( $GLOBALS[ 'usersPermission' ][ $this->vars[ 'userType' ] ] == $GLOBALS[ 'usersPermission' ][ 'non-member' ] ) {
            $this->return .= <<<CODE
                <li class="nav-item"><a class="nav-link" href="$GLOBALS[formAction]/users/login">Login</a></li>
CODE;
        }
    }

    private function addForMembers() {
        if( $GLOBALS[ 'usersPermission' ][ $this->vars[ 'userType' ] ] >= $GLOBALS[ 'usersPermission' ][ 'member' ] ) {
            $this->return .= <<<CODE
                <li class="nav-item"><a class="nav-link" href="$GLOBALS[formAction]/users/doLogout">Log out</a></li>
                <li class="nav-item"><a class="nav-link active" href="$GLOBALS[formAction]/users/editCurrent">Edit User</a></li>
                <li class="nav-item"><a class="nav-link" href="$GLOBALS[formAction]/bookings/currentUser">Own history</a></li>
CODE;
        }
    }

    private function addForLibrarians() {
        if( $GLOBALS[ 'usersPermission' ][ $this->vars[ 'userType' ] ] >= $GLOBALS[ 'usersPermission' ][ 'librarian' ] ) {
            $this->return .= <<<CODE
                        <li class="nav-item"><a class="nav-link" href="$GLOBALS[formAction]/books/index">Search</a></li>
                        <li class="nav-item"><a class="nav-link" href="$GLOBALS[formAction]/bookings/toOtherUser">Book To Other User</a></li>
                         <li class="nav-item"><a class="nav-link" href="$GLOBALS[formAction]/users/allUsers">All Users</a></li>
                         <li class="nav-item"><a class="nav-link" href="$GLOBALS[formAction]/rooms/index"><b>Rooms</b></a></li>
CODE;

        }
    }

    private function addForRoots() {
        if( $GLOBALS[ 'usersPermission' ][ $this->vars[ 'userType' ] ] >= $GLOBALS[ 'usersPermission' ][ 'root' ] ) {
            $this->return .= <<<CODE
                <li class="nav-item"><a class="nav-link" href="$GLOBALS[formAction]/booksParamethers/index">Paramethers</a></li>
                <li class="nav-item"><a class="nav-link" href="$GLOBALS[formAction]/bookings/index">All Bookings</a></li>
                <li class="nav-item"><a class="nav-link" href="$GLOBALS[formAction]/users/unregister">Unregister</a></li>
CODE;
        }
    }

    public function __toString() {

        $this->startMenu();

        $this->addForNonMembers();
        $this->addForMembers();
        $this->addForLibrarians();
        $this->addForRoots();

        $this->endMenu();


        return $this->return;

    }


}
