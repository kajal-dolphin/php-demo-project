$(document).ready(function() {

    //modal close also error is not display
    $('#categoryAddModal').on('hidden.bs.modal', function() {
        $('.errors').empty();
        $('#saveCategory')[0].reset();
    });

    $('#categoryEditModal').on('hidden.bs.modal', function() {
        $('.errors').empty();
        $('#updateCategory')[0].reset();
    });

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