<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login System</title>
</head>
<body>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
    <?php
        include('header.php');
    ?>
    <div class="container p-5">
        <div class="row p-5">
            <div class="card p-5">
                <div class="card-header">
                    <h3>User Login</h3>
                </div>
                <div class="card-body">
                    <form action="" method="post">
                        <div class="form-group mb-3">
                            <label for="email">Email :</label>
                            <input type="email" class="form-control" placeholder="Enter your Email" name="email">
                        </div>
                        <div class="form-group mb-3">
                            <label for="password">Password :</label> 
                            <input type="password" class="form-control" placeholder="Enter your Password" name="password">
                        </div>
                        <div class="mb-3">
                            <span>Not a Register User?? <a href="signup.php">Create an account</a></span>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</html>