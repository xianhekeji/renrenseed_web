<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class KoubeiClass {

    private $CommentRecrodId; //唯一id
    private $CommentCropId; //点评品种id
    private $CommentUserId; //点评用户id
    private $CommentComment; //点评内容
    private $CommentRecordCreateTime; //点评、修改时间
    private $CommentFlag; //是否作废 0:正常 1：作废
    private $CommentIsRead; //是否已读
    private $CommentLevel; //星级
    private $CommentImgs; //点评图片
    private $CommentImgsMin; //点评缩略图
    private $db;
    private $columns; //字段集合

    public function __construct() {
        require (DT_ROOT . "/data/dbClass.php"); //包含配置信息.
        $this->db = $db;
        $this->columns = $this->db->getColumn("AppCropCommentRecord", null);
    }

    function checkInfo($id) {
        $sql = "select * from AppCropCommentRecord where CommentRecrodId='$id'";
        $result = $this->db->query($sql); //返回查询结果到数组
        return count($result) > 0 ? true : false;
    }

    function checkYJdianping($id, $cropid) {
        $re = false;
        $count_sql = "select * from AppCropCommentRecord where CommentCropId=$cropid and CommentUserId=$id and  (to_days(NOW())-to_days(CommentRecordCreateTime))<3";
        $count = $this->db->query($count_sql);
        if (count($count) > 0) {
            $re = true;
        }
        return $re;
    }

    function checkString($str) {
        $re = false;
        $sql = "select * from WXCommentDisableKeys";
        $result = $this->db->query($sql); //返回查询结果到数组
        foreach ($result as $row) {
            if (strpos($str, $row["keyword"]) === false) {     //使用绝对等于
                //不包含
                //   return false;
            } else {
                //包含
                $re = true;
            }
        }
//        $arr = array("习近平", "。。。", "111", "...", "我我我", "啊啊啊", "非常好非常好", "呵呵", "啦啦啦", "222", "333", "444", "555", "666", "777", "888", "999");
//        $str2 = '习近平';
//        foreach ($arr as $value) {
//            if (strpos($str, $value) === false) {     //使用绝对等于
//                //不包含
//                //   return false;
//            } else {
//                //包含
//                $re = true;
//            }
//        }
        return $re;
//strpos 大小写敏感  stripos大小写不敏感    两个函数都是返回str2 在str1 第一次出现的位置
    }

    function checkUser($id) {
        $re = 0;
        $count_sql = "select count(*) count from WXCommentStatu where userid='$id'";
        $count = $this->db->row($count_sql);
        if ($count["count"] > 0) {
            $sql = "select * from WXCommentStatu where userid=$id limit 0,1";
            $result = $this->db->row($sql); //返回查询结果到数组
            if ($result["Status"] == 1) {
                $re = 1;
            }
            if ($result["Status"] == 2) {
                $re = 2;
            }
        }
        return $re;
    }

    function getInfo() {
        $sql = "select * from AppCropCommentRecord where CommentRecrodId='$this->CommentRecrodId' limit 0,1";
        $result = $this->db->row($sql); //返回查询结果到数组
        return $result;
    }

    function setInfo($id) {
        $sql = "select * from AppCropCommentRecord where CommentRecrodId='$id'";
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
        $sql = "update AppCropCommentRecord set $condition where CommentRecrodId=$this->userId";
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
        $lastid = $this->db->lastInsertId();
        $this->setInfo($lastid);
        return $lastid;
    }

    function getResult() {
        $sql = "select * from WXKoubeiResult where Flag=0 limit 0,1";
        $result = $this->db->row($sql);
        return $result;
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
