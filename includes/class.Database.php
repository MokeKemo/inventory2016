<?php

/**
 * Created by PhpStorm.
 * User: jovan
 * Date: 10/28/15
 * Time: 9:47 AM
 */
class Database {

    var $ready = false;

    /**
     * Errors buffer
     *
     * @var array
     */
    private $_errors = array();

    /**
     * SQL code buffer
     *
     * @var mysqli_result
     */
    private $_query;

    /**
     * Counter
     *
     * @var integer
     */
    private $_queryCounter=0;

    /**
     * Connection
     *
     * @var mysqli object
     */
    public $dbh;

    /**
     * Query results
     *
     * @var object
     */
    private $_queryResult;

    private $_memcache = null;
    private $_memcache_ready = false;

    var $last_error = '';

    public function __construct($connectionDetails, $autoConnect=TRUE) {
        //register_shutdown_function( array( &$this, '__destruct' ) );

        $this->dbuser = $connectionDetails['username'];
        $this->dbpassword = $connectionDetails['password'];
        $this->dbname = $connectionDetails['database'];
        $this->dbhost = $connectionDetails['address'];
        $this->dbport = $connectionDetails['port'];

        if(isset($connectionDetails['memcache']) && class_exists('Memcache') && isset($connectionDetails['memcache']['host']) && isset($connectionDetails['memcache']['port']))
        {
            $this->_memcache = new Memcache;
            if($this->_memcache->connect($connectionDetails['memcache']['host'], $connectionDetails['memcache']['port']))
                $this->_memcache_ready = true;
        }

        if($autoConnect)
            return $this->db_connect();
        else
            return true;
    }

    public function __destruct() {
        $this->disconnect();
        return true;
    }


    public function db_connect() {

        $this->dbh = mysqli_connect( $this->dbhost, $this->dbuser, $this->dbpassword );

        if ( !$this->dbh ) {
            $this->ready = false;
            return false;
        }

        return $this->selectDB( $this->dbname, $this->dbh );
    }

    public function selectDB( $db, $dbh = null ) {
        if ( is_null($dbh) )
            $dbh = $this->dbh;

        if ( !mysqli_select_db( $dbh, $db ) ) {
            $this->ready = false;
            $this->_error(mysqli_errno($this->dbh), mysqli_error($this->dbh));
            return false;
        }

        $this->ready = true;
        return true;
    }

    public function prepare( $query = null ) { // ( $query, *$args )
        if ( is_null( $query ) )
            return false;

        $args = func_get_args();
        array_shift( $args );
        // If args were passed as an array (as in vsprintf), move them up
        if ( isset( $args[0] ) && is_array($args[0]) )
            $args = $args[0];
        $query = str_replace( "'%s'", '%s', $query ); // in case someone mistakenly already singlequoted it
        $query = str_replace( '"%s"', '%s', $query ); // doublequote unquoting
        $query = preg_replace( '|(?<!%)%s|', "'%s'", $query ); // quote the strings, avoiding escaped strings like %%s
        array_walk( $args, array( &$this, 'escape_by_ref' ) );
        return @vsprintf( $query, $args );
    }

