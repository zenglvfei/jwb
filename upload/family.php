<?php
define('IN_ECS', true);
require(dirname(__FILE__) . '/includes/init.php');
$smarty->assign('page', 'family');  // 当前位置
$smarty->display('family.dwt');
?>