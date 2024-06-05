<?php require __DIR__ . "/../config/config.php";
define('BASE_URL', 'http://localhost:3000');

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
    public function insert($query, $arr, $path)
    {
        try {
            if ($this->validate(($arr) == "empty")) {
                echo "<script>alert('one or more inputs are empty')</script>";
            }
            $inset_record = $this->link->prepare($query);
            $inset_record->execute($arr);

            header("location: " . $path . "");
        } catch (\Throwable $th) {
            error_log($th->getMessage());
        }
    }

    public function update($query, $arr, $path)
    {
        try {
            if ($this->validate($arr) == "empty") {
                echo "<script>alert('One or more inputs are empty');</script>";
                return;
            }

            $update_record = $this->link->prepare($query);
            $update_record->execute($arr);

            header("Location: " . $path);
        } catch (\Throwable $th) {
            error_log($th->getMessage());
        }
    }

    public function delete($query, $arr, $path)
    {
        try {
            $delete_record = $this->link->prepare($query);
            $delete_record->execute($arr);

            header("Location: " . $path);
        } catch (\Throwable $th) {
            error_log($th->getMessage());
        }
    }

    //register and login
    public function register($query, $arr, $path)
    {
        try {
            if ($this->validate($arr) == "empty") {
                echo "<script>alert('One or more inputs are empty');</script>";
                return;
            }
            $register_user = $this->link->query($query);
            $register_user->execute($arr);

            header("location: " . $path . "");
        } catch (\Throwable $th) {
            error_log($th->getMessage());
        }
    }

    public function login($data, $arr, $path)
    {
        try {
            $login_user = $this->link->query($data);
            $login_user->execute($arr);
            $fetch = $login_user->fetch(PDO::FETCH_OBJ);

            if ($login_user->rowCount() > 0) {
                if (password_verify($data("password"), $fetch("password"))) {
                    //start season..
                    session_start();
                    header("location: " . $path . "");
                }
            }
        } catch (\Throwable $th) {
            error_log($th->getMessage());
        }
    }


    public function validate($arr)
    {
        if (in_array("", $arr)) {
            echo "empty";
        }
    }
}

