<?php

/**
 * 阿姨管理
*/

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');

function getSexValue($sex) {
    if ($sex == '1') {
        return '男';
    }
    return '女';
}
function getWorkPreferValue($type) {
    if ($type == 1) {
        return '保洁养护';
    }
    if ($type == 2) {
        return '家庭护理';
    }
    if ($type == 3) {
        return '洗衣洗鞋';
    }
    if ($type == 4){
        return '家庭厨娘';
    }
}
function getWorkTypeValue($type) {
    if ($type == 1) {
        return '可住家';
    }
    if ($type == 2) {
        return '自己住';
    }
}
function getCashDepositValue($val) {
    if ($val== '1') {
        return '已缴纳';
    }
    return '未缴纳';
}

function ayi_operable_list($info)
{
    /* 取得订单状态、发货状态、付款状态 */
    $os = $info['validate_status'];
    /* 根据状态返回可执行操作 */
    $list = array();
    if ($os == 0) {
        $list['pass']    = true; // 确认
        $list['refuse']    = true; // 无效
    }
    // 确认状态
    else if($os == 1) {
        $list['refuse']    = true; // 确认
    }
    // 无效状态
    else if($os == 2) {
        $list['pass']    = true; // 确认
    }
    return $list;
}

function getValidateStatusValue($val) {
    if ($val == 0)  {
        return '待认证';
    }
    if ($val == 1)  {
        return '认证通过';
    }
    if ($val == 2)  {
        return '认证未通过';
    }
}

/* act操作项的初始化 */
if (empty($_REQUEST['act']))
{
    $_REQUEST['act'] = 'list';
}
else
{
    $_REQUEST['act'] = trim($_REQUEST['act']);
}

/*------------------------------------------------------ */
//-- 获取没有回复的评论列表
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'list')
{
    /* 检查权限 */
    admin_priv('comment_priv');

    $smarty->assign('ur_here',      $_LANG['20_ayi_manage']);
    $smarty->assign('full_page',    1);

    $list = get_ayi_list();
    $smarty->assign('ayi_list', $list['item']);
    $smarty->assign('filter',       $list['filter']);
    $smarty->assign('record_count', $list['record_count']);
    $smarty->assign('page_count',   $list['page_count']);

    $sort_flag  = sort_flag($list['filter']);
    $smarty->assign($sort_flag['tag'], $sort_flag['img']);

    assign_query_info();
    $smarty->display('ayi_list.htm');
}


else if ($_REQUEST['act'] == 'info')

{
    /* 根据订单id或订单号查询订单信息 */
    if (isset($_REQUEST['id']))
    {
        $user_id= intval($_REQUEST['id']);
    }

    else
    {
        /* 如果参数不存在，退出 */
        die('invalid parameter');
    }


    $sql = "SELECT *, p.region_name as province_name,t.region_name as city_name, d.region_name as district_name FROM " . $GLOBALS['ecs']->table('ayi_users') ."as o ".
        "LEFT JOIN " . $ecs->table('region') . " AS p ON o.province = p.region_id " .
        "LEFT JOIN " . $ecs->table('region') . " AS t ON o.city = t.region_id " .
        "LEFT JOIN " . $ecs->table('region') . " AS d ON o.district = d.region_id " .
        " WHERE o.user_id = '$user_id'";
$ayiInfo= $GLOBALS['db']->getRow($sql);
    $ayiInfo['sex_value'] =getSexValue($ayiInfo['sex']);
    $ayiInfo['work_prefer_value'] =getWorkPreferValue($ayiInfo['work_prefer']);
    $ayiInfo['work_type_value'] =getWorkTypeValue($ayiInfo['work_type']);

    $ayiInfo['cash_deposit_value'] =getCashDepositValue($ayiInfo['cash_deposit']);
    $ayiInfo['validate_status_value'] =getValidateStatusValue($ayiInfo['validate_status']);



    $smarty->assign('ayiInfo', $ayiInfo);

    /* 取得能执行的操作列表 */
    $operable_list = ayi_operable_list($ayiInfo);
    $smarty->assign('operable_list', $operable_list);
        $smarty->display('ayi_info.htm');
}

