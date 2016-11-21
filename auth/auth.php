<?php
/**
 * User: chao
 * Date: 2016/4/11
 * Time: 16:42
 */
header("Content-type: text/html; charset=utf-8");
date_default_timezone_set(PRC);
require_once('service.auth.php');
$auth = new AuthService();

/*
if (!isset($_POST['url']))return false;
$allow_url = array(
    '',
    ''
);//网站白名单
if (!in_array($_POST['url'],$allow_url))return false;
*/

if (!isset($_POST['token'])) {
    if (isset($_POST['app_key']) && isset($_POST['app_secret'])) {
        $appkey = htmlspecialchars($_POST['app_key']);
        $appsecret = htmlspecialchars($_POST['app_secret']);
        $data = $auth -> CheckAuth($appkey,$appsecret);
        $id = $data[0]['id'];
        if ($data[0]['id'] == false){
            return false;//未授权的站点
        }

        $ctime = $data[0]['createtime'];
        $lifetime = $data[0]['lifetime'];
        $lifecount = date('m',time() - strtotime($ctime));
        if ($lifecount <= $lifetime) {
            echo $data[0]['token'];
            exit;
        }//token生命周期判断

        $time = date('Y-m-d H-i-s',time());
        $token = md5(rand(1000,100000).$time.rand(1000,100000));
        $lifetime = '1';//可以设置存活期 设0表示永久使用 其他代表月数 默认一个月----一般每次登录都获取更新即可
        $auth -> SaveToken($id,$token,$time,$lifetime);//保存token
        echo $token;//返回给授权站点
    }
}else {
    $token = htmlspecialchars($_POST['token']);
    $data = $auth -> CheckToken($token);
    if ($data[0]['token'] != false) {
        echo $token;//授权过的站点
    }else {
        return false;//未授权的站点
    }
}