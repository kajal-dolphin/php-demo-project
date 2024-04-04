<!doctype html>
<html lang="en" class="minimal-theme">

<head>
    <?php
    session_start();

    include_once('view/admin/layout/head-link.php');

    if (isset($_SESSION['id'])) {
        header("Location: view/admin/layout/dashboard.php");
    }

    ?>
    <title>Login</title>
</head>

<body>

    <!--start wrapper-->
    <div class="wrapper">
        <!--start content-->
        <main class="authentication-content">
            <div class="container-fluid">
                <div class="container p-5">
                    <div id="message-container" class="msgContainer"></div>
                </div>
                <div class="authentication-card">
                    <!-- Add a container for displaying messages -->
                    <div class="card shadow rounded-0 overflow-hidden">
                        <div class="row g-0">
                            <div class="col-lg-6 bg-login d-flex align-items-center justify-content-center">
                                <img src="/e_commorce/public/admin/assets/images/error/login-img.jpg" class="img-fluid" alt="">
                            </div>
                            <div class="col-lg-6">
                                <div class="card-body p-4 p-sm-5">
                                    <h5 class="card-title">Sign In</h5>
                                    <p class="card-text mb-5">See your growth and get consulting support!</p>
                                    <form class="form-body" action="" method="" id="loginForm">
                                        <div class="row g-3">
                                            <div class="col-12">
                                                <label for="inputEmailAddress" class="form-label">Email Address</label>
                                                <div class="ms-auto position-relative">
                                                    <!-- <div class="position-absolute top-50 translate-middle-y search-icon px-3"><i class="bi bi-envelope-fill"></i></div> -->
                                                    <input type="email" class="form-control radius-30 ps-5" id="inputEmailAddress" placeholder="Email Address" name="email">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <label for="inputChoosePassword" class="form-label">Enter Password</label>
                                                <div class="ms-auto position-relative">
                                                    <!-- <div class="position-absolute top-50 translate-middle-y search-icon px-3"><i class="bi bi-lock-fill"></i></div> -->
                                                    <input type="password" class="form-control radius-30 ps-5" id="inputChoosePassword" placeholder="Enter Password" name="password">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="d-grid">
                                                    <button type="submit" class="btn btn-primary radius-30" name="login" value="submit">Sign In</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!--end page main-->

    </div>
    <!--end wrapper-->

    <?php
    include_once('view/admin/layout/foot-link.php');
    ?>

    <script>
        $(document).ready(function() {
            $('#loginForm').validate({
                errorClass: 'errors',
                rules: {
                    email: {
                        required: true,
                        email: true
                    },
                    password: {
                        required: true,
                        minlength: 8
                    },
                },
                messages: {
                    email: {
                        required: 'Please enter Email Address.',
                        email: 'Please enter a valid Email Address.',
                    },
                    password: {
                        required: 'Please enter Password.',
                        minlength: 'Password must be at least 8 characters long.',
                    },
                },
                highlight: function(element) {
                    $(element).parent().addClass('text-danger')
                },
                unhighlight: function(element) {
                    $(element).parent().removeClass('text-danger')
                },
                submitHandler: function(form) {
                    $.ajax({
                        type: "POST",
                        url: "/e_commorce/controller/admin/auth/signin.php?action=login",
                        data: $(form).serialize(),
                        success: function(response) {
                            if (response == 0) {
                                console.log("here");
                                window.location.href = '/e_commorce/view/admin/layout/dashboard.php';
                            } else if (response == "1") {
                                console.log("in 1");
                                $('#message-container').html('<div class="alert alert-danger">' + "Invalid Credentials !!" + '</div>');
                                $("#message-container").fadeOut(5000);
                                window.location.href = './index.php';
                            } else if (response == "2") {
                                $('#message-container').html('<div class="alert alert-danger">' + "Either Email or Password is Empty" + '</div>');
                                $("#message-container").fadeOut(5000);
                                window.location.href = './index.php';
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log("in error");
                        }
                    });
                }
            });
        });
    </script>

</body>

</html>