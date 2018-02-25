<?php
require '../../common.php';
include '../../wxAction.php';
require DT_ROOT . '/Class/CropCommentClass.php';
$info = new CropCommentClass();
$id = _post("id");
$flag = _post("flag");
$info->setInfo($id);
$arr = array();
$arr["CommentFlag"] = $flag;
$re = $info->updateInfo($arr);
echo $re > 0 ? "成功-" . $re : "失败-" . $re;
?>