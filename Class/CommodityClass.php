<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//$eninfo = new CommodityClass();
//$app_commodityid = 88761;
//$bb = $eninfo->setInfo($app_commodityid);


class CommodityClass {

    private $CommodityId; //唯一ID
    private $CommodityTitle; //标题
    private $CommodityName; //名称
    private $CommodityPrice; //价格
    private $CreateTime; //创建时间
    private $CommodityFlag; //作废标记
    private $CommodityFlagTime; //作废时间
    private $CommodityDescribe; //商品描述
    private $Owner; //所有者id
    private $CommodityVip; //推荐标记
    private $CommodityImgs; //商品图片
    private $CommodityVariety; //商品对应品种id
    private $CommodityClass; //商品分类
    private $OwnerClass; //所有者分类id
    private $CommodityVariety_1; //品种一级分类
    private $CommodityVariety_2; //品种二级分类
    private $CommodityOrderNo; //排序
    private $CommodityBrand; //所属品牌
    private $CommodityLicence; //生产经营许可证
    private $CommodityOrderNoCompany; //企业列表排序
    private $CommodityImgsMin; //缩略图
    private $columns; //文章数据表字段集合

    public function __construct() {
        require ( "../../../data/dbClass.php"); //包含配置信息.
        $this->db = $db;
        $this->columns = $this->db->getColumn("AppCommodity", null);
    }

    function setInfo($id) {
        $sql = "select * from AppCommodity where CommodityId=$id";
        $result = $this->db->row($sql); //返回查询结果到数组
        foreach ($this->columns as $column) {
            if ($column != "NewId" && $column != "CommoditySpec") {
                $aa = "set" . "$column";
                $this->$aa($result["$column"]);
            }
        }
        return $result;
    }

    function updateInfo($param) {
        $condition = '';
        foreach ($this->columns as $column) {
            if (!empty($param[$column])) {
                if (empty($condition)) {
                    $condition = $column . "='" . $param[$column] . "'";
                } else {
                    $condition = $condition . "," . $column . "='" . $param[$column] . "'";
                }
            }
        }
        $sql = "update AppCommodity set $condition where CommodityId=$this->CommodityId";
        return $this->db->query($sql);
//        echo $sql;
    }

    function insertInfo($param) {
        $condition = '';
        foreach ($this->columns as $column) {
            if (!empty($param[$column])) {
                if (empty($condition)) {
                    $condition = $column . "='" . $param[$column] . "'";
                } else {
                    $condition = $condition . "," . $column . "='" . $param[$column] . "'";
                }
            }
        }
        $sql = "insert into AppCommodity set $condition ";
        $this->db->query($sql);
        return $this->db->lastInsertId();
//        echo $sql;
    }

    //返回每个属性的public 方法.
    function setFlag($flag) {
        $sql = "update AppCommodity SET CommodityFlag=$flag WHERE CommodityId= $this->CommodityId";
        $update = $this->db->query($sql);
        if ($update == 1) {
            if ($flag == 0) {
                return '启用成功--' . $update;
            } else {
                return '作废成功--' . $update;
            }
        } else {
            return '操作失败--' . $update;
        }
    }

    function getCommodityId() {
        return $this->CommodityId;
    }

    function getCommodityTitle() {
        return $this->CommodityTitle;
    }

    function getCommodityName() {
        return $this->CommodityName;
    }

    function getCommodityPrice() {
        return $this->CommodityPrice;
    }

    function getCreateTime() {
        return $this->CreateTime;
    }

    function getCommodityFlag() {
        return $this->CommodityFlag;
    }

    function getCommodityFlagTime() {
        return $this->CommodityFlagTime;
    }

    function getCommodityDescribe() {
        return $this->CommodityDescribe;
    }

    function getOwner() {
        return $this->Owner;
    }

    function getCommodityVip() {
        return $this->CommodityVip;
    }

    function getCommodityImgs() {
        return $this->CommodityImgs;
    }

    function getCommodityVariety() {
        return $this->CommodityVariety;
    }

    function getCommodityClass() {
        return $this->CommodityClass;
    }

    function getOwnerClass() {
        return $this->OwnerClass;
    }

    function getCommodityVariety_1() {
        return $this->CommodityVariety_1;
    }

    function getCommodityVariety_2() {
        return $this->CommodityVariety_2;
    }

    function getCommodityOrderNo() {
        return $this->CommodityOrderNo;
    }

    function getCommodityBrand() {
        return $this->CommodityBrand;
    }

    function getCommodityLicence() {
        return $this->CommodityLicence;
    }

    function getCommodityOrderNoCompany() {
        return $this->CommodityOrderNoCompany;
    }

    function getCommodityImgsMin() {
        return $this->CommodityImgsMin;
    }

    function getColumns() {
        return $this->columns;
    }

    function setCommodityId($CommodityId) {
        $this->CommodityId = $CommodityId;
    }

    function setCommodityTitle($CommodityTitle) {
        $this->CommodityTitle = $CommodityTitle;
    }

    function setCommodityName($CommodityName) {
        $this->CommodityName = $CommodityName;
    }

    function setCommodityPrice($CommodityPrice) {
        $this->CommodityPrice = $CommodityPrice;
    }

    function setCreateTime($CreateTime) {
        $this->CreateTime = $CreateTime;
    }

    function setCommodityFlag($CommodityFlag) {
        $this->CommodityFlag = $CommodityFlag;
    }

    function setCommodityFlagTime($CommodityFlagTime) {
        $this->CommodityFlagTime = $CommodityFlagTime;
    }

    function setCommodityDescribe($CommodityDescribe) {
        $this->CommodityDescribe = $CommodityDescribe;
    }

    function setOwner($Owner) {
        $this->Owner = $Owner;
    }

    function setCommodityVip($CommodityVip) {
        $this->CommodityVip = $CommodityVip;
    }

    function setCommodityImgs($CommodityImgs) {
        $this->CommodityImgs = $CommodityImgs;
    }

    function setCommodityVariety($CommodityVariety) {
        $this->CommodityVariety = $CommodityVariety;
    }

    function setCommodityClass($CommodityClass) {
        $this->CommodityClass = $CommodityClass;
    }

    function setOwnerClass($OwnerClass) {
        $this->OwnerClass = $OwnerClass;
    }

    function setCommodityVariety_1($CommodityVariety_1) {
        $this->CommodityVariety_1 = $CommodityVariety_1;
    }

    function setCommodityVariety_2($CommodityVariety_2) {
        $this->CommodityVariety_2 = $CommodityVariety_2;
    }

    function setCommodityOrderNo($CommodityOrderNo) {
        $this->CommodityOrderNo = $CommodityOrderNo;
    }

    function setCommodityBrand($CommodityBrand) {
        $this->CommodityBrand = $CommodityBrand;
    }

    function setCommodityLicence($CommodityLicence) {
        $this->CommodityLicence = $CommodityLicence;
    }

    function setCommodityOrderNoCompany($CommodityOrderNoCompany) {
        $this->CommodityOrderNoCompany = $CommodityOrderNoCompany;
    }

    function setCommodityImgsMin($CommodityImgsMin) {
        $this->CommodityImgsMin = $CommodityImgsMin;
    }

    function setColumns($columns) {
        $this->columns = $columns;
    }

}
