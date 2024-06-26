<?php

require_once "../../../config/db.php";

class Product extends Connection
{
    public function get_category()
    {
        $brand_id =  $_POST['brand_id'];

        $sql = "SELECT id,name from categories WHERE brand_id='$brand_id'";
        $query = mysqli_query($this->connection, $sql);

        if (mysqli_num_rows($query) > 0) {
            $category = mysqli_fetch_all($query);

            $res = [
                'status' => 200,
                'message' => 'Category get Successfully',
                'data' => $category
            ];
            echo json_encode($res);
            return;
        } else {
            $res = [
                'status' => 404,
                'message' => 'Category Not Found'
            ];
            echo json_encode($res);
            return;
        }
    }

    public function add_product()
    {
        $name = $_POST['name'];
        $description = $_POST['description'];
        $brand_id = $_POST['brand_id'];
        $category_id = $_POST['category_id'];
        $price = $_POST['price'];
        $model_year = $_POST['model_year'];
        $feature = $_POST['feature'];
        $status = "active";
        $images = $_FILES['images']['name'];

        $sql = "INSERT INTO products (name,description,brand_id,category_id,price,model_year,status,feature) 
            VALUES ('{$name}', '{$description}', '{$brand_id}', '{$category_id}', '{$price}', '{$model_year}', '{$status}', '{$feature}' )";

        $query = mysqli_query($this->connection, $sql);
        $productId = mysqli_insert_id($this->connection);

        if ($images[0] !== "") {
            foreach ($images as $key => $image) {
                $imageName =  time() . '-' . $image;
                $target_dir = "/var/www/html/e_commorce/public/admin/assets/images/product/";
                $target_file = $target_dir . basename($imageName);
                $tmp = $_FILES['images']['tmp_name'][$key];
                move_uploaded_file($tmp, $target_file);

                $sql = "INSERT INTO product_images (image,product_id) 
                    VALUES ('{$imageName}', '{$productId}' )";

                $query = mysqli_query($this->connection, $sql);
            }
        }

        if ($query) {
            $res = [
                'status' => 200,
                'message' => 'Product Created Successfully'
            ];
            echo json_encode($res);
            return;
        } else {
            $res = [
                'status' => 500,
                'message' => 'Product Not Created'
            ];
            echo json_encode($res);
            return;
        }
    }

    public function view_product()
    {
        $product_id = $_GET['product_id'];

        $sql = "SELECT p.*, c.name as category_name, b.name as brand_name
                FROM products AS p 
                JOIN brands AS b ON b.id = p.brand_id 
                JOIN categories AS c ON c.id = p.category_id 
                WHERE p.id='$product_id'";

        $query = mysqli_query($this->connection, $sql);

        if ($row = mysqli_num_rows($query)) {
            $product = mysqli_fetch_assoc($query);
            $product['description'] = strip_tags($product['description']);

            $product_sql = "SELECT * FROM product_images WHERE product_id='$product_id'";
            $product_query = mysqli_query($this->connection, $product_sql);
            $images = [];
            while ($row = mysqli_fetch_assoc($product_query)) {
                $id = $row['id'];
                $image = $row['image'];
                $images[$id] = $image;
            }
            $product['images'] = $images;

            $brandId = $product['brand_id'];
            $category_sql = "SELECT * FROM categories WHERE brand_id='$brandId'";
            $category_query = mysqli_query($this->connection, $category_sql);
            $categories = [];
            while ($row = mysqli_fetch_assoc($category_query)) {
                $id = $row['id'];
                $category = $row['name'];
                $categories[$id] = $category;
            }
            $product['categories'] = $categories;

            $res = [
                'status' => 200,
                'message' => 'Product View Successfully',
                'data' => $product
            ];
            echo json_encode($res);
            return;
        } else {
            $res = [
                'status' => 404,
                'message' => 'Product Not Found'
            ];
            echo json_encode($res);
            return;
        }
    }

