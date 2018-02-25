<?php

class CompanyUserClass {

    private $id; //唯一id
    private $UserCode; //登录帐号
    private $UserPass; //登录密码
    private $UserFlag; //作废标记
    private $CreateTime; //创建修改时间
    private $UserEnterId; //企业id
    private $WXUnionId; //微信id
    private $db;
    private $columns; //文章数据表字段集合

    public function __construct() {
        require (DT_ROOT . "/data/dbClass.php"); //包含配置信息.
        $this->db = $db;
        $this->columns = $this->db->getColumn("WXCompanyUser", null);
    }

    function checkInfo($UserCode) {
        $sql = "select * from WXCompanyUser where UserCode='$UserCode'";
        $result = $this->db->query($sql); //返回查询结果到数组
        return count($result) > 0 ? true : false;
    }

    function loginCompany($code, $pass) {
        $arr = array();
        if ($this->checkInfo($code)) {
            $sql = "select * from WXCompanyUser where UserCode='$code' and UserPass='$pass' limit 0,1";
            $result = $this->db->query($sql); //返回查询结果到数组
            if (count($result) > 0) {
                $this->setInfo($result["id"]);
                $arr = array(
                    "resultNote" => "登录成功",
                    "result" => $result[0]
                );
            } else {
                $arr = array(
                    "resultNote" => "密码/帐号错误",
                    "result" => null
                );
            }
        } else {
            $arr = array(
                "resultNote" => "用户不存在",
                "result" => null
            );
        }
        return $arr;
    }

    function getUserInfo() {
        $sql = "select * from WXCompanyUser where id='$this->id' limit 0,1";
        $result = $this->db->row($sql); //返回查询结果到数组
        return $result;
    }

    function setInfo($id) {
        $sql = "select * from WXCompanyUser where id='$id'";
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
        $sql = "update WXCompanyUser set $condition where id=$this->id";
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
        $sql = "insert into WXCompanyUser set $condition ";
        $this->db->query($sql);
        $lastid = $this->db->lastInsertId();
        $this->setInfo($lastid);
        return $lastid;
    }

    function getId() {
        return $this->id;
    }

    function getUserCode() {
        return $this->UserCode;
    }

    function getUserPass() {
        return $this->UserPass;
    }

    function getUserFlag() {
        return $this->UserFlag;
    }

    function getCreateTime() {
        return $this->CreateTime;
    }

    function getUserEnterId() {
        return $this->UserEnterId;
    }

    function getWXUnionId() {
        return $this->WXUnionId;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setUserCode($UserCode) {
        $this->UserCode = $UserCode;
    }

    function setUserPass($UserPass) {
        $this->UserPass = $UserPass;
    }

    function setUserFlag($UserFlag) {
        $this->UserFlag = $UserFlag;
    }

    function setCreateTime($CreateTime) {
        $this->CreateTime = $CreateTime;
    }

    function setUserEnterId($UserEnterId) {
        $this->UserEnterId = $UserEnterId;
    }

    function setWXUnionId($WXUnionId) {
        $this->WXUnionId = $WXUnionId;
    }

}

?>
