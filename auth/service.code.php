<?php

/**
 * Created by PhpStorm.
 * User: chao
 * Date: 2016/4/28
 * Time: 14:04
 */
$dpath = dirname(__FILE__);
require_once($dpath.'/service.base.php');
class MyQrCode extends Base
{
    public $uuid = null;
    function __construct()
    {
        parent::__construct();
        $this->set_table('tb_code');
    }
    /*
     * 首次保存PC端uid
     */
    public function SaveUid($uid = null,$wapuid = null,$time = null) {
        $this -> DelFreeUid();
        $sql = "insert into tb_code(uid,wapuid,createtime)value('$uid','$wapuid','$time')";
        return $this -> insert_by_exec_sql($sql);
    }
    /*
     * 保存手机端uid
     */
    public function WapUid($uid = null) {
        $this -> DelFreeUid();
        $sql = "update tb_code set wapuid = '$uid' where uid = '$uid'";
        return $this -> insert_by_exec_sql($sql);
    }
    /*
     * 手机扫码登录后数据库删除保存的uid
     */
    public function DelUid($uid = null) {
        if ($uid != null) {
            $sql = "delete from tb_code where uid = '$uid'";
            return $this -> insert_by_exec_sql($sql);
        }
    }
    /*
     * 清理表存垃圾
     * 超过五分钟几就删除uid
     */
    public function DelFreeUid() {
        date_default_timezone_set('PRC');
        $time = date('Y-m-d H-i-s',strtotime("-5 minute"));

        $sql = "delete from tb_code where createtime <= '$time'";
        return $this -> insert_by_exec_sql($sql);
    }
    /*
     * 比较两端保存uid一致性
     */
    public function CompareUid() {
        if (isset($_POST['uid'])) {
            $uid = $_POST['uid'];
            $this -> uuid = $uid;
            $sql = "select wapuid from tb_code where uid = '$uid'";
            $result = $this->get_result_by_exec_sql($sql);

            if ($result[0]['wapuid'] == $uid) {
                $this -> DelUid($uid);
                return true;
            }else {
                return false;
            }
        }else {
            return false;
        }
    }
}
$code = new MyQrCode();