<?php

include('../../../config/db.php');

if(isset($_POST['save_brand'])){
    if (!empty($_POST['name']) && !empty($_FILES['image']['name'])) {
        $name = $_POST['name'];
        $image = $_FILES['image']['name'];

        $target_dir = "/var/www/html/e_commorce/public/admin/assets/images/brand/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $sql = "INSERT INTO brands (name,image) VALUES ('{$name}', '{$image}')";
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
                    'message' => 'Student Not Created'
                ];
                echo json_encode($res);
                return;
            }
        } else {
            $res = [
                'status' => 400,
                'message' => 'Error while uploading file'
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

?>