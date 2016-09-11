<?php
define('IN_ECS', true);
require(dirname(__FILE__) . '/includes/init.php');
$smarty->assign('page', 'companyService');  // 当前位置
$smarty->display('companyService.dwt');
?>