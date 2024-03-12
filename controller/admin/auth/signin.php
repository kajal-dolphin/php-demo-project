<?php

    include('config/db.php');

    global $emailEmptyErr, $passEmptyErr, $wrongPwdErr, $accountNotExistErr, $emailPwdErr;

    if($_POST["submit"]){
        if(!empty($_POST["email"]) && !empty($_POST["password"])){
            $email = $_POST["email"];
            $password = $_POST["password"];
            
            $user_email = filter_var($email_signin, FILTER_SANITIZE_EMAIL);
            $pswd = mysqli_real_escape_string($connection, $password_signin);

            $sql = "SELECT * From users WHERE email = '{$email}' ";
            $query = mysqli_query($connection, $sql);
            $rowCount = mysqli_num_rows($query);

            if(!$query){
               die("SQL query failed: " . mysqli_error($connection));
            }
            
            if(!empty($email) && !empty($password)){
                if(!preg_match("/^(?=.*\d)(?=.*[@#\-_$%^&+=§!\?])(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z@#\-_$%^&+=§!\?]{6,20}$/", $pswd)) {
                    $wrongPwdErr = '<div class="alert alert-danger">
                            Password should be between 6 to 20 charcters long, contains atleast one special chacter, lowercase, uppercase and a digit.
                        </div>';
                }
               
                if($rowCount <= 0) {
                    $accountNotExistErr = '<div class="alert alert-danger">
                            User account does not exist.
                        </div>';
                } else {
                    
                    while($row = mysqli_fetch_array($query)) {
                        $adminEmail         = $row['email'];
                        $pass_word     = $row['password'];
                    }

                    // Verify password
                    $verifyPassword = password_verify($password, $pass_word);

                    // Allow only verified user
                    if($email == $adminEmail && $password_signin == $verifyPassword) {
                        header("Location: ./dashboard.php");
                        $_SESSION['id'] = $id;
                        $_SESSION['email'] = $email;
                    } else {
                        $emailPwdErr = '<div class="alert alert-danger">
                                Either email or password is incorrect.
                            </div>';
                    }
                }
            }
        }
        else{
            if(empty($_POST["email"])){
                $emailEmptyErr = "<div class='text-danger'>
                            Email is not empty.
                    </div>";
            }
            
            if(empty($_POST["password"])){
                $passEmptyErr = "<div class='text-danger'>
                            Password is not empty.
                        </div>";
            }  
        }
    }
?>