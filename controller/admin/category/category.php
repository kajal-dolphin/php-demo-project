<?php

include_once '../../../modal/admin/category/category.php';

$obj = new Category();

if (isset($_GET['action'])) {

    $data =  $_GET['action'];

    switch($data)
    {
        case ($data == 'add_category'):
            $response = $obj->add_category();
            echo $response;
        break;

        case ($data == 'view_category'):
            $response = $obj->view_category();
            echo $response;
        break;

        case ($data == 'update_category'):
            $response = $obj->update_category();
            echo $response;
        break;

        case ($data == 'delete_category'):
            $response = $obj->delete_category();
            echo $response;
        break;
    }
}

?>