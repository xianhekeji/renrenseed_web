<?php

require '../../../common.php';
include '../../../comm/imgageUnit.php';
require DT_ROOT . '/Class/CommodityClass.php';
include '../../../wxAction.php';
$path = DT_ROOT . '/files/commodityImgs/';
$eninfo = new CommodityClass();
if (isset($_POST ["flag_qiyong"])) {
    if (empty($_POST ['name'])) { // 点击提交按钮后才执行
        echo "<script>alert('商品名称不能为空')</script>";
        return;
    }
    $arr_commodityid = explode(';', $_POST ['commodityname']);
    $app_commodityid = $arr_commodityid [0];
    $eninfo->setInfo($app_commodityid);
    $result = $eninfo->setFlag(0);
    echo returnResult($result, 0);
    exit();
}
if (isset($_POST ["flag_zuofei"])) {
    if (empty($_POST ['name'])) { // 点击提交按钮后才执行
        echo "<script>alert('商品名称不能为空')</script>";
        return;
    }
    $arr_commodityid = explode(';', $_POST ['commodityname']);
    $app_commodityid = $arr_commodityid [0];
    $eninfo->setInfo($app_commodityid);
    $result = $eninfo->setFlag(1);
    echo returnResult($result, 0);
    exit();
}

if (isset($_POST ["add"]) || isset($_POST ["modify"])) {
    if (empty($_POST ['name'])) { // 点击提交按钮后才执行
        echo "<script>alert('商品名称不能为空');history.back();</script>";
        return;
    }
    /*
     * if (empty ( $_POST ['price'] )) { // 点击提交按钮后才执行
     * echo "<script>alert('商品价格不能为空');history.back();</script>";
     * return;
     * }
     */
    if (empty($_POST ['describe'])) { // 点击提交按钮后才执行
        echo "<script>alert('商品描述不能为空');history.back();</script>";
        return;
    }
    if (empty($_POST ['key'])) { // 点击提交按钮后才执行
        echo "<script>alert('所属企业不能为空');history.back();</script>";
        return;
    }

    /*
     * if (empty ( $_POST ['brand'] )) { // 点击提交按钮后才执行
     * echo "<script>alert('品牌不能为空')</script>";
     * return;
     * }
     */
    /*
     * if (empty ( $_POST ['spec'] )) { // 点击提交按钮后才执行
     * echo "<script>alert('规格不能为空');history.back();</script>";
     * return;
     * }
     */
    if (empty($_POST ['cropname'])) { // 点击提交按钮后才执行
        echo "<script>alert('品种不能为空');history.back();</script>";
        return;
    }
    $arr_crop = explode(';', $_POST ['cropname']);
    $crop_id = $arr_crop [0];
    $crop_name = $arr_crop [1];
    $app_commodity_title = $_POST ['name'];
    $app_commodity_name = $_POST ['name'];
    $app_commodity_class = $_POST ['class'];
    $app_commodity_price = $_POST ['price'];
    $app_commodity_describe = $_POST ['describe'];
    $app_Variety_1 = $_POST ['select_1'];
    $app_Variety_2 = $_POST ['select_2'];

    $arr_brand = explode(';', $_POST ['brand']);
    $app_brand = $arr_brand [0];

    $app_spec = $_POST ['spec'];
    $arr_companyid = explode(';', $_POST ['key']);
    $companyid = $arr_companyid [0];
    $arr_commodityid = explode(';', $_POST ['commodityname']);
    $app_commodityid = $arr_commodityid [0];

    $images = isset($_FILES ["myfile"]) ? $_FILES ["myfile"] : '';
    $site = isset($_REQUEST ['site']) ? $_REQUEST ['site'] : '';
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

            $rename = 'commodity_' . time() . '_' . $i;
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
        if (isset($_POST ["modify"])) {
            $eninfo->setInfo($app_commodityid);
            $param = array();
            $param['CommodityTitle'] = $app_commodity_title;
            $param['CommodityName'] = $app_commodity_name;
            $param['Owner'] = $companyid;
            $param['CommodityImgs'] = $insert;
            $param['CommodityVariety'] = $crop_id;
            $param['CommodityPrice'] = $app_commodity_price;
            $param['CommodityDescribe'] = $app_commodity_describe;
            $param['CommodityClass'] = $app_commodity_class;
            $param['CommodityVariety_1'] = $app_Variety_1;
            $param['CommodityVariety_2'] = $app_Variety_2;
            $param['CommodityLicence'] = $app_spec;
            $param['CommodityBrand'] = $app_brand;
            $param['CommodityImgsMin'] = $insert_min;
            $update = $eninfo->updateInfo($param);
            echo returnResult($update, 0);
            exit();
        } else if (isset($_POST ["add"])) {
            $param = array();
            $param['CommodityTitle'] = $app_commodity_title;
            $param['CommodityName'] = $app_commodity_name;
            $param['Owner'] = $companyid;
            $param['CommodityImgs'] = $insert;
            $param['CommodityVariety'] = $crop_id;
            $param['CommodityPrice'] = $app_commodity_price;
            $param['CommodityDescribe'] = $app_commodity_describe;
            $param['CommodityClass'] = $app_commodity_class;
            $param['CommodityVariety_1'] = $app_Variety_1;
            $param['CommodityVariety_2'] = $app_Variety_2;
            $param['CommodityLicence'] = $app_spec;
            $param['CommodityBrand'] = $app_brand;
            $param['CommodityImgsMin'] = $insert_min;
            $insert = $eninfo->insertInfo($param);
            echo returnResult($insert, 0);
        }
    } else {
        if (isset($_POST ["modify"])) {
            $eninfo->setInfo($app_commodityid);
            $param = array();
            $param['CommodityTitle'] = $app_commodity_title;
            $param['CommodityName'] = $app_commodity_name;
            $param['Owner'] = $companyid;
            $param['CommodityVariety'] = $crop_id;
            $param['CommodityPrice'] = $app_commodity_price;
            $param['CommodityDescribe'] = $app_commodity_describe;
            $param['CommodityClass'] = $app_commodity_class;
            $param['CommodityVariety_1'] = $app_Variety_1;
            $param['CommodityVariety_2'] = $app_Variety_2;
            $param['CommodityLicence'] = $app_spec;
            $param['CommodityBrand'] = $app_brand;
            $update = $eninfo->updateInfo($param);
            echo returnResult($update, 0);
            exit();
        } else if (isset($_POST ["add"])) {
//            $eninfo->setInfo($app_commodityid);
            $param = array();
            $param['CommodityTitle'] = $app_commodity_title;
            $param['CommodityName'] = $app_commodity_name;
            $param['Owner'] = $companyid;
            $param['CommodityVariety'] = $crop_id;
            $param['CommodityPrice'] = $app_commodity_price;
            $param['CommodityDescribe'] = $app_commodity_describe;
            $param['CommodityClass'] = $app_commodity_class;
            $param['CommodityVariety_1'] = $app_Variety_1;
            $param['CommodityVariety_2'] = $app_Variety_2;
            $param['CommodityLicence'] = $app_spec;
            $param['CommodityBrand'] = $app_brand;
            $insert = $eninfo->insertInfo($param);
            echo returnResult($insert, 0);
        }
    }
}
?>
