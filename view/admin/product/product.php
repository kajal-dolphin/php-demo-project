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
                    <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#productAddModal">
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
                            <th>Category Name</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <!--end row-->
        </main>
        <!--end page main-->
    </div>

    <!-- Add Product Modal -->
    <div class="modal fade" id="productAddModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="saveProduct" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div id="errorMessage" class="alert alert-danger d-none"></div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="">Name</label>
                                <div>
                                    <input type="text" name="name" class="form-control" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col mb-3">
                                <label><strong>Description :</strong></label>
                                <textarea class="ckeditor form-control" name="description" height="30" width="30"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
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
                            <div class="col mb-3">
                                <label for="">Category</label>
                                <div>
                                    <select name="category_id" id="mySelect2" class="multiple-select" multiple="multiple">

                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="">Price</label>
                                <div>
                                    <input type="number" class="form-control" name="price" min="0" />
                                </div>
                            </div>
                            <div class="col mb-3">
                                <label for="">Model Year</label>
                                <div>
                                    <input type="text" class="form-control yearpicker" id="model_year" name="model_year">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for=""> Feature </label>
                                <div>
                                    <select name="feature" id="" class="form-select">
                                    <option value="default">-----select a feature----</option>
                                        <option value="automatic"> Automatic </option>
                                        <option value="electrical"> Electrical</option>
                                        <option value="petrol"> Petrol</option>
                                        <option value="diesel"> Diesel</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col mb-3">
                                <label for="">Image</label>
                                <div>
                                    <input type="file" name="images[]" class="form-control" multiple>
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

    <?php include('../layout/foot-link.php');  ?>
    <script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.js"></script>
    <script>
        $(document).ready(function() {
            // $('.ckeditor').ckeditor()
            
            //for set yearpicker
            $(".yearpicker").yearpicker({
                year: 2024,
                startYear: 2000,
                endYear: 2024,
            });

            //for show option in select2
            $('#mySelect2').select2({
                dropdownParent: $('#productAddModal')
            });

            //for get category on change of brand
            $('select[name="brand_id"]').on('change', function() {
                var brand_id = $(this).val();
                $.ajax({
                    type: "POST",
                    url: "../../../controller/admin/product/product.php",
                    data: {
                        'get_category': true,
                        'brand_id': brand_id
                    },
                    success: function(response) {
                        response = JSON.parse(response); 
                        $('select[name="category_id"]').empty();
                        $('select[name="category_id"]').append('<option value="">Select Category</option>');
                        $.each(response.data, function(key, value) {
                            $('select[name="category_id"]').append('<option value="' + value[0] + '">' + value[1] + '</option>');
                        });
                    }
                });
            });

            //for create product
            $.validator.addMethod("valueNotEquals", function(value, element, arg){
                return arg !== value;
            }, "Value must not equal arg.");

            $('#saveProduct').validate({
                errorClass: 'errors',
                rules: {
                    name: {
                        required: true,
                        maxlength: 255,
                    },
                    description: {
                        required: true,
                    },
                    brand_id : {
                        valueNotEquals: "default"
                    },
                    price : {
                        required : true,
                    }, 
                    model_year : {
                        required : true,
                    },
                    feature : {
                        valueNotEquals: "default"
                    },
                    "images[]": {
                        extension: "jpg|jpeg|png",
                    }
                },
                messages: {
                    name: {
                        required: 'Please enter name.',
                        maxLength: 'Max length is 255 character.',
                    },
                    description: {
                        required: 'Please enter name.',
                    },
                    brand_id : {
                        valueNotEquals: "Please select a brand!"
                    },
                    price : {
                        required : "Please enter price. ",
                    },
                    model_year : {
                        valueNotEquals: "Please select a model_year"
                    },
                    feature : {
                        valueNotEquals: "Please select a feature!"
                    },
                    "images[]": {
                        extension: "Please upload file in these format only (jpg, jpeg, png)."
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
                    formData.append("save_product", true);

                    var description = CKEDITOR.instances['description'].getData();
                    formData.append("description", description);

                    $.ajax({
                        type: "POST",
                        url: "../../../controller/admin/product/product.php",
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
                                $('#productAddModal').modal('hide');
                                $('#saveProduct')[0].reset();

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
        });
    </script>

</body>

</html>