<?php

include('../../../config/db.php');

if(isset($_POST['save_brand'])){
    if (!empty($_POST['name']) && !empty($_FILES['image']['name'])) {
        $name = $_POST['name'];
        $image = $_FILES['image']['name'];

        $imageName =  time() . '-' . $image;

        $target_dir = "/var/www/html/e_commorce/public/admin/assets/images/brand/";
        $target_file = $target_dir . basename($imageName);
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

        $sql = "INSERT INTO brands (name,image) VALUES ('{$name}', '{$imageName}')";
        $query = mysqli_query($connection, $sql);
        
        if($query)
        {
            $res = [
                'status' => 200,
                'message' => 'Brand Created Successfully'
            ];
            echo json_encode($res);
            return;
        }
        else
        {
            $res = [
                'status' => 500,
                'message' => 'Brand Not Created'
            ];
            echo json_encode($res);
            return;
        }
    }
    else{
        $res = [
            'status' => 422,
            'message' => 'All fields are mandatory'
        ];
        echo json_encode($res);
        return;
    }
}


if(isset($_GET['brand_id']))
{
   $brand_id = $_GET['brand_id'];

   $sql = "SELECT * FROM brands WHERE id='$brand_id'";
   $query = mysqli_query($connection, $sql);

   if(mysqli_num_rows($query) == 1)
    {
        $brand = mysqli_fetch_array($query);

        $res = [
            'status' => 200,
            'message' => 'Brand View Successfully',
            'data' => $brand
        ];
        echo json_encode($res);
        return;
    }
    else
    {
        $res = [
            'status' => 404,
            'message' => 'Brand Not Found'
        ];
        echo json_encode($res);
        return;
    }
}

if(isset($_POST['update_brand'])){
   if(!empty($_POST['name'])){
        $brand_id = $_POST['edit_brand_id'];
        $name = $_POST['name'];
        $image = $_FILES['image']['name'];
        $imageName = $_POST['edit_old_image'];

        if(!empty($_FILES['image']['name'])){
            $image_path = "/var/www/html/e_commorce/public/admin/assets/images/brand/" . $_POST['edit_old_image'];
            unlink($image_path);

            $imageName =  time() . '-' . $image;
            $target_dir = "/var/www/html/e_commorce/public/admin/assets/images/brand/";
            $target_file = $target_dir . basename($imageName);
            move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
        }

        $sql = "UPDATE brands SET name='$name', image='$imageName' WHERE id='$brand_id'";
        $query = mysqli_query($connection, $sql);
        
        if($query)
        {
            $res = [
                'status' => 200,
                'message' => 'Brand Updated Successfully'
            ];
            echo json_encode($res);
            return;
        }
        else
        {
            $res = [
                'status' => 500,
                'message' => 'Brand Not Upadated'
            ];
            echo json_encode($res);
            return;
        }
   }
   else{
        $res = [
            'status' => 422,
            'message' => 'All fields are mandatory'
        ];
        echo json_encode($res);
        return;
    }
}

if(isset($_POST['delete_brand']))
{
    $brand_id =  $_POST['brand_id'];

    $getBrandId = "SELECT * FROM brands WHERE id='$brand_id'";
    $getBrandDeatil = mysqli_query($connection, $getBrandId);

    if (mysqli_num_rows($getBrandDeatil) > 0) {
        $row = mysqli_fetch_assoc($getBrandDeatil);
        $image = $row['image'];

        $image_path = "/var/www/html/e_commorce/public/admin/assets/images/brand/" . $image;
        unlink($image_path);
    }
    
    $sql = "DELETE FROM brands WHERE id='$brand_id'";
    $query = mysqli_query($connection, $sql);

    if($query)
    {
        $res = [
            'status' => 200,
            'message' => 'Brand Deleted Successfully'
        ];
        echo json_encode($res);
        return;
    }
    else
    {
        $res = [
            'status' => 500,
            'message' => 'Brand Not Deleted'
        ];
        echo json_encode($res);
        return;
    }
}

?>