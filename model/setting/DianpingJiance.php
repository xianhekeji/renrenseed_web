<?php

session_start();
//unset($_SESSION);
//session_destroy();
if (!isset($_SESSION['user'])) {
    $_SESSION['userurl'] = $_SERVER['REQUEST_URI'];
    header("location:../../system.php?"); //重新定向到其他页面
    exit();
} else {
    
}
require '../../commonNew.php';
include DT_ROOT . '/wxAction.php';
require (DT_ROOT . "/data/dbClass.php"); //包含配置信息.
$data = array();
$perNumber = 10; //每页显示的记录数  
$page = isset($_GET['page']) ? $_GET['page'] : 1; //获得当前的页面值  
$count = $db->row("select count(*) count from AppCropCommentRecord "); //获得记录总数  
$totalNumber = $count['count'];
$totalPage = ceil($totalNumber / $perNumber); //计算出总页数  
if (!isset($page)) {
    $page = 1;
} //如果没有值,则赋值1  
$startCount = ($page - 1) * $perNumber; //分页开始,根据此方法计算出开始的记录  
$data['page'] = $page;
$data['pageBegin'] = $page > 5 ? $page - 5 : 1;
$data['pageEnd'] = $page + 4 > $totalPage ? $totalPage : $page + 4;
$data['totalPage'] = $totalPage;

$sql = "select a.*,b.UserName,b.UserId,c.Status,d.VarietyName,b.UserGZHOpenId  from AppCropCommentRecord a
inner join WXUser b on a.CommentUserId=b.UserId 
left join WXCommentStatu c on a.CommentUserId=c.Userid
left join WXCrop d on a.CommentCropId=d.CropId
where CommentRecordCreateTime>DATE_FORMAT(NOW(),'%m-%d-%Y') 
ORDER BY CommentRecordCreateTime desc 
limit  $startCount,$perNumber";
$result = $db->query($sql); //返回查询结果到数组
$data["commen"] = $result;
echo $twig->render('setting/DianpingJiance.xhtml', $data);
?>