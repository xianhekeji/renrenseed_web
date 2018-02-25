<?php

require '../common.php';
include '../wxAction.php';
$wxId = $_GET['cropid'];
//$PageNo = $_GET ['searchPageNum'];
$sql = "select a.ArticleId,a.ArticleTitle,DATE_FORMAT(a.ArticleCreateTime,'%Y-%m-%d') ArticleCreateTime,a.ArticleCover,a.ArticleVideo "
        . " from WXArticle a where a.ArticleClassId=1 "
        . "    ORDER BY ArticleCreateTime desc";
$result = $db->query($sql);
$array = array();
foreach ($result as $rows) {
    $rows['ArticleContent'] = str_replace('&quot;', "'", $rows['ArticleContent']);
    $new_time = date("Y-m-d", strtotime($rows['ArticleCreateTime']));
    $rows['ArticleCreateTime'] = $new_time;
    $array [] = $rows;
}

echo app_wx_iconv_result('getArticleByCropId', true, 'success', 0, 0, 0, $array);
