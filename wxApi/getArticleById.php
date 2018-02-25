<?php

require '../common.php';
include '../wxAction.php';
$wxId = $_GET['Id'];
$db->query("update WXArticle set ArticleReadCount=ArticleReadCount+1 where ArticleId=$wxId");
$sql = "select ArticleId,ArticleTitle,REPLACE(ArticleContent,CHAR(9),'')  ArticleContent,ArticleVideo,DATE_FORMAT(ArticleCreateTime,'%Y-%m-%d') ArticleCreateTime,ArticleFlag,ArticleCover,ArticleLabel,ArticleVideoFrom ,ArticleVideoPosterUrl
from WXArticle
where ArticleId=$wxId limit 0,1";
$result = $db->row($sql);

echo app_wx_iconv_result('getArticleById', true, 'success', 0, 0, 0, $result);
?>