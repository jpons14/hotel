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
            <a class="navbar-brand" href="/">JosepHotel</a>
    <div class="container-fluid">

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <!--<ul class="nav navbar-nav ml-auto">-->
                <!--<li class="nav-item"><a class="nav-link" href="$GLOBALS[formAction]/books/all">List of Books</a></li>    -->
            <!--</ul>-->
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
        if($this->user->isNotmember()) {
            $this->return .= <<<CODE
                <li class="nav-item"><a class="nav-link" href="$GLOBALS[formAction]/users/login">Login</a></li>
                <li class="nav-item"><a class="nav-link" href="$GLOBALS[formAction]/bookings/loginByDNIForm">Your Bookings</a></li>
CODE;
        }
    }

    private function addForMembers() {
        if( $this->user->isMember()) {
            $this->return .= <<<CODE
                <li class="nav-item"><a class="nav-link" href="$GLOBALS[formAction]/users/doLogout">Log out</a></li>
                <li class="nav-item"><a class="nav-link active" href="$GLOBALS[formAction]/users/editCurrent">Edit User</a></li>
                <li class="nav-item"><a class="nav-link" href="$GLOBALS[formAction]/bookings/currentUser">Own history</a></li>
CODE;
        }
    }

    

    private function addForHoteliers() {
        if($this->user->isHotelier()) {
            $this->return .= <<<CODE
                         <li class="nav-item"><a class="nav-link" href="$GLOBALS[formAction]/users/allUsers">All Users</a></li>
                         <li class="nav-item"><a class="nav-link" href="$GLOBALS[formAction]/rooms/index"><b>Rooms</b></a></li>
                         <li class="nav-item"><a class="nav-link" href="$GLOBALS[formAction]/roomTypes/index"><b>Room Types</b></a></li>
                         <li class="nav-item"><a class="nav-link" href="$GLOBALS[formAction]/additionalServices/index"><b>Add Serv</b></a></li>
CODE;

        }
    }

    

    private function addForRoots() {
        if($this->user->isRoot()) {
            $this->return .= <<<CODE
                <li class="nav-item"><a class="nav-link" href="$GLOBALS[formAction]/bookings/index">All Bookings</a></li>
CODE;
        }
    }

    

    public function __toString() {

        $this->startMenu();

        $this->addForNonMembers();
        $this->addForMembers();
        $this->addForHoteliers();
        $this->addForRoots();

        $this->endMenu();


        return $this->return;

    }


}
