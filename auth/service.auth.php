<?php

/**
 * User: chao
 * Date: 2016/4/12
 * Time: 13:47
 */
require_once('service.base.php');
class AuthService extends Base
{
    function __construct() {
        parent::__construct();
        $this -> set_table('tb_auth');
    }

    function CheckAuth($app_key,$app_secret) {
        $query_sql = "select id,token,lifetime,createtime from tb_auth where app_key = '$app_key' and app_secret = '$app_secret'";
        $result = $this->get_result_by_exec_sql($query_sql);
        return $result;
    }

    function SaveToken($id,$token,$createtime = '2016-04-15 12:12:12',$lifetime = '1') {
        $query_sql = "update tb_auth set token = '$token',lifetime = '$lifetime',createtime = '$createtime' where id = $id";
        $result = $this -> dao -> query($query_sql);
        return $result? true: false;
    }

    function CheckToken($token) {
        $query_sql = "select token from tb_auth where token = '$token'";
        $result = $this->get_result_by_exec_sql($query_sql);
        return $result;
    }
}