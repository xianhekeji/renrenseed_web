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
$data = array();
echo $twig->render('setting/AuthorizeSetting.xhtml', $data);
?>