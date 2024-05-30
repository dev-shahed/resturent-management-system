<?php
//require '../config/config.php';
define("HOST", "127.0.0.1");
define("DBNAME", "demo");
define("USER", "root");
define("PASS", "");

class App
{
    public $host = HOST;
    public $dbname = DBNAME;
    public $user = USER;
    public $pass = PASS;

    public $link;

    public function __construct()
    {
        $this->connect();
    }

    public function connect()
    {
        try {
            $this->link = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->dbname, $this->user, $this->pass);
            $this->link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "Connected successfully";
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }
}

$obj = new App;
