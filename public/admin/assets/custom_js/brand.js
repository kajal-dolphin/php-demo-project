$(document).ready(function() {
    //modal close also error is not display
    $('#brandAddModal').on('hidden.bs.modal', function() {
        $('.errors').empty();
        $('#saveBrand')[0].reset();
    });

    $('#brandEditModal').on('hidden.bs.modal', function() {
        $('.errors').empty();
        $('#updateBrand')[0].reset();
    });

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
            // formData.append("save_brand", true);
            console.log(formData);
            $.ajax({
                type: "POST",
                url: "../../../controller/admin/brand/brand.php?action=add_brand",
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
            // formData.append("update_brand", true);

            $.ajax({
                type: "POST",
                url: "../../../controller/admin/brand/brand.php?action=update_brand",
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
$(document).on('click', '.viewBrand', function(e) {
    e.preventDefault();
    var brand_id = $(this).val();
    $.ajax({
        type: "GET",
        url: "../../../controller/admin/brand/brand.php?brand_id=" + brand_id + "&action=view_brand",
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
$(document).on('click', '.editBrand', function(e) {
    e.preventDefault();
    var brand_id = $(this).val();
    $.ajax({
        type: "GET",
        url: "../../../controller/admin/brand/brand.php?brand_id=" + brand_id + "&action=view_brand",
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
$(document).on('click', '.deleteBrand', function(e) {
    e.preventDefault();

    if (confirm('Are you sure you want to delete this data?')) {
        var brand_id = $(this).val();
        $.ajax({
            type: "POST",
            url: "../../../controller/admin/brand/brand.php?action=delete_brand",
            data: {
                'delete_brand': true,
                'brand_id': brand_id
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

//for image preview
function imagePreview(input) {
    $('#imagePreviewContainer').css("display", "block");
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
            $('#previewImage').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}