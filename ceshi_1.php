<?php

require( "common.php");
//$twig->display('base.xhtml', array('name' => 'Bobby'));
echo $twig->render('index_new.xhtml', array('name' => 'Bobby'));
?>