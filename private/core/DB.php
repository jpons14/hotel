<?php

class DB {

    private $host;

    private $username;

    private $password;

    private $db;

    /**
     * @var \mysqli
     */
    private $connection;

    /**
     * Table to fetch
     * @var
     */
    protected $table;

    /**
     * Contents the fields of the table
     * @var array
     */
    protected $fields = [];

    /**
     * @var array
     */
    private $rawFields = [];


    /**
     * Define if the table has timestamps or not
     * @var boolean
     */
    protected $timestamps = true;

    /**
     * define if the table has id
     * @var bool
     */
    protected $hasId = true;

    private $dontShowIfOfFk = false;

    /**
     * Model constructor.
     * @param string $charset
     * @param bool $hasFk
     * @param array $fks
     * @throws DBException
     */
    public function __construct( $charset = 'UTF8', $hasFk = false, $fks = [] ) {
        $this->host = $GLOBALS[ 'db' ][ 'host' ];
        $this->username = $GLOBALS[ 'db' ][ 'user_name' ];
        $this->password = $GLOBALS[ 'db' ][ 'user_password' ];
        $this->db = $GLOBALS[ 'db' ][ 'db_name' ];


        $this->connection = new mysqli( $this->host, $this->username, $this->password, $this->db );
        $this->connection->set_charset( $charset );
        if( $this->connection == null )
            throw new DBException( "Connection is null" );
    }

    protected function setTable( $table ) {
        $this->table = $table;
    }

    protected function setFields( $fields ) {
        if( !isset( $this->table ) || $this->table == '' )
            throw new VarNoInitializedException( '$this->table is not initialized or is not set' );

        $this->rawFields = $fields;


        foreach( $fields as $field ) {
            $this->fields[] = $this->table . '.' . $field;
        }
    }

    /**
     * @return int
     */
    public function countNumFields() {
        return count( $this->fields );
    }


    private function tmpFunc( $fields ) {
        $fieldsTmp = $fields;
        $f = [];
        foreach( $fieldsTmp as $index => $item ) {
            if( strpos( $item, 'fk' ) !== false ) {
                $differentTables = true;
                unset( $fieldsTmp[ $index ] );
                $f[] = $item;
            }
        }
        if( count( $f ) > 0 )
            $this->dontShowIfOfFk = false;
        $separator = '';
        if( count( $fieldsTmp ) > 0 && count( $f ) > 0 )
            $separator = ',';
        $toReturn = implode( ',', $fieldsTmp );
        $sql = "SELECT {$toReturn}{$separator} ";

        return $sql;
    }

    /**
     * @param array $fields
     * @return array|null
     * @throws DBException
     */
    public function select( $fields = [] ) {
        if( $fields == [] )
            $fields = $this->fields;
        if( !is_array( $fields ) )
            throw new DBException( '$fields Has to be an array' );


        //        $temporal = [];

        //        foreach( $fields as $field ) {
        //            $temporal[] = $this->table . '.' . $field;
        //        }

        //        $fields = $temporal;

        $differentTables = false;

        $fieldsTmp = $fields;
        $f = [];
        foreach( $fieldsTmp as $index => $item ) {
            if( strpos( $item, 'fk' ) !== false ) {
                $differentTables = true;
                unset( $fieldsTmp[ $index ] );
                $f[] = $item;
            }
        }

        if( count( $f ) > 0 )
            $this->dontShowIfOfFk = false;

        $separatorTables = '';

        $separator = '';

        //        if(count($fieldsTmp) > 1)
        //            $this->dontShowIfOfFk = false;
        if( count( $fieldsTmp ) > 0 && count( $f ) > 0 )
            $separator = ',';

        $toReturn = implode( ',', $fieldsTmp );


        if( $differentTables )
            $separatorTables = ',';

        //        if($this->dontShowIfOfFk || count($fields) >= 1)
        //            $separator = '';

        $sql = "SELECT {$toReturn}{$separator} ";

        $sql .= $this->prepare2AddFks2Select( $fields );

        $sql .= " FROM {$this->table}{$separatorTables}";

        $sql .= $this->prepare2AddFks2From( $fields );

        $foo = false;
        $this->splitFks( $this->rawFields, $foo );

        if( $foo )
            $sql .= ' WHERE ' . $this->prepare2AddFks2Where( $fields );


        $result = $this->executeQuery( $sql );

        return $result;
    }

    /**
     * @param $id
     * @return array|null
     * @throws DBException
     */
    public function find( $id ) {
        //        if( !is_int( $id ) || $id == null )
        //            throw new DBException( '$id has to be an Integer' );
        $sql = "SELECT * FROM $this->table WHERE `id` = $id";

        echo '<pre>$sql' . print_r( $sql, true ) . '</pre>';

        return $this->executeQuery( $sql );
    }

