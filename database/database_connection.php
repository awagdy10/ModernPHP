<?php

class DataBase_Class 
{
 
    private $host      = '172.19.0.1';
    private $username  = 'root';
    private $password  = 'root';
    private $db_name   = 'modernphp';

    private static $instance;
    private  $database_connection;

    public function __construct() 
    {
      $this->database_connection = $this->database_connect($this->host, $this->username,$this->password);
      $this->database_select($this->db_name);

    }

    public static function getInstance()
    {
        if(!self::$instance)
        {
            self::$instance= new  self();
        }

        return self::$instance;
    }

    private function database_connect($database_host, $database_username, $database_password) 
    {
        if ($c = mysqli_connect($database_host, $database_username, $database_password)) 
        {
            return $c;

        }
        else 
        {
            die("Database connection error");
        }
    }

    private function database_select($database_name) 
    {
        return mysqli_select_db($this->database_connection, $database_name)
            or die("no db is selecteted");
    }


    public function clean($str) 
    {
        $str = trim($str);

        if(get_magic_quotes_gpc()) 
        {
        $str = stripslashes($str);
        }

        return mysqli_real_escape_string($this->database_connection,$str); //Clean any SQL words.
    }

    public function database_query($database_query) 
    {
        $query_result = mysqli_query($this->database_connection, $database_query);
        if(!$query_result)
        {
            echo("Error description: " . mysqli_error($this->database_connection));
        }
        else
        {
            return $query_result;
        }
    }

    public function get_row($query) 
    {
        if (!strstr(strtoupper($query), "LIMIT"))
            $query .= " LIMIT 0,1";

        if (!($res =$this->database_query($query))) 
        {
        echo( "Database error: " . mysqli_error($this->database_connection) . "<br/>In query: " . $query);
        }

        return mysqli_fetch_assoc($res);
    }


    public function get_rows($query) 
    {
        if (!($res =$this->database_query($query))) 
        {
         echo( "Database error: " . mysqli_error($this->database_connection) . "<br/>In query: " . $query);
        }

        $array_return = array();

        while ($row = mysqli_fetch_assoc($res)) 
        {
            $array_return[] = $row;
        }
        return $array_return;
    }


    public function database_num_rows($database_result) 
    {

        return mysqli_num_rows($database_result);
    }


}


?>
