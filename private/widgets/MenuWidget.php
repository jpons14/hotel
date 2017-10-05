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
<nav class="navbar navbar-default" data-spy="affix" data-offset-top="250">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">JosepLibrary</a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li><a href="$GLOBALS[formAction]/books/all">List of Books</a></li>    
            </ul>
            <ul class="nav navbar-nav navbar-right">

            
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
                <li><a href="$GLOBALS[formAction]/users/login">Login</a></li>
CODE;
        }
    }

    private function addForMembers() {
        if( $GLOBALS[ 'usersPermission' ][ $this->vars[ 'userType' ] ] >= $GLOBALS[ 'usersPermission' ][ 'member' ] ) {
            $this->return .= <<<CODE
                <li><a href="$GLOBALS[formAction]/users/doLogout">Log out</a></li>
                <li><a href="$GLOBALS[formAction]/users/editCurrent">Edit User</a></li>
                <li><a href="$GLOBALS[formAction]/bookings/currentUser">Own history</a></li>
CODE;
        }
    }

    private function addForLibrarians() {
        if( $GLOBALS[ 'usersPermission' ][ $this->vars[ 'userType' ] ] >= $GLOBALS[ 'usersPermission' ][ 'librarian' ] ) {
            $this->return .= <<<CODE
                        <li><a href="$GLOBALS[formAction]/books/index">Search</a></li>
                        <li><a href="$GLOBALS[formAction]/bookings/toOtherUser">Book To Other User</a></li>
                         <li><a href="$GLOBALS[formAction]/users/allUsers">All Users</a></li>
                         <li><a href="$GLOBALS[formAction]/rooms/index">Rooms</a></li>
CODE;

        }
    }

    private function addForRoots() {
        if( $GLOBALS[ 'usersPermission' ][ $this->vars[ 'userType' ] ] >= $GLOBALS[ 'usersPermission' ][ 'root' ] ) {
            $this->return .= <<<CODE
                <li><a href="$GLOBALS[formAction]/booksParamethers/index">Paramethers</a></li>
                <li><a href="$GLOBALS[formAction]/bookings/index">All Bookings</a></li>
                <li><a href="$GLOBALS[formAction]/users/unregister">Unregister</a></li>
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