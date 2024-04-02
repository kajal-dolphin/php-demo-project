<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include('../layout/head-link.php');
    session_start();
    if (!isset($_SESSION['id'])) {
        header("Location: /e_commorce/index.php");
    }
    ?>
    <title>List Brand</title>
</head>

<body>
    <div class="wrapper">
        <!--start top header-->
        <header class="top-header">
            <?php include('../layout/header.php') ?>
        </header>
        <!--end top header-->

        <!--start sidebar -->
        <?php include('../layout/sidebaar.php')  ?>
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
                            <li class="breadcrumb-item active" aria-current="page">Category List</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#categoryAddModal">
                        Add Category
                    </button>
                </div>
            </div>
            <div class="pt-3">
                <table id="example" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Brand Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            include('../../../config/db.php');

                            $sql = "SELECT c.id,c.name as category_name, b.name as brand_name from categories AS c JOIN brands AS b ON b.id = c.brand_id ";
                            $query = mysqli_query($connection, $sql);

                            if(mysqli_num_rows($query) > 0){
                                foreach($query as $key => $category){                                    
                            ?>
                                <tr>
                                    <td><?= ++$key; ?></td>
                                    <td><?= $category['category_name']; ?></td>
                                    <td><?= $category['brand_name']; ?></td>
                                    <td>
                                        <button class="btn btn-info viewCategory" type="button" value="<?= $category['id']; ?>">View</button>
                                        <button class="btn btn-warning editCategory" type="button" value="<?= $category['id']; ?>">Edit</button>
                                        <button class="btn btn-danger deleteCategory" type="button" value="<?= $category['id']; ?>">Delete</button>
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

    <?php  include('./category.modal.php');  ?>

    <?php include('../layout/foot-link.php');  ?>

    <script>
        <?php  include('../../../public/admin/assets/custom_js/category.js'); ?>
    </script>
</body>

</html>