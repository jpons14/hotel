<?php

class Users extends Controller {

    public function __construct( $private ) {
        parent::__construct( $private );
    }

    // Permission = true
    public function login() {

        $user = new User('jponspons@gmail.com');
        $user->getAll();

        $view = new View( [ 'loginForm' ] );
    }


    // permission = true
    public function doLogin() {
        // do the login and redirect to the stories page

        if( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' ) {

            $user = new User( $_POST[ 'email' ], 'name', $_POST[ 'password' ] ); // session started
            if( !$user->getJustEmail() ) {
                $this->set2Session( $user );
                header( "Location: " . FORM_ACTION . "/books/index" );
            }
            if( $user->getRegistered() ) {
                header( "Location: " . FORM_ACTION . "/users/login" );
                die;
            }
        }
    }

    private function set2Session( User $user ) {
        $this->session = new Session();
        $this->session->setVar( 'userType', $user->getUserType() );
        $this->session->setVar( 'logged', 'true' );
        $this->session->setVar( 'userId', $user->getUserId() );
        $this->session->setVar( 'userEmail', $user->getEmail() );
        $this->session->setVar( 'userName', $user->getName() );
    }

    // permission = true
    public function register() {
        return new View( [ 'registerForm' => 'registerForm' ] );
    }

    public function create() {
        new View( [ 'header' ] );
        new View( [], [], [ 'MenuWidget' => [
            'userType' => $this->session->getVar( 'userType' )
        ] ] );

        return new View( [ 'createUser' ] );
    }

    // permission = true
    public function doRegister() {
        // do the register and
        // redirect to login
        $passwordHashed = password_hash( $_POST[ 'password' ], PASSWORD_BCRYPT );
        $user = new User( $_POST[ 'email' ], $_POST[ 'name' ], $passwordHashed, true );
        if( isset( $_GET[ 'from' ] ) && $_GET[ 'from' ] == 'createUser' ) {
            header( "Location: " . FORM_ACTION . "/users/allUsers" );
        } else {
            header( "Location: " . FORM_ACTION . "/users/login" );
        }
    }

    // permission = false
    public function doLogout() {
        // redirection to login page
        $this->session->destroy();
        header( "Location: " . FORM_ACTION . "/books/home" );
    }

    // permission = falsec
    public function unregister() {
        // unregister the user and redirect to the login page

        $logged = $this->session->getVar( 'logged' );

        if( isset( $logged ) && $logged == 'true' ) {
            $user = new User( $this->session->getVar( 'userEmail' ) );
            if( $user->unregister() )
                header( "Location: " . FORM_ACTION . "/users/login" );
        }
    }

    // permission = false;
    public function edit() {
        $user = new User( $_GET[ 'email' ] );
        // show edit user form
        new View( [ 'header' ] );
        new View( [], [], [ 'MenuWidget' => [
            'userType' => $this->session->getVar( 'userType' )
        ] ] );

        return new View( [], [], [ 'UserEditProfile' => [
            'userName' => $user->getName(),
            'userEmail' => $user->getEmail(),
            'userType' => $user->getUserType(),
            'address' => $user->getAddress(),
            'phone' => $user->getPhone()
        ] ] );
    }

    // permission = false
    public function update() {
        // update and redirect to the stories list
        if( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' ) {

            if( isset( $_GET[ 'email' ] ) ) {
                $userEmail = $_GET[ 'email' ];
            } else {
                $userEmail = $this->session->getVar( 'userEmail' );
            }

            $ficheroSubido = IMG_USERS . basename( $userEmail . '.jpg' );
            if( move_uploaded_file( $_FILES[ 'userImage' ][ 'tmp_name' ], $ficheroSubido ) ) {
                echo "El fichero es válido y se subió con éxito.\n";
            } else {
                echo "¡Posible ataque de subida de ficheros!\n";
            }

            $user = new User( $userEmail );
            $user->setName( $_POST[ 'name' ] );
            $user->setAddress( $_POST[ 'address' ] );
            $user->setPhone( $_POST[ 'phone' ] );
            if( isset( $_POST[ 'userType' ] ) ) {
                $user->setUserType( $_POST[ 'userType' ], $user->getUserId() );
                header( "Location: " . FORM_ACTION . "/users/allUsers" );
            } else {
                header( "Location: " . FORM_ACTION . "/users/editCurrent" );
            }
        }
    }

    public function allUsers() {
        $user = new User( $this->session->getVar( 'userEmail' ) );
        $all = $user->getAllUsers( [ 'dni', 'name', 'email' ] );
        new View( [ 'header' ] );
        new View( [], [], [ 'MenuWidget' => [
            'userType' => $this->session->getVar( 'userType' )
        ] ] );

        new View( [ 'buttonNewUser' ], [], [ 'TableWidget' => [
            'fields' => [ 'dni', 'name', 'email', 'edit', 'delete' ],
            'values' => $all,
            'editable' => true,
            'editURI' => '/users/edit?email=',
            'editNum' => 2,
            'deletable' => true,
            'deleteURI' => '/users/delete?email='
        ] ] );
    }

    public function editCurrent() {
        $user = new User( $this->session->getVar( 'userEmail' ) );
        new View( [ 'header' ] );
        new View( [], [], [ 'MenuWidget' => [
            'userType' => $this->session->getVar( 'userType' )
        ] ] );

        new View( [ 'editUser' ], [
            'name' => $user->getName(),
            'address' => $user->getAddress(),
            'phone' => $user->getPhone(),
            'img' => FORM_ACTION . '/public/assets/img/users/' . $this->session->getVar( 'userEmail' ) . '.jpg'
        ] );

    }

    public function delete() {

        if( isset( $_GET[ 'email' ] ) ) {
            $user = new User( $_GET[ 'email' ] );
            if( $user->unregister() )
                header( "Location: " . FORM_ACTION . "/users/allUsers" );
        }
    }

}