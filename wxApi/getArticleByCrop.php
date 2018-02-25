<?php

require '../common.php';
include '../wxAction.php';
$PageNo = $_GET ['searchPageNum'];
$PageStart = $PageNo * 5;
$cropname = isset($_GET['cropname']) ? $_GET['cropname'] : '';
$CropCategoryName1 = isset($_GET['CropCategoryName1']) ? $_GET['CropCategoryName1'] : '';
$CropCategoryName2 = isset($_GET['CropCategoryName2']) ? $_GET['CropCategoryName2'] : '';
$condition = '';
if ($cropname == '') {
    
} else {
    $condition = " a.ArticleLabel like '%$cropname%'";
}
if ($CropCategoryName1 == '') {
    
} else {
    if (trim($condition) != '') {
        $condition = $condition . "or a.ArticleLabel like '%$CropCategoryName1%'";
    } else {
        $condition = " a.ArticleLabel like '%$CropCategoryName1%'";
    }
}
if ($CropCategoryName2 == '') {
    
} else {
    if (trim($condition) != '') {
        $condition = $condition . "or  a.ArticleLabel like '%$CropCategoryName2%'";
    } else {
        $condition = "  a.ArticleLabel like '%$CropCategoryName2%'";
    }
}
//$PageNo = $_GET ['searchPageNum'];
$sql = "select a.ArticleId,a.ArticleTitle,DATE_FORMAT(a.ArticleCreateTime,'%Y-%m-%d') ArticleCreateTime,a.ArticleCover,a.ArticleVideo,a.ArticleVideoPosterUrl 
    from WXArticle a 
where $condition
           ORDER BY a.ArticleCreateTime desc limit $PageStart,5";
$result = $db->query($sql);
if (count($result) == 0) {
    $sql = "select a.ArticleId, a.ArticleTitle, DATE_FORMAT(a.ArticleCreateTime, '%Y-%m-%d') ArticleCreateTime, a.ArticleCover, a.ArticleVideo,a.ArticleVideoPosterUrl 
from WXArticle a where a.ArticleClassId = 1
ORDER BY a.ArticleCreateTime desc limit $PageStart,5";
    $result = $db->query($sql);
}


echo app_wx_iconv_result('getArticleByCrop', true, 'success', 0, 0, 0, $result);
