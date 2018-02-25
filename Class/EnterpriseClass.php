<?php

class EnterpriseClass {

    private $EnterpriseId;
    private $EnterpriseName;
    private $EnterpriseBusScrope;
    private $EnterpriseLevel;
    private $EnterpriseTelephone;
    private $EnterpriseFlag;
    private $EnterpriseIntroduce;
    private $EnterpriseProvince;
    private $EnterpriseCity;
    private $EnterpriseZone;
    private $EnterpriseAddressDetail;
    private $EnterpriseLat;
    private $EnterpriseLon;
    private $EnterpriseUserCode;
    private $EnterprisePassword;
    private $EnterpriseUserAvatar;
    private $EnterpriseCommentLevel;
    private $EnterpriseOrderNo;
    private $EnterpriseWeb;
    private $db;
    private $columns; //文章数据表字段集合

    public function __construct() {
        require (DT_ROOT . "/data/dbClass.php"); //包含配置信息.
        $this->db = $db;
        $this->columns = $this->db->getColumn("AppEnterprise", null);
    }

    function getInfo() {
        $sql = "select * from AppEnterprise where EnterpriseId='$this->EnterpriseId' limit 0,1";
        $result = $this->db->row($sql); //返回查询结果到数组
        return $result;
    }

    function setInfo($id) {
        $sql = "select * from AppEnterprise where EnterpriseId='$id'";
        $result = $this->db->row($sql); //返回查询结果到数组
        foreach ($this->columns as $column) {
            $aa = "set" . "$column";
            $this->$aa($result["$column"]);
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
        $sql = "update EnterpriseId set $condition where id=$this->id";
        return $this->db->query($sql);
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
        $sql = "insert into EnterpriseId set $condition ";
        $this->db->query($sql);
        $lastid=$this->db->lastInsertId();
        $this->setInfo($lastid);
        return $lastid;
    }

    function getEnterpriseId() {
        return $this->EnterpriseId;
    }

    function getEnterpriseName() {
        return $this->EnterpriseName;
    }

    function getEnterpriseBusScrope() {
        return $this->EnterpriseBusScrope;
    }

    function getEnterpriseLevel() {
        return $this->EnterpriseLevel;
    }

    function getEnterpriseTelephone() {
        return $this->EnterpriseTelephone;
    }

    function getEnterpriseFlag() {
        return $this->EnterpriseFlag;
    }

    function getEnterpriseIntroduce() {
        return $this->EnterpriseIntroduce;
    }

    function getEnterpriseProvince() {
        return $this->EnterpriseProvince;
    }

    function getEnterpriseCity() {
        return $this->EnterpriseCity;
    }

    function getEnterpriseZone() {
        return $this->EnterpriseZone;
    }

    function getEnterpriseAddressDetail() {
        return $this->EnterpriseAddressDetail;
    }

    function getEnterpriseLat() {
        return $this->EnterpriseLat;
    }

    function getEnterpriseLon() {
        return $this->EnterpriseLon;
    }

    function getEnterpriseUserCode() {
        return $this->EnterpriseUserCode;
    }

    function getEnterprisePassword() {
        return $this->EnterprisePassword;
    }

    function getEnterpriseUserAvatar() {
        return $this->EnterpriseUserAvatar;
    }

    function getEnterpriseCommentLevel() {
        return $this->EnterpriseCommentLevel;
    }

    function getEnterpriseOrderNo() {
        return $this->EnterpriseOrderNo;
    }

    function getEnterpriseWeb() {
        return $this->EnterpriseWeb;
    }

    function setEnterpriseId($EnterpriseId) {
        $this->EnterpriseId = $EnterpriseId;
    }

    function setEnterpriseName($EnterpriseName) {
        $this->EnterpriseName = $EnterpriseName;
    }

    function setEnterpriseBusScrope($EnterpriseBusScrope) {
        $this->EnterpriseBusScrope = $EnterpriseBusScrope;
    }

    function setEnterpriseLevel($EnterpriseLevel) {
        $this->EnterpriseLevel = $EnterpriseLevel;
    }

    function setEnterpriseTelephone($EnterpriseTelephone) {
        $this->EnterpriseTelephone = $EnterpriseTelephone;
    }

    function setEnterpriseFlag($EnterpriseFlag) {
        $this->EnterpriseFlag = $EnterpriseFlag;
    }

    function setEnterpriseIntroduce($EnterpriseIntroduce) {
        $this->EnterpriseIntroduce = $EnterpriseIntroduce;
    }

    function setEnterpriseProvince($EnterpriseProvince) {
        $this->EnterpriseProvince = $EnterpriseProvince;
    }

    function setEnterpriseCity($EnterpriseCity) {
        $this->EnterpriseCity = $EnterpriseCity;
    }

    function setEnterpriseZone($EnterpriseZone) {
        $this->EnterpriseZone = $EnterpriseZone;
    }

    function setEnterpriseAddressDetail($EnterpriseAddressDetail) {
        $this->EnterpriseAddressDetail = $EnterpriseAddressDetail;
    }

    function setEnterpriseLat($EnterpriseLat) {
        $this->EnterpriseLat = $EnterpriseLat;
    }

    function setEnterpriseLon($EnterpriseLon) {
        $this->EnterpriseLon = $EnterpriseLon;
    }

    function setEnterpriseUserCode($EnterpriseUserCode) {
        $this->EnterpriseUserCode = $EnterpriseUserCode;
    }

    function setEnterprisePassword($EnterprisePassword) {
        $this->EnterprisePassword = $EnterprisePassword;
    }

    function setEnterpriseUserAvatar($EnterpriseUserAvatar) {
        $this->EnterpriseUserAvatar = $EnterpriseUserAvatar;
    }

    function setEnterpriseCommentLevel($EnterpriseCommentLevel) {
        $this->EnterpriseCommentLevel = $EnterpriseCommentLevel;
    }

    function setEnterpriseOrderNo($EnterpriseOrderNo) {
        $this->EnterpriseOrderNo = $EnterpriseOrderNo;
    }

    function setEnterpriseWeb($EnterpriseWeb) {
        $this->EnterpriseWeb = $EnterpriseWeb;
    }

}
