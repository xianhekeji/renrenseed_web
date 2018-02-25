<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class DisableUserClass {

    private $Id;
    private $Userid;
    private $Starttime;
    private $Endtime;
    private $Status;
    private $IsCall;
    private $db;
    private $columns; //文章数据表字段集合

    public function __construct() {
        require (DT_ROOT . "/data/dbClass.php"); //包含配置信息.
        $this->db = $db;
        $this->columns = $this->db->getColumn("WXCommentStatu", null);
    }

    function checkInfo($Id) {
        $sql = "select * from WXCommentStatu where Userid='$Id'";
        $result = $this->db->query($sql); //返回查询结果到数组
        return count($result) > 0 ? true : false;
    }

    function getUserInfo() {
        $sql = "select * from WXCommentStatu where Id='$this->Id' limit 0,1";
        $result = $this->db->row($sql); //返回查询结果到数组
        return $result;
    }

    function setInfo($Id) {
        $sql = "select * from WXCommentStatu where Userid='$Id'";
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

            if (isset($param[$column])) {
                if (empty($condition)) {
                    $condition = $column . "='" . $param[$column] . "'";
                } else {
                    $condition = $condition . "," . $column . "='" . $param[$column] . "'";
                }
            }
        }
        $sql = "update WXCommentStatu set $condition where Id=$this->Id";
        // return $aa;
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
        $sql = "insert into WXCommentStatu set $condition ";
        $this->db->query($sql);
        $lastid = $this->db->lastInsertId();
        $this->setInfo($lastid);
        return $lastid;
    }

    function getId() {
        return $this->Id;
    }

    function getUserid() {
        return $this->Userid;
    }

    function getStarttime() {
        return $this->Starttime;
    }

    function getEndtime() {
        return $this->Endtime;
    }

    function getStatus() {
        return $this->ComentStatus;
    }

    function getIsCall() {
        return $this->IsCall;
    }

    function setId($Id) {
        $this->Id = $Id;
    }

    function setUserid($Userid) {
        $this->Userid = $Userid;
    }

    function setStarttime($Starttime) {
        $this->Starttime = $Starttime;
    }

    function setEndtime($Endtime) {
        $this->Endtime = $Endtime;
    }

    function setStatus($ComentStatus) {
        $this->ComentStatus = $ComentStatus;
    }

    function setIsCall($IsCall) {
        $this->IsCall = $IsCall;
    }

}

?>
