<?php
define('IN_ECS', true);
require(dirname(__FILE__) . '/includes/init.php');
$smarty->assign('page', 'school');  // 当前位置
$smarty->display('school.dwt');
?>