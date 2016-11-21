<?php
/**
 * User: chao
 * Date: 2016/4/28
 * Time: 13:58
 */
session_start();
require "auth/service.code.php";
if (isset($_GET['uid'])) {
    $uid = $_GET['uid'];
    if ($code -> WapUid($uid)){
        var_dump(phone());
        //成功
        echo '登录成功';
    }else {
        echo '登录失败!请刷新页面重试';
    }
}else {
    echo '登录失败';
}
/*
 * 获取手机信息
 */
function phone() {
    if (isset($_SERVER[ 'HTTP_X_NETWORK_INFO '])){
        $str1 = $_SERVER[ 'HTTP_X_NETWORK_INFO '];
        $getstr1 = preg_replace( '/(.*,)(11[d])(,.*)/i ', '\2 ',$str1);
        return $getstr1;
    }elseif (isset($_SERVER[ 'HTTP_X_UP_CALLING_LINE_ID '])){
        $getstr2 = $_SERVER[ 'HTTP_X_UP_CALLING_LINE_ID '];
        return $getstr2;
    }elseif (isset($_SERVER[ 'HTTP_X_UP_SUBNO '])){
        $str3 = $_SERVER[ 'HTTP_X_UP_SUBNO '];
        $getstr3 = preg_replace( '/(.*)(11[d])(.*)/i ', '\2 ',$str3);
        return $getstr3;
    }elseif (isset($_SERVER[ 'DEVICEID '])){
        return $_SERVER[ 'DEVICEID '];
    }else{
        return $_SERVER['HTTP_USER_AGENT'];
    }
}