    public function where( $fieldNameWhere, $valueWhere, $fields = [], $table = '' ) {
        if( !is_string( $fieldNameWhere ) || $fieldNameWhere == null )
            throw new DBException( '$fieldName has to be a String' );
        if( !is_string( $valueWhere ) || $valueWhere == null )
            throw new DBException( '$value has to be a String' );
        if( $table != '' )
            $this->setTable( $table );
        if( $fields == [] )
            $fields = $this->fields;

        $temporal = [];


        $tmpFunc = $this->tmpFunc( $fields );
        $tmpFunc = rtrim( $tmpFunc, ", " );

        //        foreach( $fields as $field ) {
        //            $temporal[] = $this->table . '.' . $field;
        //        }

        //        $fields = $temporal;

        $toReturn = implode( ',', $fields );
        $fks = [];
        $tt = '';
        foreach( $fields as $key => $field ) {
            if( strpos( $field, 'fk' ) !== false ) {
                $fks[] = ltrim( $field, $this->table . '.' );
                unset( $fields[ $key ] );
                $tt = $field;
            }
        }

        $temporalSelect = [];
        $temporalFrom = [];
        $temporalWhere = [];

        foreach( $fks as $fk ) {
            $in = explode( '_', $fk );
            $temporalSelect[] = $in[ 1 ] . '.' . $in[ 3 ];
            $temporalFrom[] = $in[1];
            $temporalWhere[] = $this->table . '.' . $fk . ' = ' . $in[1] . '.' . $in[2];
        }

        $fksSelect = implode( ',', $temporalSelect );
        $fksFrom = implode(',', $temporalFrom);
        $fksWhere = implode(' AND ', $temporalWhere);

        //        $tmp = explode( '_', $fks[ 0 ] );


        /**
         * Detect if any fk
         * if is there, split in 2 different arrays
         */

        $select = $toReturn . ',' . $fksSelect;
        $select = rtrim( $select, ',' );

        $from = $this->table . ',' . $fksFrom;
        $from = rtrim($from, ',');

        $where = "`$fieldNameWhere` = '$valueWhere' AND $fksWhere";
        $where = rtrim($where, ' AND ');

        if( !empty( $fks ) )
            $sql = "SELECT $select FROM $from WHERE $where";
        else
            $sql = "SELECT * FROM $this->table WHERE {$this->table}.`$fieldNameWhere` = '$valueWhere'";

        echo '<pre>$sql' . print_r( $sql, true ) . '</pre>';

        return $this->executeQuery( $sql );
    }

    public function like( $fieldName, $value, $table = '' ) {
        if( !is_string( $fieldName ) || $fieldName == null )
            throw new DBException( '$fieldName has to be a String' );
        if( !is_string( $value ) || $value == null )
            throw new DBException( '$value has to be a String' );
        if( $table != '' )
            $this->setTable( $table );


        $sql = "SELECT * FROM $this->table WHERE `$fieldName` LIKE '%$value%' ";


        return $this->executeQuery( $sql );
    }


    public function whereOrderBy( $fieldName, $value, $fields = [], $order = 'ASC', $orderBy = 'id', $table = '' ) {
        if( !is_string( $fieldName ) || $fieldName == null )
            throw new DBException( '$fieldName has to be a String' );
        if( !is_string( $value ) || $value == null )
            throw new DBException( '$value has to be a String' );
        if( $table != '' )
            $this->setTable( $table );
        if( $fields == [] )
            $fields = $this->fields;

        $temporal = [];

        foreach( $fields as $field ) {
            $temporal[] = $this->table . '.' . $field;
        }

        $fields = $temporal;

        $toReturn = implode( ',', $fields );
        $fks = [];
        $tt = '';
        foreach( $fields as $field ) {
            if( strpos( $field, 'fk' ) !== false ) {
                $fks[] = $field;
                $tt = $field;
            }
        }

        $tmp = explode( '_', $fks[ 0 ] );

        $fields = implode( ', ', $this->fields );

        if( !empty( $fks ) )
            $sql = "SELECT $fields, {$tmp[1]}.{$tmp[3]} FROM $this->table, $tmp[1] WHERE `$fieldName` = '$value' AND $tmp[1].id = $tt ORDER BY $orderBy $order";
        else
            $sql = "SELECT $fields FROM $this->table WHERE `$fieldName` = '$value' ORDER BY $orderBy $order";

        echo '<pre>$sql' . print_r( $sql, true ) . '</pre>';

        return $this->executeQuery( $sql );
    }

