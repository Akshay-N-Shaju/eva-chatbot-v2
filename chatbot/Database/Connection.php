<?php

/*Developed By : Akshay N Shaju
Developed On : 14/03/18
Last Updated : --*/

class Connection
{

    /**
     * @var string
     */
    private static $host = '';

    /**
     * @var string
     */
    private static $user = '';

    /**
     * @var string
     */
    private static $pass = '';

    /**
     * @var string
     */
    private static $dbName = '';

    /**
     * @var bool
     */
    private static $isConnected = false;


    /**
     * @var int|bool
     */
    public static $connIdent;

    protected static $transactionOpen = false;


    /**
     * @param array $connectionInfo
     */
    public static function init($connectionInfo)
    {

        LOG && print("connect init ...\n");
        self::$host = $connectionInfo['host'];
        self::$user = $connectionInfo['user'];
        self::$pass = $connectionInfo['pass'];
        self::$dbName = $connectionInfo['dbName'];
    }

    private static function OpenConnect()
    {
        if (self::$dbName == '' || self::$host == '' || self::$user == '')
            trigger_error("Class [Connect] is not initialized !");
        self::$connIdent = mysqli_connect(self::$host, self::$user, self::$pass, self::$dbName) or die("\nmysqli connection err : ". mysqli_error(self::$connIdent));
        if (self::$connIdent->connect_error) {
            die("mysql con err : " . $conn->connect_error);
        }
        self::$isConnected = true;
    }


    /**
     * @param String $database
     * @return boolean
     */
    public static function CheckDatabaseExist($database)
    {
        self::$connIdent = mysqli_connect(self::$host, self::$user, self::$pass);

        $sql = 'SELECT COUNT(*) AS `exists` FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMATA.SCHEMA_NAME="' . $database . '"';

        $result = mysqli_query(self::$connIdent, $sql) or die('Query Invalid: ' . mysqli_errno() . "\nSql is :\n" . $sql);

        $data = mysqli_fetch_assoc($result);
        return $data['exists'] == '1';
    }


    /**
     * @param string $sql
     * @return conteudo da query
     */
    public static function Query($sql)
    {
        if(!self::$isConnected)
            self::OpenConnect();

        $result = mysqli_query(self::$connIdent, $sql) or die('Query Invalid : ' . mysqli_error() . "\nSql is :\n" . $sql);
        return $result;
    }

    /**
     * @param string $sql
     */
    public static function Fetch($sql)
    {
        $data = array();
        $result = self::Query($sql);

        while ($row = mysqli_fetch_assoc($result))
            $data[] = $row;
        //

        return $data;
    }

    /**
     */
    public static function Close()
    {
        mysqli_close(self::$connIdent);
    }

    public static function Begin()
    {
        if(!self::$transactionOpen)
            self::Commit();

        self::Query("begin");
        self::$transactionOpen = true;
    }

    public static function Commit()
    {
        self::Query("commit");
        self::$transactionOpen = false;
    }
    public static function Rollback()
    {
        self::Query("rollback");
        self::$transactionOpen = false;
    }
    public static function GetOne($sql, $index = 0) {
        $data = self::Fetch($sql);
        if(count($data) > 0)
            return $data[$index];
        else
            return false;
    }
}