    /**
     * Execute SQL query
     *
     * @param string $sql
     * @param int|string $type
     * @param  $cache
     * @return array|object|bool
     */
    public function query($sql, $type=1, $cache=false)
    {
        if ( ! $this->ready )
            return false;

        // version compatibility
        $__OLD2NEW = array( 1=>'OBJECT', 2=>'FETCH', 3=>'SMART_FETCH', 4=>'PAGING' );
        if( is_numeric($type) ) { $type = $__OLD2NEW[$type]; }

        if($type == 'PAGING')
        {
            $sql = trim($sql);
            $upper_sql = strtoupper($sql);
            $pos = strpos($upper_sql, 'SELECT');
            if($pos === 0)
            {
                $sql_head = 'SELECT';
                $sql_tail = substr($sql, 6);
                $sql = $sql_head . ' SQL_CALC_FOUND_ROWS ' . $sql_tail;
            }
            else
            {
                $type = 'FETCH';
            }
        }

        $memory_key = sha1($sql);
        if($this->_memcache_ready && ($cached = $this->_memcache->get($memory_key))!==false)
        {
            return $cached;
        }

        // reset
        $this->_queryResult = null;

        $this->_query = mysqli_query( $this->dbh, $sql );

        // If there is an error then take note of it..
        if ( $this->last_error = mysqli_error( $this->dbh ) ) {
            $this->_error(mysqli_errno($this->dbh), $this->last_error);
            return false;
        }

        if( $this->_query )
        {
            $this->_queryCounter++;

            switch ($type)
            {

                default:
                case 'OBJECT':
                    $this->_queryResult = $this->_query;
                    break;

                case 'FETCH':
                    $this->_queryResult = $this->fetch('ARRAY');

                    if(is_numeric($cache) && $cache > 0 && $this->_memcache_ready)
                    {
                        $this->_memcache->set($memory_key, $this->_queryResult, MEMCACHE_COMPRESSED, $cache);
                    }

                    break;

                case 'SMART_FETCH':
                    $this->_queryResult = $this->fetch('SMART');

                    if(is_numeric($cache) && $cache > 0 && $this->_memcache_ready)
                    {
                        $this->_memcache->set($memory_key, $this->_queryResult, MEMCACHE_COMPRESSED, $cache);
                    }

                    break;

                case 'PAGING':
                    $ret['data'] = $this->fetch('ARRAY');
                    $sql = "SELECT FOUND_ROWS()";
                    $result = mysqli_query( $this->dbh, $sql );
                    $count = $result->fetch_array(MYSQLI_NUM);
                    $ret['count'] = $count[0];
                    mysqli_free_result( $result );
                    $this->_queryResult = $ret;

                    if(is_numeric($cache) && $cache > 0 && $this->_memcache_ready)
                    {
                        $this->_memcache->set($memory_key, $this->_queryResult, MEMCACHE_COMPRESSED, $cache);
                    }

                    break;
            }
        }
        else
        {
            $this->_error(4, 'MySQL query error', 'PHP - MySQL error: '. mysqli_errno($this->dbh) .' - '. mysqli_error($this->dbh));
        }
        mysqli_free_result( $this->_query );

        return $this->_queryResult;

    }

    private function fetch($type='ARRAY')
    {
        $returnArray = array();
        switch ($type)
        {
            case 'ARRAY':
                while ($row = mysqli_fetch_assoc( $this->_query ))
                {
                    $returnArray[] = $row;
                }
                break;

            case 'SMART':
                if(mysqli_num_rows( $this->_query ) > 1)
                {
                    while ($row = mysqli_fetch_assoc( $this->_query ))
                    {
                        $returnArray[] = $row;
                    }
                }
                else
                {
                    $returnArray =  mysqli_fetch_assoc( $this->_query );
                }
                break;
        }

        return $returnArray;
    }

    /**
     * Number of affected rows
     *
     * @return integer
     */
    public function affectedRows()
    {
        return mysqli_affected_rows($this->dbh);
    }

    /**
     * Last insert id
     *
     * @return integer
     */
    public function lastInsertID()
    {
        return mysqli_insert_id($this->dbh);
    }

    /**
     * Disconect from server
     *
     * @return boolean
     */
    public function disconnect()
    {
        if ( !$this->dbh )
            return true;

        return mysqli_close($this->dbh);
    }

    /**
     * Return errors
     *
     * @return array
     */
    public function showErrors()
    {
        return $this->_errors;
    }

    /**
     * Add error to error list
     *
     * @param integer $errorId
     * @param string $errorMsg
     * @param string $extraData
     */
    private function _error($errorId, $errorMsg, $extraData=NULL)
    {
        $this->_errors[]=array('errorId'=>$errorId, 'errorMsg'=>$errorMsg, 'extraData'=>$extraData);
    }
}