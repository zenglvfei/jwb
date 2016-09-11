<?php
define('IN_ECS', true);
require(dirname(__FILE__) . '/includes/init.php');
$smarty->assign('page', 'channel');  // 当前位置
$smarty->display('channel.dwt');
?>