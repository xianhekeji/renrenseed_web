<?php

error_reporting(E_ALL ^ E_NOTICE);
header("Content-Type: text/html;charset=utf-8");
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require '../common.php';
include '../wxAction.php';
require DT_ROOT . '/Class/CompanyUserClass.php';
require DT_ROOT . '/Class/EnterpriseClass.php';
$info = new CompanyUserClass();
$eninfo = new EnterpriseClass();
$UserName = _post("userName");
$UserPass = _post("userPass");
$arr = $info->loginCompany($UserName, $UserPass);
if ($arr["result"]["UserEnterId"] > 0) {
    //已管理企业
    $eninfo->setInfo($arr["result"]["UserEnterId"]);
    $arr_en = $eninfo->getInfo();
} else {
    //未关联企业
    $arr_en = "未关联企业";
}
$array = array(
    "user" => $arr,
    "company" => $arr_en
);


echo app_wx_iconv_result('getAllProvince', true, 'success', 0, 0, 0, $array);
?>