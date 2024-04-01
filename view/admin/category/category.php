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

                            $sql = "SELECT categories.id, categories.name as category_name, brands.name as brand_name from categories JOIN brands ON brands.id = categories.brand_id ";
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


    <!-- Add Category Modal -->
    <div class="modal fade" id="categoryAddModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="saveCategory">
                    <div class="modal-body">

                        <div id="errorMessage" class="alert alert-danger d-none"></div>

                        <div class="mb-3">
                            <label for="">Name</label>
                            <div>
                                <input type="text" name="name" class="form-control" />
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="brand">Brand</label>
                            <div>
                                <select name="brand_id" class="form-select">
                                    <option value="default">-----select a brand----</option>
                                    <?php
                                    include('../../../config/db.php');
                                    $sql = "SELECT * FROM brands";
                                    $query = mysqli_query($connection, $sql);

                                    while ($row = mysqli_fetch_assoc($query)) {
                                        echo "<option value='$row[id]'>$row[name]</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- View Category Modal -->
    <div class="modal fade" id="categoryViewModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">View Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="">Category Name</label>
                        <p id="view_category_name" class="form-control"></p>
                    </div>
                    <div class="mb-3">
                        <label for="">Brand Name</label>
                        <p id="view_brand_name" class="form-control"></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Category Modal -->
    <div class="modal fade" id="categoryEditModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="updateCategory">
                    <div class="modal-body">

                        <div id="errorMessageUpdate" class="alert alert-danger d-none"></div>
                        <input type="hidden" name="edit_category_id" id="edit_category_id">
                        <div class="mb-3">
                            <label for="">Name</label>
                            <div>
                                <input type="text" name="name" id="edit_category_name" class="form-control" />
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="brand">Brand</label>
                            <div>
                                <select name="brand_id" class="form-select editSelectedOption" id="">
                                    <option value="default">-----select a brand----</option>
                                    <?php
                                    include('../../../config/db.php');
                                    $sql = "SELECT * FROM brands";
                                    $query = mysqli_query($connection, $sql);

                                    while ($row = mysqli_fetch_assoc($query)) {
                                        echo "<option value='$row[id]'>$row[name]</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include('../layout/foot-link.php');  ?>

    <script>
        $(document).ready(function() {

            //for create category
            $.validator.addMethod("valueNotEquals", function(value, element, arg){
                return arg !== value;
            }, "Value must not equal arg.");

            $('#saveCategory').validate({
                errorClass: 'errors',
                rules: {
                    name: {
                        required: true,
                        maxlength: 255,
                    },
                    brand_id : {
                        valueNotEquals: "default"
                    },
                },
                messages: {
                    name: {
                        required: 'Please enter name.',
                        maxLength: 'Max length is 255 character.',
                    },
                    brand_id : {
                        valueNotEquals: "Please select a option!"
                    }
                },
                highlight: function(element) {
                    $(element).parent().addClass('text-danger')
                },
                unhighlight: function(element) {
                    $(element).parent().removeClass('text-danger')
                },
                submitHandler: function(form) {
                    var formData = new FormData(form);
                    formData.append("save_category", true);

                    $.ajax({
                        type: "POST",
                        url: "../../../controller/admin/category/category.php",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            var res = jQuery.parseJSON(response);
                            if (res.status == 422) {
                                $('#errorMessage').removeClass('d-none');
                                $('#errorMessage').text(res.message);

                            } else if (res.status == 200) {

                                $('#errorMessage').addClass('d-none');
                                $('#categoryAddModal').modal('hide');
                                $('#saveCategory')[0].reset();

                                alertify.set('notifier', 'position', 'top-right');
                                alertify.success(res.message);

                                $('#example').load(location.href + " #example");

                            } else if (res.status == 500) {
                                alert(res.message);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log("in error");
                        }
                    });
                }
            });

            //for view detail 
            $(document).on('click', '.viewCategory', function(e) {
                e.preventDefault();
                var category_id = $(this).val();
                $.ajax({
                    type: "GET",
                    url: "../../../controller/admin/category/category.php?category_id=" + category_id,
                    success: function(response) {
                        var res = jQuery.parseJSON(response);
                        if (res.status == 404) {
                            alert(res.message);
                        } else if (res.status == 200) {
                            $('#view_category_name').text(res.data.category_name);
                            $('#view_brand_name').text(res.data.brand_name);
                            $('#categoryViewModal').modal('show');
                        }
                    }
                });
            });

            //for edit detail 
            $(document).on('click', '.editCategory', function(e) {
                e.preventDefault();
                var category_id = $(this).val();
                $.ajax({
                    type: "GET",
                    url: "../../../controller/admin/category/category.php?category_id=" + category_id,
                    success: function(response) {
                        var res = jQuery.parseJSON(response);
                        if (res.status == 404) {
                            alert(res.message);
                        } else if (res.status == 200) {
                            $('#edit_category_name').val(res.data.category_name);
                            $('#edit_category_id').val(res.data.category_id);
                            $.each($('.editSelectedOption option'),function(a,b){
                                if($(this).val() == res.data.brand_id){
                                    $(this).attr('selected',true)
                                }
                            });
                            $('#categoryEditModal').modal('show');
                        }
                    }
                });
            });

            //for update category
            $.validator.addMethod("valueNotEquals", function(value, element, arg){
                return arg !== value;
            }, "Value must not equal arg.");

            $('#updateCategory').validate({
                errorClass: 'errors',
                rules: {
                    name: {
                        required: true,
                        maxlength: 255,
                    },
                    brand_id : {
                        valueNotEquals: "default"
                    },
                },
                messages: {
                    name: {
                        required: 'Please enter name.',
                        maxLength: 'Max length is 255 character.',
                    },
                    brand_id : {
                        valueNotEquals: "Please select a option!"
                    }
                },
                highlight: function(element) {
                    $(element).parent().addClass('text-danger')
                },
                unhighlight: function(element) {
                    $(element).parent().removeClass('text-danger')
                },
                submitHandler: function(form) {
                    var formData = new FormData(form);
                    formData.append("update_category", true);

                    $.ajax({
                        type: "POST",
                        url: "../../../controller/admin/category/category.php",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            var res = jQuery.parseJSON(response);
                            if (res.status == 422) {
                                $('#errorMessageUpdate').removeClass('d-none');
                                $('#errorMessageUpdate').text(res.message);

                            } else if (res.status == 200) {

                                $('#errorMessageUpdate').addClass('d-none');
                                $('#categoryEditModal').modal('hide');
                                $('#updateCategory')[0].reset();

                                alertify.set('notifier', 'position', 'top-right');
                                alertify.success(res.message);

                                $('#example').load(location.href + " #example");

                            } else if (res.status == 500) {
                                alert(res.message);
                            } else if (res.status == 400) {
                                $('#errorMessageUpdate').removeClass('d-none');
                                $('#errorMessageUpdate').text(res.message);

                            }
                        },
                        error: function(xhr, status, error) {
                            console.log("in error");
                        }
                    });
                }
            });

            //for delete brand 
            $(document).on('click', '.deleteCategory', function(e) {
                e.preventDefault();

                if (confirm('Are you sure you want to delete this data?')) {
                    var category_id = $(this).val();
                    $.ajax({
                        type: "POST",
                        url: "../../../controller/admin/category/category.php",
                        data: {
                            'delete_category': true,
                            'category_id': category_id
                        },
                        success: function(response) {

                            var res = jQuery.parseJSON(response);
                            if (res.status == 500) {

                                alert(res.message);
                            } else {
                                alertify.set('notifier', 'position', 'top-right');
                                alertify.success(res.message);

                                $('#example').load(location.href + " #example");
                            }
                        }
                    });
                }
            });
        });
    </script>
</body>

</html>