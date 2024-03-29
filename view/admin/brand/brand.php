<!doctype html>
<html lang="en" class="minimal-theme">

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
    <!--start wrapper-->
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
                        include('../../../config/db.php');

                        $sql = "SELECT * FROM brands";
                        $query = mysqli_query($connection, $sql);

                        if (mysqli_num_rows($query) > 0) {
                            foreach ($query as $brand) {
                        ?>
                                <tr>
                                    <td><?= $brand['id'] ?></td>
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


        <!-- Add Brand Modal -->
        <div class="modal fade" id="brandAddModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Brand</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="saveBrand">
                        <div class="modal-body">

                            <div id="errorMessage" class="alert alert-danger d-none"></div>

                            <div class="mb-3">
                                <label for="">Name</label>
                                <div>
                                    <input type="text" name="name" class="form-control" />
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="">Image</label>
                                <div>
                                    <input type="file" name="image" class="form-control" onchange="imagePreview(this);" />
                                    <div id="imagePreviewContainer" style="display: none;">
                                        <img id="previewImage" alt="your image" height="100px" width="100px" class="pt-2">
                                    </div>
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
    </div>

    <!-- View Brand Modal -->
    <div class="modal fade" id="brandViewModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">View Brand</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="">Name</label>
                        <p id="view_name" class="form-control"></p>
                    </div>
                    <div class="mb-3">
                        <label for="">Image</label>
                        <p>
                            <img src="" alt="" id="view_image" height="100px" width="100px">
                        </p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Edit Brand Modal -->
    <div class="modal fade" id="brandEditModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Brand</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="updateBrand">
                <div class="modal-body">

                    <div id="errorMessageUpdate" class="alert alert-danger d-none"></div>

                    <input type="hidden" name="edit_brand_id" id="edit_brand_id" >
                    <input type="hidden" name="edit_old_image" id="edit_old_image" >

                    <div class="mb-3">
                        <label for="">Name</label>
                        <div>
                            <input type="text" name="name" id="edit_name" class="form-control" />
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="">Image</label>
                        <div>
                            <input type="file" name="image" id="image" class="form-control" />
                        </div>
                        <img src="" alt="" id="edit_image" height="100" width="100" class="pt-2">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update Brand</button>
                </div>
            </form>
            </div>
        </div>
    </div>

    <?php include('../layout/foot-link.php');  ?>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.js"></script>
    <script>
        $(document).ready(function() {

            //for create brand
            $('#saveBrand').validate({
                errorClass: 'errors',
                rules: {
                    name: {
                        required: true,
                        maxlength: 255,
                    },
                    image: {
                        required: true,
                        extension: "jpg|jpeg|png",
                    },
                },
                messages: {
                    name: {
                        required: 'Please enter name.',
                        maxLength: 'Max length is 255 character.',
                    },
                    image: {
                        required: 'Image is Required.',
                        extension: "Please upload file in these format only (jpg, jpeg, png)."
                    },
                },
                highlight: function(element) {
                    $(element).parent().addClass('text-danger')
                },
                unhighlight: function(element) {
                    $(element).parent().removeClass('text-danger')
                },
                submitHandler: function(form) {
                    var formData = new FormData(form);
                    formData.append("save_brand", true);

                    $.ajax({
                        type: "POST",
                        url: "../../../controller/admin/brand/brand.php",
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
                                $('#brandAddModal').modal('hide');
                                $('#saveBrand')[0].reset();

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

            //for update brand
            $('#updateBrand').validate({
                errorClass: 'errors',
                rules: {
                    name: {
                        required: true,
                        maxlength: 255,
                    },
                    image: {
                        extension: "jpg|jpeg|png",
                    },
                },
                messages: {
                    name: {
                        required: 'Please enter name.',
                        maxLength: 'Max length is 255 character.',
                    },
                    image: {
                        required: 'Image is Required.',
                        extension: "Please upload file in these format only (jpg, jpeg, png)."
                    },
                },
                highlight: function(element) {
                    $(element).parent().addClass('text-danger')
                },
                unhighlight: function(element) {
                    $(element).parent().removeClass('text-danger')
                },
                submitHandler: function(form) {
                    var formData = new FormData(form);
                    formData.append("update_brand", true);

                    $.ajax({
                        type: "POST",
                        url: "../../../controller/admin/brand/brand.php",
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
                                $('#brandEditModal').modal('hide');
                                $('#saveBrand')[0].reset();

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
        });

        //for view detail 
        $(document).on('click','.viewBrand',function (e) {
            e.preventDefault();
            var brand_id = $(this).val();
            $.ajax({
                type: "GET",
                url: "../../../controller/admin/brand/brand.php?brand_id=" + brand_id,
                success: function(response) {
                    var res = jQuery.parseJSON(response);
                    if (res.status == 404) {
                        alert(res.message);
                    } else if (res.status == 200) {
                        $('#view_name').text(res.data.name);
                        $('#view_image').attr('src', '../../../public/admin/assets/images/brand/' + res.data.image);
                        $('#brandViewModal').modal('show');
                    }
                }
            });
        });

        //for edit detail 
        $(document).on('click', '.editBrand',function (e) {
            e.preventDefault();
            var brand_id = $(this).val();
            $.ajax({
                type: "GET",
                url: "../../../controller/admin/brand/brand.php?brand_id=" + brand_id,
                success: function(response) {
                    var res = jQuery.parseJSON(response);
                    if (res.status == 404) {
                        alert(res.message);
                    } else if (res.status == 200) {
                        $('#edit_name').val(res.data.name);
                        $('#edit_brand_id').val(res.data.id);
                        $('#edit_old_image').val(res.data.image);
                        $('#edit_image').attr('src', '../../../public/admin/assets/images/brand/' + res.data.image);
                        $('#brandEditModal').modal('show');
                    }
                }
            });
        });


        //for delete brand 
        $(document).on('click', '.deleteBrand', function (e) {
            e.preventDefault();

            if(confirm('Are you sure you want to delete this data?'))
            {
                var brand_id = $(this).val();
                $.ajax({
                    type: "POST",
                    url: "../../../controller/admin/brand/brand.php",
                    data: {
                        'delete_student': true,
                        'brand_id': brand_id
                    },
                    success: function (response) {

                        var res = jQuery.parseJSON(response);
                        if(res.status == 500) {

                            alert(res.message);
                        }else{
                            alertify.set('notifier','position', 'top-right');
                            alertify.success(res.message);

                            $('#example').load(location.href + " #example");
                        }
                    }
                });
            }
        });

        //for image preview
        function imagePreview(input) {
            $('#imagePreviewContainer').css("display", "block");
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#previewImage').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>

</html>