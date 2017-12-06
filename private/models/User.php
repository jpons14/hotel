<?php

class User extends DB {
    private $name;
    private $email;
    private $password;
    private $dni;

    private $userId;

    private $justEmail;

    private $resgistered;

    private $userType;

    private $address;

    private $phone;

    private $surnames;

    private $hidden = [
        'hidden'
    ];

    /**
     *
     * If all go well, it will start session
     *
     * User constructor.
     * @param string $dni
     * @param string $email
     * @param string $name
     * @param string $password
     * @param bool $register
     */
    public function __construct($email, $name = '', $password = '', $dni = '', $register = false ) {
        parent::__construct();
        $this->email = $email;
        $this->justEmail = false;
//        try {
            $this->fields = [ 'dni', 'name', 'surnames', 'email', 'phone', 'password', 'fk_usertypes_id_usertypename' ];
            if( $name == '' && $password == '' ) {
                $this->justEmail = true;
            } else {
                $this->name = $name;
                $this->password = $password;
                $this->dni = $dni;
                if( $register ) {
                    $this->_doRegister();
                } else {
                    $this->_doLogin();
                }
            }

//        } catch( DBException $e ) {
//            $e->showException();
//        }

    }

    public function __toString() {
        return $this->getName() . ' ' . $this->getEmail() . ' ' . $this->getUserType();
    }

    public function getUserId() {
        if( !isset( $this->userId ) )
            $this->getUserDataByEmail( $this->email );

        return $this->userId;
    }

    public function getName() {
        #TEMPORAL
        if( !isset( $this->name ) )
            $this->getUserDataByEmail( $this->email );

        return $this->name;
    }

    public function getUserType() {
        if( !isset( $this->userType ) ) {
            $this->getUserDataByEmail( $this->email );
        }

        return $this->userType;
    }

    public function getAddress() {
        if( !isset( $this->address ) ) {
            $this->getUserDataByEmail( $this->email );
        }

        return $this->address;
    }

    public function getPhone() {
        if( !isset( $this->address ) ) {
            $this->getUserDataByEmail( $this->email );
        }

        return $this->phone;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getDNI(  ) {
        return $this->dni;
    }
    

    public function getPassword() {
        return $this->password;
    }

    public function getJustEmail() {
        return $this->justEmail;
    }

    public function getRegistered() {
        return $this->resgistered;
    }

    private function _doLogin() {
        $email = $this->email;
        $password = $this->password;
        $this->setTable( 'users' );
        /**
         * 0 -> dni
         * 1 ->  name
         * 2 -> surnames
         * 3 -> email
         * 4 -> phone
         * 5 -> password
         * 6 -> user type
         */
        $emailValidation = $this->where( 'email', $email );
        if( count( $emailValidation ) === 1 ) {
            if( password_verify( $password, $emailValidation[ 0 ][ 5 ] ) ) {
                $this->userId = $emailValidation[ 0 ][ 0 ];
                $this->dni = $emailValidation[ 0 ][ 0 ];
                return true;
            } else //wrong password
                throw new DBException( 'Wrong password' );
        } elseif( count( $emailValidation ) === 0 ) //wrong username
            throw new Exception( 'Wrong username' );
        else //Database exception
            throw new DBException( 'More than one item with the same ID in the DB' );
    }

    public function getUserDataById( $id ) {
        $this->setTable( 'users' );

        return $this->find( $id );
    }

    public function getUserDataByEmail( $email = '' ) {
        $this->setTable( 'users' );
        if( $email != '' ) {
            $this->email = $email;
        }

        /**
         * 0 -> dni
         * 1 ->  name
         * 2 -> surnames
         * 3 -> email
         * 4 -> phone
         * 5 -> password
         * 6 -> user type
         */
        
        $return = $this->where( 'email', $this->email );


        $this->userId = $return[ 0 ][ 0 ];
        $this->name = $return[ 0 ][ 1 ];
        $this->surnames = $return[ 0 ][ 2 ];
        $this->email = $return[ 0 ][ 3 ];
        $this->phone = $return[ 0 ][ 4 ];
        $this->userType = $return[ 0 ][ 7 ];

        return $return;
    }

    private function isUser() {
        $this->setTable( 'users' );
        $emailValidation = $this->where( 'email', $this->email );
        if( count( $emailValidation ) === 1 )
            return true;
        else
            return false;
    }

    private function _doRegister() {
        if( $this->isUser() ) {
            throw new DBException( 'This user already exists' );
        } else {
            $values[ 'dni' ] = $this->dni;
            $values[ 'name' ] = $this->name;
            $values[ 'surnames' ] = $this->name;
            $values[ 'email' ] = $this->email;
            $values[ 'phone' ] = '666666666';
            $values[ 'password' ] = $this->password;
            $values[ 'fk_usertypes_id_usertypename' ] = '3';

            return $this->insert( $values );
        }
    }

    public function setName( $value ) {
        $this->update( [ 'name' => $value ], $this->getUserId() );

        // refresh info
        $this->getUserDataByEmail( $this->email );

        // name
        return $this->name;
    }

    public function setAddress( $value ) {
        $this->update( [ 'address' => $value ], $this->getUSerId() );

        // refresh info
        $this->getUserDataByEmail( $this->email );

        return $this->address;
    }

    public function setPhone( $value ) {
        $this->update( [ 'phone' => $value ], $this->getUSerId() );

        // refresh info
        $this->getUserDataByEmail( $this->email );

        return $this->phone;
    }


    /**
     * @param $value
     * @param $userId
     * @return array
     */
    public function setUserType( $value, $userId ) {
        if( !isset( $this->userId ) )
            $this->getUserDataById( (int)$userId );

        return $this->update( [ 'fk_usertypes_id_usertypename' => (string)$value ], $this->userId, 'dni' );
    }

    public function unregister() {
        $this->setTable( 'users' );
        $userId = $this->getUserDataByEmail( $this->email );
        $this->destroy( [ $userId[ 0 ][ 0 ] ] );

        return true;
    }

    public function getAllUsers( $select = '' ) {
        ##todo: look
        $this->setTable( 'users' );

        return $this->select( $select );
    }

    public function getAll(  ) {
        $this->setTable( 'users' );
        $this->select();
    }

    public function toArray() {
        $attributes = get_object_vars( $this );
        $array = array();
        foreach( $attributes as $index => $attribute ) {
            if( !in_array( $index, $this->hidden ) )
                $array[ $index ] = $attribute;
        }

        return $array;
    }

}