<?php

require_once "../../../config/db.php";
session_start();

class Login extends Connection{

    public function login(){

        global $emailEmptyErr, $passEmptyErr, $wrongEmailErr, $wrongPwdErr, $accountNotExistErr, $emailPwdErr;

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            try {
                if (!empty($_POST["email"]) && !empty($_POST["password"])) {
                    $email = $_POST["email"];
                    $pwd = $_POST["password"];
                    $password = md5($_POST["password"]);

                    $sql = "SELECT * From admin WHERE email = '{$email}' AND password = '{$password}'";
                    $query = mysqli_query($this->connection, $sql);

                    if (mysqli_num_rows($query) > 0) {
                        $row = mysqli_fetch_assoc($query);
                        $_SESSION['id'] = $row['id'];
                        $_SESSION['email'] = $email;
                        echo '0';
                    } else {
                        echo '1';
                    }
                }
                else{
                    echo '2';
                }
            } catch (\Exception $e) {
                echo 'Message: ' .$e->getMessage();
            }
        }
    }
}
