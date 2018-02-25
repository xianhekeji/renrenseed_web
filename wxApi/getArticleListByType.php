<?php

require '../common.php';
include '../wxAction.php';
$PageNo = $_GET ['searchPageNum'];
$ClassId = $_GET ['classid'];
$PageStart = $PageNo * 10;
if ($ClassId < 3) {

    $sql = "select a.ArticleId,a.ArticleTitle,DATE_FORMAT(a.ArticleCreateTime,'%Y-%m-%d') ArticleCreateTime,a.ArticleCover,a.ArticleVideo,a.ArticleVideoPosterUrl from WXArticle a
    where ArticleClassId=$ClassId 
    ORDER BY a.ArticleCreateTime desc
limit $PageStart,10";
} else {
    $sql_class = "select * from WXArticleHotLabel where id=$ClassId";
    $class = $db->row($sql_class);
    $label = $class['name'];
    $sql = "select a.ArticleId,a.ArticleTitle,DATE_FORMAT(a.ArticleCreateTime,'%Y-%m-%d') ArticleCreateTime,a.ArticleCover,a.ArticleVideo,a.ArticleVideoPosterUrl from WXArticle a
    where ArticleLabel like '%$label%' 
    ORDER BY a.ArticleCreateTime desc
limit $PageStart,10";
}

$result = $db->query($sql);
echo app_wx_iconv_result('getArticleList', true, 'success', 0, 0, 0, $result);
?>