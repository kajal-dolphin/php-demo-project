<?php
    include("config/db.php");

    global $email_exist, $f_NameErr, $l_NameErr, $_emailErr, $_mobileErr, $_passwordErr, $_confirmPwdErr;
    global $fNameEmptyErr,$lNameEmptyErr,$emailEmptyErr, $mobileEmptyErr, $passwordEmptyErr, $confirmPasswordEmptyErr;

    if(isset($_POST["submit"])){
        $firstname = $_POST["firstname"];
        $lastname = $_POST["lastname"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $mobilenumber = $_POST["mobilenumber"];
        $confirm_password = $_POST["confirm_password"];

        // check if email already exist
        $email_check_query = mysqli_query($connection, "SELECT * FROM users WHERE email = '{$email}' ");
        $rowCount = mysqli_num_rows($email_check_query);

        if(!empty($firstname) && !empty($lastname) && !empty($email) && !empty($password) && !empty($mobilenumber) && !empty($confirm_password))
        {
            if($rowCount > 0) {
                $email_exist = '
                    <div class="text-danger">
                        User with email already exist!
                    </div>
                ';
            }
            else{
                $_first_name = mysqli_real_escape_string($connection, $firstname);
                $_last_name = mysqli_real_escape_string($connection, $lastname);
                $_email = mysqli_real_escape_string($connection, $email);
                $_password = mysqli_real_escape_string($connection, $password);
                $_mobile_number = mysqli_real_escape_string($connection, $mobilenumber);
                $_confirm_password = mysqli_real_escape_string($connection, $confirm_password);

                if(!preg_match("/^[a-zA-Z ]*$/", $_first_name)) {
                    $f_NameErr = '<div class="text-danger">
                            Only letters and white space allowed.
                        </div>';
                }
                if(!preg_match("/^[a-zA-Z ]*$/", $_last_name)) {
                    $l_NameErr = '<div class="text-danger">
                            Only letters and white space allowed.
                        </div>';
                }
                if(!filter_var($_email, FILTER_VALIDATE_EMAIL)) {
                    $_emailErr = '<div class="text-danger">
                            Email format is invalid.
                        </div>';
                }
                if(!preg_match("/^[0-9]{10}+$/", $_mobile_number)) {
                    $_mobileErr = '<div class="text-danger">
                            Only 10-digit mobile numbers allowed.
                        </div>';
                }
                if(!preg_match("/^(?=.*\d)(?=.*[@#\-_$%^&+=§!\?])(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z@#\-_$%^&+=§!\?]{6,20}$/", $_password)) {
                    $_passwordErr = '<div class="text-danger">
                             Password should be between 6 to 20 charcters long, contains atleast one special chacter, lowercase, uppercase and a digit.
                        </div>';
                }
                if($_POST["password"] !== $_POST["confirm_password"]){
                    $_confirmPwdErr = '<div class="text-danger">
                            Password and Confirm Password are not same
                        </div>';
                }

                if((preg_match("/^[a-zA-Z ]*$/", $_first_name)) && (preg_match("/^[a-zA-Z ]*$/", $_last_name)) &&
                    (filter_var($_email, FILTER_VALIDATE_EMAIL)) && (preg_match("/^[0-9]{10}+$/", $_mobile_number)) && 
                    (preg_match("/^(?=.*\d)(?=.*[@#\-_$%^&+=§!\?])(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z@#\-_$%^&+=§!\?]{8,20}$/", $_password))){

                    $password_hash = password_hash($password, PASSWORD_BCRYPT);

                    $sql = "INSERT INTO users (firstname, lastname, email, mobilenumber, password, is_active,
                        date_time) VALUES ('{$firstname}', '{$lastname}', '{$email}', '{$mobilenumber}', '{$password_hash}', 
                        '0', now())";

                    $sqlQuery = mysqli_query($connection, $sql);
                                        
                    if(!$sqlQuery){
                        die("MySQL query failed!" . mysqli_error($connection));
                    } 
                }
            }
        }else{
            if(empty($firstname)){
                $fNameEmptyErr = '<div class="text-danger">
                    First name can not be blank.
                </div>';
            }
            if(empty($lastname)){
                $lNameEmptyErr = '<div class="text-danger">
                    Last name can not be blank.
                </div>';
            }
            if(empty($email)){
                $emailEmptyErr = '<div class="text-danger">
                    Email can not be blank.
                </div>';
            }
            if(empty($mobilenumber)){
                $mobileEmptyErr = '<div class="text-danger">
                    Mobile Number can not be blank.
                </div>';
            }
            if(empty($password)){
                $passwordEmptyErr = '<div class="text-danger">
                    Password can not be blank.
                </div>';
            }
            if(empty($confirm_password)){
                $confirmPasswordEmptyErr = '<div class="text-danger">
                    Confirm Password can not be blank.
                </div>';
            }
        }
    }
?>