<?php
/**
 * Created by PhpStorm.
 * User: chao
 * Date: 2016/4/14
 * Time: 10:41
 */
header("Content-type: text/html; charset=utf-8");
session_start();
require_once('service.auth.php');
$auth = new AuthService();

/*
if (!isset($_GET['url']))return false;
$allow_url = array(
    '',
    ''
);//网站白名单
if (!in_array($_GET['url'],$allow_url))return false;
*/

$token = htmlspecialchars($_GET['token']);
$backurl = htmlspecialchars($_GET['backurl']);
$user = '';
$is_token = $auth -> CheckToken($token);//检测token是否正确 不一致返回false
if ($is_token[0]['token'] == false)return false;

if (isset($_SESSION['user_name'])) {
    $user = $_SESSION['user_name'];
}else $user = '';
$url = $backurl.'?token='.$token.'&user='.$user;
header("location:$url");