    public function update_product()
    {
        $product_id = $_POST['edit_product_id'];
        $name = $_POST['name'];
        $description = $_POST['description'];
        $brand_id = $_POST['brand_id'];
        $category_id = $_POST['category_id'];
        $price = $_POST['price'];
        $model_year = $_POST['model_year'];
        $feature = $_POST['feature'];
        $status = "active";

        $images = $_FILES['images']['name'];

        $sql = "UPDATE products SET name='$name', description='$description', brand_id='$brand_id', category_id='$category_id', price='$price', model_year='$model_year',
        feature='$feature' WHERE id='$product_id'";

        $query = mysqli_query($this->connection, $sql);

        if ($images[0] !== "") {
            foreach ($images as $key => $image) {
                $imageName =  time() . '-' . $image;
                $target_dir = "/var/www/html/e_commorce/public/admin/assets/images/product/";
                $target_file = $target_dir . basename($imageName);
                $tmp = $_FILES['images']['tmp_name'][$key];
                move_uploaded_file($tmp, $target_file);

                $sql = "INSERT INTO product_images (image,product_id) 
                VALUES ('{$imageName}', '{$product_id}' )";

                $query = mysqli_query($this->connection, $sql);
            }
        }

        if ($query) {
            $res = [
                'status' => 200,
                'message' => 'Product Updated Successfully'
            ];
            echo json_encode($res);
            return;
        } else {
            $res = [
                'status' => 500,
                'message' => 'Product Not Upadated'
            ];
            echo json_encode($res);
            return;
        }
    }

    public function delete_product()
    {
        $product_id = $_POST['product_id'];

        $getProductImageId = "SELECT * FROM product_images WHERE product_id='$product_id'";
        $getProductImageDeatil = mysqli_query($this->connection, $getProductImageId);

        while ($row = mysqli_fetch_assoc($getProductImageDeatil)) {
            $image = $row['image'];
            $productImageId = $row['id'];

            $image_path = "/var/www/html/e_commorce/public/admin/assets/images/product/" . $image;
            unlink($image_path);

            $sql_delete_image = "DELETE FROM product_images WHERE id='$productImageId'";
            $query_delete_image = mysqli_query($this->connection, $sql_delete_image);
            if (!$query_delete_image) {
                $res = [
                    'status' => 500,
                    'message' => 'Error deleting product image'
                ];
                echo json_encode($res);
                return;
            }
        }

        $sql_delete_product = "DELETE FROM products WHERE id='$product_id'";
        $query_delete_product = mysqli_query($this->connection, $sql_delete_product);

        if ($query_delete_product) {
            $res = [
                'status' => 200,
                'message' => 'Product Deleted Successfully'
            ];
            echo json_encode($res);
            return;
        } else {
            $res = [
                'status' => 500,
                'message' => 'Error deleting product'
            ];
            echo json_encode($res);
            return;
        }
    }

    public function delete_image()
    {
        $image_id = $_GET['image_id'];

        $getImageId = "SELECT * FROM product_images WHERE id='$image_id'";
        $getImageDeatil = mysqli_query($this->connection, $getImageId);

        if (mysqli_num_rows($getImageDeatil) > 0) {
            $row = mysqli_fetch_assoc($getImageDeatil);
            $image = $row['image'];

            $image_path = "/var/www/html/e_commorce/public/admin/assets/images/product/" . $image;
            unlink($image_path);
        }

        $sql = "DELETE FROM product_images WHERE id='$image_id'";
        $query = mysqli_query($this->connection, $sql);

        if ($query) {
            $res = [
                'status' => 200,
                'message' => 'Image Deleted Successfully'
            ];
            echo json_encode($res);
            return;
        } else {
            $res = [
                'status' => 500,
                'message' => 'Image Not Deleted'
            ];
            echo json_encode($res);
            return;
        }
    }

    public function getProductData()
    {
        $sql = "SELECT p.id, p.name as product_name, c.name as category_name, b.name as brand_name
        FROM products AS p
        JOIN brands AS b ON b.id = p.brand_id 
        JOIN categories AS c ON c.id = p.category_id";

        $query = mysqli_query($this->connection, $sql);
        return $query;
    }

    public function getLatestCar()
    {
        $sql = "SELECT p.id, p.name, p.description, pi.image FROM products AS p JOIN product_images as pi ON pi.product_id = p.id";
        $query = mysqli_query($this->connection, $sql);
        return $query;
    }
}
