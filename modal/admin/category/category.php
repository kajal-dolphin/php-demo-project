<?php

require_once "../../../config/db.php";

class Category extends Connection
{
    public function add_category()
    {
        if (!empty($_POST['name']) && !empty($_POST['brand_id'])) {
            $name = $_POST['name'];
            $brandId = $_POST['brand_id'];

            $existingCategory = "SELECT * FROM categories WHERE brand_id='$brandId' AND name='$name'";
            $category = mysqli_query($this->connection, $existingCategory);

            if (mysqli_num_rows($category) > 0) {
                $res = [
                    'status' => 400,
                    'message' => 'Category with same brand already exists!!'
                ];
                echo json_encode($res);
                return;
            } else {
                $sql = "INSERT INTO categories (name,brand_id) VALUES ('{$name}', '{$brandId}')";
                $query = mysqli_query($this->connection, $sql);

                if ($query) {
                    $res = [
                        'status' => 200,
                        'message' => 'Category Created Successfully'
                    ];
                    echo json_encode($res);
                    return;
                } else {
                    $res = [
                        'status' => 500,
                        'message' => 'Category Not Created'
                    ];
                    echo json_encode($res);
                    return;
                }
            }
        } else {
            $res = [
                'status' => 422,
                'message' => 'All fields are mandatory'
            ];
            echo json_encode($res);
            return;
        }
    }

    public function getCategoryData()
    {
        $sql = "SELECT c.id,c.name as category_name, b.name as brand_name from categories AS c JOIN brands AS b ON b.id = c.brand_id ";
        $query = mysqli_query($this->connection, $sql);
        return $query;
    }

    public function view_category()
    {
        if (isset($_GET['category_id'])) {
            $category_id = $_GET['category_id'];

            $sql = "SELECT c.id as category_id, c.brand_id as brand_id,c.name as category_name, b.name as brand_name from categories AS c JOIN brands AS b ON b.id = c.brand_id WHERE c.id='$category_id'";
            $query = mysqli_query($this->connection, $sql);

            if (mysqli_num_rows($query) == 1) {
                $brand = mysqli_fetch_array($query);

                $res = [
                    'status' => 200,
                    'message' => 'Category View Successfully',
                    'data' => $brand
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
    }

    public function update_category()
    {
        if (isset($_POST['update_category'])) {
            if (!empty($_POST['name'])) {
                $category_id = $_POST['edit_category_id'];
                $name = $_POST['name'];
                $brandId  = $_POST['brand_id'];

                $sql = "UPDATE categories SET name='$name', brand_id='$brandId' WHERE id='$category_id'";
                $query = mysqli_query($this->connection, $sql);

                if ($query) {
                    $res = [
                        'status' => 200,
                        'message' => 'Category Updated Successfully'
                    ];
                    echo json_encode($res);
                    return;
                } else {
                    $res = [
                        'status' => 500,
                        'message' => 'Category Not Upadated'
                    ];
                    echo json_encode($res);
                    return;
                }
            } else {
                $res = [
                    'status' => 422,
                    'message' => 'All fields are mandatory'
                ];
                echo json_encode($res);
                return;
            }
        }
    }

    public function delete_category()
    {
        if (isset($_POST['delete_category'])) {
            $category_id =  $_POST['category_id'];

            $sql = "DELETE FROM categories WHERE id='$category_id'";
            $query = mysqli_query($this->connection, $sql);

            if ($query) {
                $res = [
                    'status' => 200,
                    'message' => 'Category Deleted Successfully'
                ];
                echo json_encode($res);
                return;
            } else {
                $res = [
                    'status' => 500,
                    'message' => 'Category Not Deleted'
                ];
                echo json_encode($res);
                return;
            }
        }
    }
}
