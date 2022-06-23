<?php

class db_connect
{
    private $hostname;
    private $username;
    private $password;
    private $dbname;

    public function __construct()
    {
        $this->hostname = "localhost";
        $this->username = "root";
        $this->password = "admin";
        $this->dbname = "forum_schema";
    }

    public function connect()
    {
        try {
            $mysqli = new mysqli($this->hostname, $this->username, $this->password, $this->dbname);
            return $mysqli;

        } catch (Exception $e) {
            $this->alert($e->getMessage());
        }
    }

    public function alert($message) {
        $escapedMessage = str_replace("'", "\'", $message);
        echo "<script type='text/javascript'>alert('$escapedMessage');</script>";
    }
}
?>