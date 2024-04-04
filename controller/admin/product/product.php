<?php

include_once '../../../modal/admin/product/product.php';

$obj = new Product();

if (isset($_GET['action'])) {

    $data =  $_GET['action'];

    switch($data)
    {
        case ($data == 'get_category'):
            $response = $obj->get_category();
            echo $response;
        break;

        case ($data == 'add_product'):
            $response = $obj->add_product();
            echo $response;
        break;

        case ($data == 'view_product'):
            $response = $obj->view_product();
            echo $response;
        break;

        case ($data == 'update_product'):
            $response = $obj->update_product();
            echo $response;
        break;

        case ($data == 'delete_product'):
            $response = $obj->delete_product();
            echo $response;
        break;

        case ($data == 'delete_image'):
            $response = $obj->delete_image();
            echo $response;
        break;
    }
}

?>
