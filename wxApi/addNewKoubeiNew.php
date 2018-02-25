<?php

require '../common.php';
include '../wxAction.php';
require DT_ROOT . '/Class/KoubeiClass.php';
$info = new KoubeiClass();
$img = _post("imgs");
$img_min = _post("imgs_min");
$UserId = $_POST ['UserId'];
if ($UserId == 0) {
    $data = array(
        'content' => '请登录后再发表！',
        'status' => 1
    );
} else {
    $Comment = $_POST ['Comment'];
    if (mb_strlen($Comment, 'utf-8') < 20) {
        $data = array(
            'content' => '点评字数不能少于20字',
            'status' => 1
        );
        echo app_wx_iconv_result('addNewKoubei', true, 'success', 0, 0, 0, $data);
        exit();
    }
    if (checkZW($Comment)) {
        $data = array(
            'content' => '点评内容不符合规范，请认真点评！',
            'status' => 1
        );
        echo app_wx_iconv_result('addNewKoubei', true, 'success', 0, 0, 0, $data);
        exit();
    }
    if ($info->checkString($Comment)) {
        $data = array(
            'content' => '点评内容不符合规范，请认真点评！',
            'status' => 1
        );
        echo app_wx_iconv_result('addNewKoubei', true, 'success', 0, 0, 0, $data);
        exit();
    }
    $thisCropId = $_POST ['CropId'];
    if ($info->checkYJdianping($UserId, $thisCropId)) {
        $data = array(
            'content' => '您已经点评过这个品种了！',
            'status' => 1
        );
        echo app_wx_iconv_result('addNewKoubei', true, 'success', 0, 0, 0, $data);
        exit();
    }
    if ($info->checkUser($UserId) == 1) {
        $data = array(
            'content' => '很遗憾，您上次的点评与品种无关，系统禁言一天，期待您更认真的点评。',
            'status' => 1
        );
        echo app_wx_iconv_result('addNewKoubei', true, 'success', 0, 0, 0, $data);
        exit();
    }
    if ($info->checkUser($UserId) == 2) {
        $data = array(
            'content' => '很遗憾，您上次的点评与品种无关，系统禁言一天，期待您更认真的点评。',
            'status' => 1
        );
        echo app_wx_iconv_result('addNewKoubei', true, 'success', 0, 0, 0, $data);
        exit();
    }
    $CommentCropId = $_POST ['CropId'];
    $CommentLevel = $_POST ['CommentLevel'];
    $insert = str_replace(",", ";", $img);
    $insert_min = str_replace(",", ";", $img_min);
    $param = array();
    $param["CommentCropId"] = $CommentCropId;
    $param["CommentUserId"] = $UserId;
    $param["CommentComment"] = $Comment;
    $param["CommentLevel"] = $CommentLevel;
    $param["CommentImgs"] = $insert;
    $param["CommentImgsMin"] = $insert_min;
    $result = $info->insertInfo($param);
    if ($result > 0) {
        $data = array(
            'content' => $info->getResult()["resultText"] ?? "点评成功！",
            'status' => 0
        );
    } else {
        $data = array(
            'content' => "发布失败，请重试!",
            'status' => 0
        );
    }
}

function checkZW($str) {
    $re = false;
    $len_all = strlen($str);
    $len_st = mb_strlen($str, 'UTF-8');
    if (($len_all - $len_st) / (2 * $len_st) < 0.5) {
        $error = "中文字符少于百分之五十";
        $re = true;
    }
    return $re;
}

function checkYJdianping($id, $cropid) {
    
}

//function checkString($str) {
//    $re = false;
//    $arr = array("习近平", "。。。", "111", "...", "我我我", "啊啊啊", "非常好非常好", "呵呵", "啦啦啦", "222", "333", "444", "555", "666", "777", "888", "999");
//    $str2 = '习近平';
//    foreach ($arr as $value) {
//        if (strpos($str, $value) === false) {     //使用绝对等于
//            //不包含
//            //   return false;
//        } else {
//            //包含
//            $re = true;
//        }
//    }
//    return $re;
////strpos 大小写敏感  stripos大小写不敏感    两个函数都是返回str2 在str1 第一次出现的位置
//}

echo app_wx_iconv_result('addNewKoubeiNew', true, 'success', 0, 0, 0, $data);
?>

