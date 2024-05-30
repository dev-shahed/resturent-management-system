<?php

// Adjust the relative path to config.php
require __DIR__ . "/../config/config.php";

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
