<?php
    include('./controller/signup.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</head>
<body>
    <?php
        include('header.php');
    ?>
    <div class="container p-5">
        <div class="row p-5">
            <div class="card p-5">
                <div class="card-header">
                    <h3>User Registration</h3>
                </div>
                <div class="card-body">
                    <form action="" method="post">
                        <div class="form-group mb-3">
                            <label for="firstname">First Name :</label>
                            <input type="text" class="form-control" placeholder="Enter your First name" name="firstname">
                            <?php echo $f_NameErr; ?>
                            <?php echo $fNameEmptyErr; ?>
                        </div>
                        <div class="form-group mb-3">
                            <label for="lastname">Last Name :</label>
                            <input type="text" class="form-control" placeholder="Enter your Last name" name="lastname">
                            <?php echo $l_NameErr; ?>
                            <?php echo $lNameEmptyErr; ?>
                        </div>
                        <div class="form-group mb-3">
                            <label for="email">Email :</label>
                            <input type="email" class="form-control" placeholder="Enter your Email" name="email">
                            <?php echo $email_exist; ?>
                            <?php echo $emailEmptyErr; ?>
                            <?php echo $_emailErr; ?>
                        </div>
                        <div class="form-group mb-3">
                            <label for="email">Mobile Number :</label>
                            <input type="text" class="form-control" placeholder="Enter your Phone Number" name="mobilenumber">
                            <?php echo $mobileEmptyErr; ?>
                            <?php echo $_mobileErr; ?>
                        </div>
                        <div class="form-group mb-3">
                            <label for="password">Password :</label> 
                            <input type="password" class="form-control" placeholder="Enter your Password" name="password">
                            <?php echo $passwordEmptyErr; ?>
                            <?php echo $_passwordErr; ?>
                        </div>
                        <div class="form-group mb-3">
                            <label for="confirm_password">Confirm Password :</label>
                            <input type="password" class="form-control" placeholder="Enter your Confirm Password" name="confirm_password">
                            <?php echo $confirmPasswordEmptyErr; ?>
                            <?php echo $_confirmPwdErr;?>
                        </div>
                        <div class="mb-3">
                            <span>Already Register ?? <a href="index.php">Login</a></span>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit" value="submit" name="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>