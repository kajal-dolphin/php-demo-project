
<?php
class Connection
{
    public $connection;
    private $servername = "localhost";
    private $username = "root";
    private $password = "Admin@123";
    private $dbname = "e_commorce_demo";

    public function __construct()
    {
        // Create connection
        $this->connection = mysqli_connect($this->servername, $this->username, $this->password, $this->dbname);

        // Check connection
        if (!$this->connection) {
            die("Connection failed: " . mysqli_connect_error());
        }

        return $this->connection;
    }
}
