<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require '../common.php';
include '../wxAction.php';
$sql = "select * from WXArticleHotLabel";
$result = $db->query($sql);
echo app_wx_iconv_result('getArticleHotLabel', true, 0, 0, 0, 0, $result);
?>
