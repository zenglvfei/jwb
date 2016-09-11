<?php
define('IN_ECS', true);
require(dirname(__FILE__) . '/includes/init.php');
$smarty->assign('page', 'aboutus');  // 当前位置
$smarty->display('aboutus.dwt');
?>