<?php
    
include('../../../config/db.php');

if(isset($_POST['save_category'])){
    if (!empty($_POST['name']) && !empty($_POST['brand_id'])) {
        $name = $_POST['name'];
        $brandId = $_POST['brand_id'];

        $sql = "INSERT INTO categories (name,brand_id) VALUES ('{$name}', '{$brandId}')";
        $query = mysqli_query($connection, $sql);
        
        if($query)
        {
            $res = [
                'status' => 200,
                'message' => 'Category Created Successfully'
            ];
            echo json_encode($res);
            return;
        }
        else
        {
            $res = [
                'status' => 500,
                'message' => 'Category Not Created'
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

if(isset($_GET['category_id']))
{
   $category_id = $_GET['category_id'];

   $sql = "SELECT categories.id as category_id, categories.brand_id as brand_id,categories.name as category_name, brands.name as brand_name from categories JOIN brands ON brands.id = categories.brand_id WHERE categories.id='$category_id'";
   $query = mysqli_query($connection, $sql);

   if(mysqli_num_rows($query) == 1)
    {
        $brand = mysqli_fetch_array($query);

        $res = [
            'status' => 200,
            'message' => 'Category View Successfully',
            'data' => $brand
        ];
        echo json_encode($res);
        return;
    }
    else
    {
        $res = [
            'status' => 404,
            'message' => 'Category Not Found'
        ];
        echo json_encode($res);
        return;
    }
}

if(isset($_POST['update_category'])){
    if(!empty($_POST['name'])){
        $category_id = $_POST['edit_category_id'];
        $name = $_POST['name'];
        $brandId  = $_POST['brand_id'];

        $sql = "UPDATE categories SET name='$name', brand_id='$brandId' WHERE id='$category_id'";
        $query = mysqli_query($connection, $sql);
        
        if($query)
        {
            $res = [
                'status' => 200,
                'message' => 'Category Updated Successfully'
            ];
            echo json_encode($res);
            return;
        }
        else
        {
            $res = [
                'status' => 500,
                'message' => 'Category Not Upadated'
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

if(isset($_POST['delete_category']))
{
    $category_id =  $_POST['category_id'];
    
    $sql = "DELETE FROM categories WHERE id='$category_id'";
    $query = mysqli_query($connection, $sql);

    if($query)
    {
        $res = [
            'status' => 200,
            'message' => 'Category Deleted Successfully'
        ];
        echo json_encode($res);
        return;
    }
    else
    {
        $res = [
            'status' => 500,
            'message' => 'Category Not Deleted'
        ];
        echo json_encode($res);
        return;
    }
}

?>