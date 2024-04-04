<?php

include_once '../../../modal/admin/brand/brand.php';

$obj = new Brand();

if (isset($_GET['action'])) {

    $data =  $_GET['action'];

    switch($data)
    {
        case ($data == 'add_brand'):
            $response = $obj->add_brand();
            echo $response;
        break;

        case ($data == 'view_brand'):
            $response = $obj->view_brand();
            echo $response;
        break;

        case ($data == 'update_brand'):
            $response = $obj->update_brand();
            echo $response;
        break;

        case ($data == 'delete_brand'):
            $response = $obj->delete_brand();
            echo $response;
        break;
    }
}

?>