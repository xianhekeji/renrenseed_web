<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require '../../common.php';
include '../../wxAction.php';
require DT_ROOT . '/Class/DisableUserClass.php';
$info = new DisableUserClass();
$userid = _post("userid");
$type = _post("type");
$sql = "select * from WXUser where UserId=$userid";
$result = $db->row($sql);
if ($type == 0) {
    if ($info->checkInfo($userid)) {
        $info->setInfo($userid);
        $getinfo = $info->getUserInfo();
        if ($getinfo["Status"] == 1) {
            echo "禁用成功3！";
        } else {
            $arr = array();
            $arr["Userid"] = $userid;
            $arr["Status"] = "1";
            $re = $info->updateInfo($arr);
            echo $re > 0 ? "禁用成功2" : "禁用失败2";
        }
    } else {
        $arr = array();
        $arr["Userid"] = $userid;
        $arr["Status"] = "1";
        $re = $info->insertInfo($arr);
        echo $re > 0 ? "禁用成功1" : "禁用失败1";
    }
}
if ($type == 1) {
    if (!$info->checkInfo($userid)) {
        echo "无需恢复";
    } else {
        $info->setInfo($userid);
        $getinfo = $info->getUserInfo();
        if ($getinfo["Status"] == 0) {
            echo "恢复成功1！";
        } else {
            $arr = array();
            $arr["Userid"] = $userid;
            $arr['Status'] = "0";
            $re = $info->updateInfo($arr);
            echo $re > 0 ? "禁用成功2" : "禁用失败2";
        }
    }

    //echo $re > 0 ? "禁用成功" : "禁用失败";
}
?>