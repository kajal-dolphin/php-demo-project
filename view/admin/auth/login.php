
<?php  include('controller/admin/auth/signin.php') ?>

<!doctype html>
<html lang="en" class="minimal-theme">

<head>
    <?php 
        include('view/admin/layout/head-link.php');
    ?>
    <title>Login</title>
</head>

<body>

    <!--start wrapper-->
    <div class="wrapper">
        <?php $accountNotExistErr ?>
        <?php $emailPwdErr ?>
        <!--start content-->
        <main class="authentication-content">
            <div class="container-fluid">
                <div class="authentication-card">
                    <div class="card shadow rounded-0 overflow-hidden">
                        <div class="row g-0">
                            <div class="col-lg-6 bg-login d-flex align-items-center justify-content-center">
                                <img src="assets/images/error/login-img.jpg" class="img-fluid" alt="">
                            </div>
                            <div class="col-lg-6">
                                <div class="card-body p-4 p-sm-5">
                                    <h5 class="card-title">Sign In</h5>
                                    <p class="card-text mb-5">See your growth and get consulting support!</p>
                                    <form class="form-body" action="" method="post">
                                        <div class="row g-3">
                                            <div class="col-12">
                                                <label for="inputEmailAddress" class="form-label">Email Address</label>
                                                <div class="ms-auto position-relative">
                                                    <div class="position-absolute top-50 translate-middle-y search-icon px-3"><i class="bi bi-envelope-fill"></i></div>
                                                    <input type="email" class="form-control radius-30 ps-5" id="inputEmailAddress" placeholder="Email Address" name="email">
                                                </div>
                                                <?php  echo $emailEmptyErr; ?>
                                            </div>
                                            <div class="col-12">
                                                <label for="inputChoosePassword" class="form-label">Enter Password</label>
                                                <div class="ms-auto position-relative">
                                                    <div class="position-absolute top-50 translate-middle-y search-icon px-3"><i class="bi bi-lock-fill"></i></div>
                                                    <input type="password" class="form-control radius-30 ps-5" id="inputChoosePassword" placeholder="Enter Password" name="password">
                                                </div>
                                                <?php  echo $passEmptyErr; ?>
                                                <?php  echo $wrongPwdErr; ?>
                                            </div>
                                            <div class="col-12">
                                                <div class="d-grid">
                                                    <button type="submit" class="btn btn-primary radius-30" name="submit" value="submit">Sign In</button>
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
        include('view/admin/layout/foot-link.php');
    ?>

</body>

</html>