/*------------------------------------------------------ */
//-- 翻页、搜索、排序
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'query')
{
    $list = get_comment_list();

    $smarty->assign('comment_list', $list['item']);
    $smarty->assign('filter',       $list['filter']);
    $smarty->assign('record_count', $list['record_count']);
    $smarty->assign('page_count',   $list['page_count']);

    $sort_flag  = sort_flag($list['filter']);
    $smarty->assign($sort_flag['tag'], $sort_flag['img']);

    make_json_result($smarty->fetch('comment_list.htm'), '',
        array('filter' => $list['filter'], 'page_count' => $list['page_count']));
}

elseif ($_REQUEST['act'] == 'operate') {
    $user_id = '';

    /* 取得订单id（可能是多个，多个sn）和操作备注（可能没有） */
    if (isset($_REQUEST['user_id'])) {
        $user_id= $_REQUEST['user_id'];
    }
    $status = 0;
    if (isset($_POST['pass'])) {
        $status = 1;
        $require_note = false;
        $action = '通过';
        $operation = 'pass';
    } else if (isset($_POST['refuse'])) {
        $status = 2;
    }
    $sql = "update " . $ecs->table('ayi_users') . " set validate_status = " . $status . " WHERE user_id= $user_id";
    $db->query($sql);
    return;

}

/**
 * 获取评论列表
 * @access  public
 * @return  array
 */
function get_ayi_list()
{
    /* 查询条件 */
    $filter['keywords']     = empty($_REQUEST['keywords']) ? 0 : trim($_REQUEST['keywords']);
    if (isset($_REQUEST['is_ajax']) && $_REQUEST['is_ajax'] == 1)
    {
        $filter['keywords'] = json_str_iconv($filter['keywords']);
    }
    $filter['sort_by']      = empty($_REQUEST['sort_by']) ? 'reg_time' : trim($_REQUEST['sort_by']);
    $filter['sort_order']   = empty($_REQUEST['sort_order']) ? 'DESC' : trim($_REQUEST['sort_order']);

    $where = (!empty($filter['keywords'])) ? " AND real_name LIKE '%" . mysql_like_quote($filter['keywords']) . "%' " : '';
    if ($where == '') {
        $sql = "SELECT count(*) FROM " .$GLOBALS['ecs']->table('ayi_users');
    } else {
        $sql = "SELECT count(*) FROM " .$GLOBALS['ecs']->table('ayi_users'). " WHERE  $where";
    }
    $filter['record_count'] = $GLOBALS['db']->getOne($sql);

    /* 分页大小 */
    $filter = page_and_size($filter);

    /* 获取评论数据 */
    $arr = array();
    if ($where == '') {
        $sql  = "SELECT * FROM " .$GLOBALS['ecs']->table('ayi_users'). " ORDER BY $filter[sort_by] $filter[sort_order] ".
            " LIMIT ". $filter['start'] .", $filter[page_size]";
    } else {
        $sql  = "SELECT * FROM " .$GLOBALS['ecs']->table('ayi_users'). " WHERE  $where " .
            " ORDER BY $filter[sort_by] $filter[sort_order] ".
            " LIMIT ". $filter['start'] .", $filter[page_size]";
    }
    $res  = $GLOBALS['db']->query($sql);

    while ($row = $GLOBALS['db']->fetchRow($res))
    {
        $row['reg_time'] = local_date($GLOBALS['_CFG']['time_format'], $row['reg_time']);

        $row['validate_status_value'] = getValidateStatusValue( $row['validate_status']);

        $arr[] = $row;
    }
    $filter['keywords'] = stripslashes($filter['keywords']);
    $arr = array('item' => $arr, 'filter' => $filter, 'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']);

    return $arr;
}

?>