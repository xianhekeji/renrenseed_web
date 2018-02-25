<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class CropCommentClass {

    private $CommentRecrodId; //唯一id
    private $CommentCropId; //点评品种Id
    private $CommentUserId; //点评用户id
    private $CommentComment; //点评内容
    private $CommentRecordCreateTime; //点评创建修改时间
    private $CommentFlag; //点评状态0：未审核，1：审核通过 2：审核未通过
    private $CommentIsRead; //是否已读
    private $CommentLevel; //点评星级
    private $CommentImgs; //点评图片
    private $CommentImgsMin; //点评缩略图
    private $columns; //文章数据表字段集合

    public function __construct() {
        require (DT_ROOT . "/data/dbClass.php"); //包含配置信息.
        $this->db = $db;
        $this->columns = $this->db->getColumn("AppCropCommentRecord", null);
    }

    function setInfo($id) {
        $sql = "select * from AppCropCommentRecord where CommentRecrodId=$id";
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
        $sql = "update AppCropCommentRecord set $condition where CommentRecrodId=$this->CommentRecrodId";
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
        $sql = "insert into AppCropCommentRecord set $condition ";
        $this->db->query($sql);
        return $this->db->lastInsertId();
    }

    function getCommentRecrodId() {
        return $this->CommentRecrodId;
    }

    function getCommentCropId() {
        return $this->CommentCropId;
    }

    function getCommentUserId() {
        return $this->CommentUserId;
    }

    function getCommentComment() {
        return $this->CommentComment;
    }

    function getCommentRecordCreateTime() {
        return $this->CommentRecordCreateTime;
    }

    function getCommentFlag() {
        return $this->CommentFlag;
    }

    function getCommentIsRead() {
        return $this->CommentIsRead;
    }

    function getCommentLevel() {
        return $this->CommentLevel;
    }

    function getCommentImgs() {
        return $this->CommentImgs;
    }

    function getCommentImgsMin() {
        return $this->CommentImgsMin;
    }

    function setCommentRecrodId($CommentRecrodId) {
        $this->CommentRecrodId = $CommentRecrodId;
    }

    function setCommentCropId($CommentCropId) {
        $this->CommentCropId = $CommentCropId;
    }

    function setCommentUserId($CommentUserId) {
        $this->CommentUserId = $CommentUserId;
    }

    function setCommentComment($CommentComment) {
        $this->CommentComment = $CommentComment;
    }

    function setCommentRecordCreateTime($CommentRecordCreateTime) {
        $this->CommentRecordCreateTime = $CommentRecordCreateTime;
    }

    function setCommentFlag($CommentFlag) {
        $this->CommentFlag = $CommentFlag;
    }

    function setCommentIsRead($CommentIsRead) {
        $this->CommentIsRead = $CommentIsRead;
    }

    function setCommentLevel($CommentLevel) {
        $this->CommentLevel = $CommentLevel;
    }

    function setCommentImgs($CommentImgs) {
        $this->CommentImgs = $CommentImgs;
    }

    function setCommentImgsMin($CommentImgsMin) {
        $this->CommentImgsMin = $CommentImgsMin;
    }

}

?>