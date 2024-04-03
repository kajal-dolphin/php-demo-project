$(document).ready(function() {
    // $('.ckeditor').ckeditor()

    //modal close also error is not display
    $('#productAddModal').on('hidden.bs.modal', function() {
        $('.errors').empty();
        $('#saveProduct')[0].reset();
    });

    $('#productEditModal').on('hidden.bs.modal', function() {
        $('.errors').empty();
        $('#updateProduct')[0].reset();
    });

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

//for view detail 
$(document).on('click', '.viewProduct', function(e) {
    $('#productViewModal').on('hidden.bs.modal', function() {
        $('.imageContainer').empty();
    });
    e.preventDefault();
    var product_id = $(this).val();
    $.ajax({
        type: "GET",
        url: "../../../controller/admin/product/product.php?product_id=" + product_id,
        success: function(response) {
            var res = jQuery.parseJSON(response);
            if (res.status == 404) {
                alert(res.message);
            } else if (res.status == 200) {
                $('#view_name').text(res.data.name);
                $('#view_description').text(res.data.description);
                $('#view_brand_name').text(res.data.brand_name);
                $('#view_category_name').text(res.data.category_name);
                $('#view_price').text(res.data.price);
                $('#view_feature').text(res.data.feature);
                $('#view_model_year').text(res.data.model_year);
                $.each(res.data.images, function(key, value) {
                    $('.imageContainer').append("<img id='' src='../../../public/admin/assets/images/product/" + value + "' height='90' width='90' class='me-2' value=" + key + ">");
                });

                $('#productViewModal').modal('show');
            }
        }
    });
});

//for edit detail 
$(document).on('click', '.editProduct', function(e) {
    $('#productEditModal').on('hidden.bs.modal', function() {
        $('.editImageContainer').empty();
    });
    e.preventDefault();
    var product_id = $(this).val();
    $.ajax({
        type: "GET",
        url: "../../../controller/admin/product/product.php?product_id=" + product_id,
        success: function(response) {
            var res = jQuery.parseJSON(response);
            if (res.status == 404) {
                alert(res.message);
            } else if (res.status == 200) {
                $('#edit_product_id').val(res.data.id);
                $('#edit_name').val(res.data.category_name);
                CKEDITOR.instances['edit_description'].setData(res.data.description);
                $('#edit_price').val(res.data.price);
                $('#edit_model_year').val(res.data.model_year);
               
                $.each($('.editSelectedFeature option'),function(a,b){
                    if($(this).val() == res.data.feature){
                        $(this).attr('selected',true)
                    }
                });

                $.each($('.selectedBrandOption option'),function(a,b){
                    if($(this).val() == res.data.brand_id){
                        $(this).attr('selected',true)
                    }
                });

                $.each(res.data.images, function(key, value) {
                    $('.editImageContainer').append(`
                        <div style="position:relative;" id="removeImage_${key}">
                            <button type="submit" class="close AClass deleteImage" value="${key}">
                                <span>&times;</span>
                            </button>
                            <img id="" src="../../../public/admin/assets/images/product/${value}" height="90" width="90" class="me-2 mt-2" value="${key}">
                        </div>
                    `);
                });

                $('select[name="category_id"]').empty();
                $('select[name="category_id"]').append('<option value="">Select Category</option>');
                $.each(res.data.categories, function(key, value) {
                    $('select[name="category_id"]').append('<option value="' + key + '">' + value + '</option>');
                });

                $.each($('.editSelectedCategory option'),function(a,b){
                    if($(this).val() == res.data.category_id){
                        $(this).attr('selected',true)
                    }
                });

                $('#productEditModal').modal('show');
            }
        }
    });
});

//delete Image
$(document).on('click','.deleteImage', function(e){
    e.preventDefault();
    var image_id = $(this).val();
    $.ajax({
        type : "GET",
        url: "../../../controller/admin/product/product.php",
        data : {
            image_id : image_id,
            delete_image : true,
        },
        success: function(response) {
            var res = jQuery.parseJSON(response);
            if (res.status == 500) {
                $('#errorMessageUpdate').removeClass('d-none');
                $('#errorMessageUpdate').text(res.message);
            } else {
                $('#removeImage_' + image_id).remove();
                $('#errorMessageUpdate').removeClass('d-none');
                $('#errorMessageUpdate').text(res.message);
            }
        },
        error: function(xhr, status, error) {
            console.log("in error");
        }

    });
});

//for update product
$.validator.addMethod("valueNotEquals", function(value, element, arg){
    return arg !== value;
}, "Value must not equal arg.");

$('#updateProduct').validate({
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
        formData.append("update_product", true);

        var description = CKEDITOR.instances['editDescription'].getData();
        console.log(description);
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
                    $('#errorMessageUpdate').removeClass('d-none');
                    $('#errorMessageUpdate').text(res.message);

                } else if (res.status == 200) {

                    $('#errorMessageUpdate').addClass('d-none');
                    $('#productEditModal').modal('hide');
                    $('#updateProduct')[0].reset();

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