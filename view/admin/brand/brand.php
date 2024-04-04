<!doctype html>
<html lang="en" class="minimal-theme">

<head>
    <?php
    include_once('../layout/head-link.php');
    session_start();
    if (!isset($_SESSION['id'])) {
        header("Location: /e_commorce/index.php");
    }
    ?>
    <title>List Brand</title>
</head>

<body>
    <!--start wrapper-->
    <div class="wrapper">
        <!--start top header-->
        <header class="top-header">
            <?php include_once('../layout/header.php') ?>
        </header>
        <!--end top header-->

        <!--start sidebar -->
        <?php include_once('../layout/sidebaar.php')  ?>
        <!--end sidebar -->

        <!--start content-->
        <main class="page-content">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">eCommerce</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Brand List</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#brandAddModal">
                        Add Brand
                    </button>
                </div>
            </div>
            <div class="pt-3">
                <table id="example" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        include('../../../modal/admin/brand/brand.php');

                        $obj = new Brand();
                        $query = $obj->getBrandData();

                        if (mysqli_num_rows($query) > 0) {
                            foreach ($query as $key => $brand) {
                        ?>
                                <tr>
                                    <td><?= ++$key; ?></td>
                                    <td><?= $brand['name'] ?></td>
                                    <td>
                                        <img src='../../../public/admin/assets/images/brand/<?= $brand['image'] ?>' width="100" height="100" />
                                    </td>
                                    <td>
                                        <button class="btn btn-info viewBrand" type="button" value="<?= $brand['id']; ?>">View</button>
                                        <button class="btn btn-warning editBrand" type="button" value="<?= $brand['id']; ?>">Edit</button>
                                        <button class="btn btn-danger deleteBrand" type="button" value="<?= $brand['id']; ?>">Delete</button>
                                    </td>
                                </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <!--end row-->
        </main>
        <!--end page main-->
    </div>

    <?php  include_once('./brand.modal.php'); ?>

    <?php include_once('../layout/foot-link.php');  ?>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.js"></script>
    <script>
        <?php  include_once('../../../public/admin/assets/custom_js/brand.js'); ?>
    </script>
</body>

</html>