<?php

require '../../../common.php';
include DT_ROOT . '/comm/imgageUnit.php';
include DT_ROOT . '/wxAction.php';
$path = DT_ROOT . '/files/cropImgs/';
require DT_ROOT . '/Class/CropClass.php';
$info = new CropClass();
if (isset($_POST ["flag_qiyong"])) {
    if (empty($_POST ['cropname'])) { // 点击提交按钮后才执行
        echo "<script>alert('品种名称不能为空')</script>";
        return;
    }
    $arr_cropid = explode(';', $_POST ['cropname']);
    $crop_id = $arr_cropid [0];
    $info->setInfo($crop_id);
    $result = $info->setThisFlag(0);
    echo returnResult($result, 0);
    exit();
}
if (isset($_POST ["flag_zuofei"])) {
    if (empty($_POST ['cropname'])) { // 点击提交按钮后才执行
        echo "<script>alert('品种名称不能为空')</script>";
        return;
    }
    $arr_cropid = explode(';', $_POST ['cropname']);
    $crop_id = $arr_cropid [0];
    $info->setInfo($crop_id);
    $result = $info->setThisFlag(1);
    echo returnResult($result, 0);
    exit();
}
if (isset($_POST ["add"]) || isset($_POST ["modify"])) {

    if (empty($_POST ['select_2'])) { // 点击提交按钮后才执行
        echo "<script>alert('品种分类为必选')</script>";
        return;
    }
    if (empty($_POST ['cropname'])) { // 点击提交按钮后才执行
        echo "<script>alert('品种名称不能为空')</script>";
        return;
    }
    // if (empty ( $_POST ['au_region'] )) { // 点击提交按钮后才执行
    // echo "<script>alert('适宜地区不能为空')</script>";
    // return;
    // }
    $au_max = $_POST ['au_max'];
    $au_min = $_POST ['au_min'];
    $au_memo = $_POST ['t_memo'];
    ;
    $au_organization = $_POST ['au_organization'];
    $app_Variety_1 = $_POST ['select_1'];
    $app_Variety_2 = $_POST ['select_2'];
    $cropName = trim($_POST ['cropname']);
    $IsGen = $_POST ['class'];
    $images = isset($_FILES ["myfile"]) ? $_FILES ["myfile"] : '';
    $site = isset($_REQUEST ['site']) ? $_REQUEST ['site'] : '';
    $au_region = $_POST ['au_region'];
    $au_level = $_POST ['au_level'];
    $name = array();
    $save = array();
    if (!empty($images) && is_array($images ['name'])) {
        foreach ($images ['name'] as $k => $image) {
            if (empty($image))
                continue;
            $name [] = $images ['name'] [$k];
            $save [] = $images ['tmp_name'] [$k];
        }
    } elseif (!empty($images) && !empty($images ['name']) && !empty($images ['tmp_name'])) {
        $name [] = $images ['name'];
        $save [] = $images ['tmp_name'];
    }

    if (!empty($name) && !empty($save)) {
        $insert_name = array();
        $insert_name_min = array();
        $i = 0;
        foreach ($name as $k => $n) {
            if (!is_file($save [$k]))
                continue;
            $rename = 'crop_' . time() . '_' . $i;
            $ext = pathinfo($n, PATHINFO_EXTENSION);
            setShuiyin($save [$k], $path, $rename . '_min' . '.' . $ext, 500, 500);
            if (copy($save [$k], $path . $rename . '.' . $ext)) {
                $insert_name [] = $rename . '.' . $ext;
                $insert_name_min [] = $rename . '_min' . '.' . $ext;
                @unlink($save [$k]);
            }
            $i++;
        }

        $insert = implode(";", $insert_name);
        $insert_min = implode(";", $insert_name_min);
    }
    if (isset($_POST ["modify"])) {

        $arr_cropid = explode(';', $_POST ['cropname']);
        $crop_id = $arr_cropid [0];
        $crop_name_new = $arr_cropid [1];
        $info->setInfo($crop_id);
        $param = array();
        $param['CropCategory1'] = $app_Variety_1;
        $param['CropCategory2'] = $app_Variety_2;
        $param['VarietyName'] = $crop_name_new;
        $param['CropImgsMin'] = $insert_min ?? '';
        $param['CropImgs'] = $insert ?? '';
        $param['IsGen'] = $IsGen;
        $param['MinGuidePrice'] = $au_min;
        $param['MaxGuidePrice'] = $au_max;
        $param['BreedRegion'] = $au_region;
        $param['Memo'] = $au_memo;
        $param['BreedOrganization'] = $au_organization;
        $param['CropLevel'] = $au_level;
        $update = $info->updateInfo($param);
        echo returnResult($update, 0);
        exit();
    } else if (isset($_POST ["add"])) {
        if (!$info->check($app_Variety_1, $app_Variety_2, $cropName)) {
            $param = array();
            $param['VarietyName'] = $cropName;
            $param['CropCategory1'] = $app_Variety_1;
            $param['CropCategory2'] = $app_Variety_2;
            $param['CropImgsMin'] = $insert_min ?? '';
            $param['CropImgs'] = $insert ?? '';
            $param['IsGen'] = $IsGen;
            $param['MinGuidePrice'] = $au_min;
            $param['MaxGuidePrice'] = $au_max;
            $param['BreedRegion'] = $au_region;
            $param['Memo'] = $au_memo;
            $param['BreedOrganization'] = $au_organization;
            $param['CropLevel'] = $au_level;
            $insert = $info->insertInfo($param);
            echo returnResult($insert, 0);
            exit();
        } else {
            echo returnResult("已经存在", 0);
            exit();
        }
    }
}
?>
