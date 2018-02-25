<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require '../../common.php';
include '../../wxAction.php';
$openid = _post("id");
//$openid='ooJN40gqIWkHdMwgc7YMKmajZZkI';
require_once '../../wxPub/Common_util_pub.php';
$arr['openid'] = $openid;
$arr['hbname'] = "人人种品种大全";
$arr['body'] = "祝贺您获得人人种品种大全赠送的红包";
$arr['fee'] = rand(100, 120);
$comm = new Common_util_pub();
$re = $comm->sendhongbaoto($arr);
echo $re["return_msg"];
//if ($re["result_code"] == "SUCCESS") {
//    
//    $this->_msgKefu($to, "text", null, $msg::$SEARCH_HB_YDP, null);
//} else {
//    // $this->_msgKefu($to, "text", null,$re["return_msg"], null);
//    $this->_msgKefu($to, "text", null, $msg::$SEARCH_HB_YFW, null);
//}
?>