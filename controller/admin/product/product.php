<?php

include('../../../config/db.php');

if(isset($_POST['get_category']))
{
    $brand_id =  $_POST['brand_id'];
    
    $sql = "SELECT id,name from categories WHERE brand_id='$brand_id'";
    $query = mysqli_query($connection, $sql);

    if(mysqli_num_rows($query) > 0)
    {
        $category = mysqli_fetch_all($query);

        $res = [
            'status' => 200,
            'message' => 'Category get Successfully',
            'data' => $category
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

if(isset($_POST['save_product'])){
    $name = $_POST['name'];
    $description = $_POST['description'];
    $brand_id = $_POST['brand_id'];
    $category_id = $_POST['category_id'];
    $price = $_POST['price'];
    $model_year = $_POST['model_year'];
    $feature = $_POST['feature'];
    $status = "active";

    $sql = "INSERT INTO products (name,description,brand_id,category_id,price,model_year,status,feature) 
        VALUES ('{$name}', '{$description}', '{$brand_id}', '{$category_id}', '{$price}', '{$model_year}', '{$status}', '{$feature}' )";
        
    $query = mysqli_query($connection, $sql);
    
    if($query)
    {
        $res = [
            'status' => 200,
            'message' => 'Product Created Successfully'
        ];
        echo json_encode($res);
        return;
    }
    else
    {
        $res = [
            'status' => 500,
            'message' => 'Product Not Created'
        ];
        echo json_encode($res);
        return;
    }
}

?>