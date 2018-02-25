<?php

require '../../../common.php';
include DT_ROOT . '/wxAction.php';
require DT_ROOT . '/Class/AuthorizeClass.php';
$info = new AuthorizeClass();
if (isset($_POST ["flag_tuichu"])) {
    if (empty($_POST ['au_number'])) { // 点击提交按钮后才执行
        echo "<script>alert('编码不能为空')</script>";
        return;
    }
    $arr_number = explode(';', $_POST ['au_number']);
    $number_id = $arr_number [0];
    $au_tuichu = $_POST ['au_tuichu'];
    $info->setInfo($number_id);
    $result = $info->setTuichu(2, $au_tuichu);
    echo returnResult($result, 0);
    exit();
}
if (isset($_POST ["flag_zuofei"])) {
    if (empty($_POST ['au_number'])) { // 点击提交按钮后才执行
        echo "<script>alert('编码不能为空')</script>";
        return;
    }
    $arr_number = explode(';', $_POST ['au_number']);
    $number_id = $arr_number [0];
    $info->setInfo($number_id);
    $result = $info->setThisFlag(1);
    echo returnResult($result, 0);
    exit();
}
if (isset($_POST ["flag_qiyong"])) {
    if (empty($_POST ['au_number'])) { // 点击提交按钮后才执行
        echo "<script>alert('编码不能为空')</script>";
        return;
    }
    $arr_number = explode(';', $_POST ['au_number']);
    $number_id = $arr_number [0];
    $info->setInfo($number_id);
    $result = $info->setThisFlag(0);
    echo returnResult($result, 0);
    exit();
}
if (isset($_POST ["add"]) || isset($_POST ["modify"])) {
    if (empty($_POST ['cropname'])) { // 点击提交按钮后才执行
        echo "<script>alert('品种不能为空');history.back();</script>";
        return;
    }
    $arr_crop = explode(';', $_POST ['cropname']);
    $select_status = $_POST["select_status"];
    $crop_id = $arr_crop [0];
    $crop_name = $arr_crop [1];
    $au_source = htmlspecialchars($_POST ['au_source']);
    $au_number = $_POST ['au_number'];

    $au_year = $_POST ['au_year'];
    $au_org = $_POST ['au_org'];
    $au_unit = $_POST ['au_unit'];
    $au_tuichu = $_POST ['au_tuichu'];
    $au_featrue = htmlspecialchars($_POST ['au_featrue']);
    $au_pro = htmlspecialchars($_POST ['au_pro']);
    $au_region = htmlspecialchars($_POST ['au_region']);
    $au_kangxing = htmlspecialchars($_POST ['au_kangxing']);
    $au_pinzhi = htmlspecialchars($_POST ['au_pinzhi']);
    $au_skill = htmlspecialchars($_POST ['au_skill']);
    $arr_province = explode(';', rtrim($_POST ['t_province'], ';'));
    $au_province_id = "";
    for ($i = 0; $i < count($arr_province); $i ++) {

        $arr_province_id = explode(',', $arr_province [$i]);
        if ($i == 0) {
            $au_province_id = $arr_province_id [0];
        } else {
            $au_province_id = $au_province_id . "," . $arr_province_id [0];
        }
    }
    $arr_province_name = explode(';', $_POST ['au_province_name']);
    $au_province_name = $arr_province_name [0];
    if (isset($_POST ["add"])) {
        $param = array();
        $param['AuthorizeNumber'] = $au_number;
        $param['AuthorizeYear'] = $au_year;
        $param['BreedOrganization'] = $au_org;
        $param['VarietySource'] = $au_source;
        $param['Features'] = $au_featrue;
        $param['Production'] = $au_pro;
        $param['BreedRegion'] = $au_region;
        $param['BreedSkill'] = $au_skill;
        $param['BreedRegionProvince'] = $au_province_id;
        $param['AuthorizeUnit'] = $au_unit;
        $param['AuCropId'] = $crop_id;
        $param['AuCropName'] = $crop_name;
        $param['AuthorizeProvince'] = $au_province_name;
        $param['AuKangxing'] = $au_kangxing;
        $param['AuPinzhi'] = $au_pinzhi;
        $param['FlagReason'] = $au_tuichu;
        $param['AuthorizeStatus'] = $select_status;
        $update = $info->insertInfo($param);
        $info->updateCropStatus($crop_id);
        echo returnResult($update, 0);
        exit();
    } else if (isset($_POST ["modify"])) {
        $arr_number = explode(';', $_POST ['au_number']);
        $number_id = $arr_number [0];
        $info->setInfo($number_id);
        $param = array();
        $param['AuthorizeYear'] = $au_year;
        $param['BreedOrganization'] = $au_org;
        $param['VarietySource'] = $au_source;
        $param['Features'] = $au_featrue;
        $param['Production'] = $au_pro;
        $param['BreedRegion'] = $au_region;
        $param['BreedSkill'] = $au_skill;
        $param['BreedRegionProvince'] = $au_province_id;
        $param['AuthorizeUnit'] = $au_unit;
        $param['AuCropId'] = $crop_id;
        $param['AuCropName'] = $crop_name;
        $param['AuthorizeProvince'] = $au_province_name;
        $param['AuKangxing'] = $au_kangxing;
        $param['AuPinzhi'] = $au_pinzhi;
        $param['FlagReason'] = $au_tuichu;
        $param['AuthorizeStatus'] = $select_status;
        $update = $info->updateInfo($param);
        $info->updateCropStatus($crop_id);
        echo returnResult($update, 0);
        exit();
    }
}
?>