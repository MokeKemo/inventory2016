<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Boris
 * Date: 29.09.2015.
 * Time: 8:42 AM
 */

include '../includes/config.php';
include CLASS_PATH.'classSettings.php';

$_settings = new Settings($db);

if (isset($_POST['action'])) {

    switch($_POST['action']){
        case "addUser":
            $state = $_POST['country'];
            $name = $_POST['name'];
            $surname = $_POST['surname'];
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $role = $_POST['role'];
            $status = $_POST['active'];

            $writeUser = $_settings->writeUser($state,$name,$surname,$email,$username,$password,$role,$status);

            return $writeUser;

        break;

    exit;
    }

}
?>