    /**
     * Build an insert query and execute it
     * @param array $values
     * @return bool|mysqli_result
     * @throws DBException
     */
    public function insert( $values = [] ) {
        if( empty( $values ) ) {
            throw new DBException( '$values is empty' );

            return;
        }
        if( !is_array( $values ) ) {
            throw new DBException( '$values has to be an array' );

            return;
        }
        if( count( $values ) > $this->countNumFields() ) {
            throw new DBException( '$values has to many fields' );

            return;
        }
        $array = array();
        foreach( $values as $index => $value ) {
            $array[ '`' . $index . '`' ] = '\'' . $value . '\'';
        }
        $keys = array_keys( $array );
        $sql = "INSERT INTO " . $this->table . ' ( ' . implode( ', ', $keys ) . ' ) VALUES ( ' . implode( ', ', $array ) . ' );';


        return $this->executeUpdate( $sql );
    }

    /**
     * @param $values
     * @param $id
     * @param string $idName
     * @return array
     * @throws DBException
     */
    public function update( $values, $id, $idName = 'id' ) {
        if( $values == [] or empty( $values ) ) {
            throw new DBException( '$values should not be empty' );

            return;
        }
        if( !is_array( $values ) ) {
            throw new DBException( '$values has to be an array' );

            return;
        }
        if( count( $values ) > $this->countNumFields() ) {
            throw new DBException( '$values has to many fields' );

            return;
        }

        $array = array();
        foreach( $values as $index => $value ) {
            $array[ '`' . $index . '`' ] = '`' . $index . '` = \'' . $value . '\'';
        }

        $sql = "UPDATE $this->table SET " . implode( ' & ', $array ) . ' WHERE `' . $idName . '` = \'' . $id . '\';';

        return $this->executeUpdate( $sql );
    }

    /**
     * @param $id
     * @throws DBException
     */
    public function destroy( $id ) {
        if( is_array( $id ) ) {
            foreach( $id as $item ) {
                $sql = "DELETE FROM $this->table WHERE `id` = '$item'";
                $this->executeUpdate( $sql );
            }

            return;
        }
        if( !is_int( $id ) || $id == null )
            throw new DBException( '$id has to be an Integer or an Array' );

        $sql = "DELETE FROM $this->table WHERE `id` = $id";
        $this->executeUpdate( $sql );

        return;
    }


    private function splitFks( $rawFields, &$rawFks = [] ) {
        $fks = [];
        foreach( $rawFields as $field ) {
            if( strpos( $field, 'fk' ) !== false ) {
                $rawFks[] = $field;
                $fks[] = explode( '_', $field );
            }
        }

        return $fks;

    }

    private function prepare2AddFks2Select( $rawFields = [] ) {
        if( !is_array( $rawFields ) )
            throw new NoCompatibleVarTypeException( '$rawFields is not an array' );
        if( $rawFields === [] )
            $rawFields = $this->rawFields;


        $fks = $this->splitFks( $rawFields );
        $selects = [];

        foreach( $fks as $fk ) {
            $selects[] = $fk[ 1 ] . '.`' . $fk[ 3 ] . '`';
        }

        return implode( ',', $selects );
    }

    private function prepare2AddFks2From( $rawFields = [] ) {
        if( !is_array( $rawFields ) )
            throw new NoCompatibleVarTypeException( '$rawFields is not an array' );
        if( $rawFields === [] )
            $rawFields = $this->rawFields;

        $fks = $this->splitFks( $rawFields );

        $from = [];

        foreach( $fks as $fk ) {
            $from[] = $fk[ 1 ];
        }

        return implode( ',', $from );
    }

    private function prepare2AddFks2Where( $rawFields = [] ) {
        if( !is_array( $rawFields ) )
            throw new NoCompatibleVarTypeException( '$rawFields is not an array' );
        if( $rawFields === [] )
            $rawFields = $this->rawFields;


        $rawFks = [];
        $fks = $this->splitFks( $rawFields, $rawFks );

        $table = '';

        $wheres = [];
        foreach( $fks as $index => $fk ) {
            if( $this->dontShowIfOfFk ) {
                $table = $this->table . '.';
            }

            $t = "{$table}{$rawFks[$index]} ";
            $t = ltrim( $t, 'rooms.' );
            $wheres[] = "$t = {$fk[1]}.{$fk[2]}";
        }


        return implode( ' AND ', $wheres );
    }

    /**
     * @param $sql
     * @return array|null
     */
    private function executeQuery( $sql ) {
        return mysqli_fetch_all( mysqli_query( $this->connection, $sql ) );
    }

    /**
     * @param $sql
     * @return bool|mysqli_result
     */
    private function executeUpdate( $sql ) {

        return mysqli_query( $this->connection, $sql );
    }
}