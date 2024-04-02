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
    <title>List Product</title>
    <style>
        .AClass{
            top:8px;
            position: absolute;
        }
    </style>
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
                            <li class="breadcrumb-item active" aria-current="page">Product List</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#productAddModal">
                        Add Product
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
                            <th>Category Name</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            include('../../../config/db.php');

                            $sql = "SELECT p.id, p.name as product_name, c.name as category_name, b.name as brand_name
                                    FROM products AS p
                                    JOIN brands AS b ON b.id = p.brand_id 
                                    JOIN categories AS c ON c.id = p.category_id";

                            $query = mysqli_query($connection, $sql);

                            if(mysqli_num_rows($query) > 0){
                                foreach($query as $key => $product){                                    
                            ?>
                                <tr>
                                    <td><?= ++$key; ?></td>
                                    <td><?= $product['product_name']; ?></td>
                                    <td><?= $product['brand_name']; ?></td>
                                    <td><?= $product['category_name']; ?></td>
                                    <td>
                                        <button class="btn btn-info viewProduct" type="button" value="<?= $product['id']; ?>">View</button>
                                        <button class="btn btn-warning editProduct" type="button" value="<?= $product['id']; ?>">Edit</button>
                                        <button class="btn btn-danger deleteProduct" type="button" value="<?= $product['id']; ?>">Delete</button>
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

    <?php include('./product.modal.php');  ?>

    <?php include('../layout/foot-link.php');  ?>
    <script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.js"></script>
    <script>
        <?php  include('../../../public/admin/assets/custom_js/product.js'); ?>
    </script>

</body>

</html>