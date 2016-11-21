<?php
/**
 * User: chao
 * Date: 2016/4/28
 * Time: 17:17
 */
session_start();
$dpath = dirname(__FILE__);
$imgpath = realpath('../temp');

require_once($dpath.'/service.code.php');
if ($code -> CompareUid()) {
    $uid = $code -> uuid;
    $_SESSION['authenticated'] = true;//确认用户登录
    $_SESSION['user_name'] = 'root';
    $pth = $imgpath.'/'.$uid.'.png';
    unlink($pth);//删除二维码图片
    echo json_encode(array("msg" => "right"));
}else {
    echo json_encode(array("msg" => "error"));
}//查看是否手机扫描登录