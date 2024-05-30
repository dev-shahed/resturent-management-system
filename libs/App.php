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

    // Select all rows matching the query.
    public function selectAll($query)
    {
        $rows = $this->link->prepare($query);

        // Execute the statement.
        $rows->execute();

        // Fetch all rows as objects.
        $allRows = $rows->fetchAll(PDO::FETCH_OBJ);

        // Check if rows were found.
        if ($allRows) {
            return $allRows;
        } else {
            return false;
        }
    }

    // Select a single row matching the query.
    public function selectOne($query)
    {
        $row = $this->link->prepare($query);

        // Execute the statement.
        $row->execute();

        // Fetch the single row as an object.
        $singleRow = $row->fetch(PDO::FETCH_OBJ);

        // Check if row was found.
        if ($singleRow) {
            return $singleRow;
        } else {
            return false;
        }
    }
}

$obj = new App;
