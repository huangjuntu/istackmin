<?php
/**
 * Created by PhpStorm.
 * User: chao
 * Date: 2016/4/14
 * Time: 15:38
 */
session_start();

require_once('service.base.php');
$user_auth = new Base();
$user_auth -> set_table('tb_user');

if(isset($_POST['name'])){
    $login_name = $_POST['name'];
}else{
    $login_name = '';
}

if(isset($_POST['password'])){
    $password = $_POST['password'];
}else{
    $password = '';
}
if($login_name!='') {
    $user = $user_auth->get_item_by_condition(array("login_name" => $login_name));
    if ($user) {
        if ($user['password'] == $password) {
            $license_flag = true;
            $license = $user['license'];
            if ($license != 'indefinite') {
                if (strpos($license, '@')) {
                    date_default_timezone_set('PRC');
                    $currentDate = strtotime(date("Y-m-d H:i:s"));
                    $license = explode('@', $license);
                    $licenseDate = strtotime($license[1]);
                    if ($currentDate > $licenseDate) {
                        // license time out
                        $license_flag = false;
                    }
                }
                if ($license_flag) {
                    $_SESSION['user_name'] = $login_name;
                    $_SESSION['authenticated'] = true;
                }
            }else {
                $_SESSION['user_name'] = $login_name;
                $_SESSION['authenticated'] = true;
            }
        }
    }
}
$url = 'http://10.200.46.37/smartparkOS/index.php';
header("location:$url");
//echo $_SESSION['user_name'];
