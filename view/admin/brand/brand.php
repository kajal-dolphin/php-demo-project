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
                            <th>Name</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Paul Byrd</td>
                            <td>Chief Financial Officer (CFO)</td>
                            <td>
                                <div class="d-flex align-items-center gap-3 fs-6">
                                    <a href="" class="text-primary"><i class="bi bi-eye-fill"></i></a>
                                    <a href="" class="text-warning"><i class="bi bi-pencil-fill"></i></a>
                                    <a href="" class="text-danger"><i class="bi bi-trash-fill"></i></a>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!--end row-->
        </main>
        <!--end page main-->


        <!-- Add Brand -->
        <div class="modal fade" id="brandAddModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Brand</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="saveBrand">
                        <div class="modal-body">

                            <div id="errorMessage" class="alert alert-warning d-none"></div>

                            <div class="mb-3">
                                <label for="">Name</label>
                                <div>
                                    <input type="text" name="name" class="form-control" />
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="">Image</label>
                                <div>
                                    <input type="file" name="image" class="form-control" />
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

    <?php include('../layout/foot-link.php');  ?>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.js"></script>
    <script>
        $(document).ready(function() {
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

                                // $('#myTable').load(location.href + " #myTable");

                            } else if (res.status == 500) {
                                alert(res.message);
                            } else if (res.status == 400) {
                                $('#errorMessage').removeClass('d-none');
                                $('#errorMessage').text(res.message);

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