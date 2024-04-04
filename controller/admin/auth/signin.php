<?php

include_once '../../../modal/auth/signin.php';

$obj = new Login();

if (isset($_GET['action'])) {

    $data =  $_GET['action'];

    switch($data)
    {
        case ($data == 'login'):
            $response = $obj->login();
            echo $response;
        break;
    }
}