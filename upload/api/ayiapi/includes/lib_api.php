<?php

function dispatch($post)
{
    if (function_exists('API_' . $post['Action'])) {
        return call_user_func('API_' . $post['Action'], $post);
    } else {
        API_Error();
    }
}

function parse_json(&$json, $str)
{
    if (defined('EC_CHARSET') && EC_CHARSET == 'gbk') {
        $str = addslashes(stripslashes(ecs_iconv('utf-8', 'gbk', $str)));
    }
    $json_obj = $json->decode($str, 1);
    $_POST = $json_obj;
}

function show_json(&$json, $array, $convert = false)
{
    $json_str = $json->encode($array, false);
    if (!$convert && defined('EC_CHARSET') && EC_CHARSET == 'gbk') {
        $json_str = ecs_iconv('UTF-8', 'GBK', $json_str);
    }
    @header('Content-type:text/html; charset=' . EC_CHARSET);
    exit($json_str);
}

function admin_privilege($priv_str)
{
    if (isset($_SESSION['admin_id']) && intval($_SESSION['admin_id']) > 0) {
        if ($_SESSION['action_list'] == 'all') {
            return true;
        }
        if (strpos(',' . $_SESSION['action_list'] . ',', ',' . $priv_str . ',') !== false) {
            return true;
        }
    }
    client_show_message(101);
}

/**
 * 用户登录函数
 * 验证登录，设置COOKIE
 *
 * @param array $post
 */
function API_UserLogin($post)
{

    $post['mobile'] = isset($post['mobile']) ? trim($post['mobile']) : '';
    $post['password'] = isset($post['password']) ? strtolower(trim($post['password'])) : '';

    /* 检查密码是否正确 */
    $sql = "SELECT * " .
        " FROM " . $GLOBALS['ecs']->table('ayi_users') .
        " WHERE mobile = '" . $post['mobile'] . "' and password='".$post['password']."'";
    $row = $GLOBALS['db']->getRow($sql);
    if ($row) {
        // 更新最后登录时间和IP
        $GLOBALS['db']->query("UPDATE " . $GLOBALS['ecs']->table('ayi_users') .
            " SET last_login_time='" . gmtime() . "'  WHERE user_id='".$row['user_id']."'");
        client_show_message(200, true, "登录成功", $row['user_id'], true, EC_CHARSET);

        if ($row['password'] != $post['password']) {
            client_show_message(103);
        }
        require_once(ROOT_PATH . ADMIN_PATH . '/includes/lib_main.php');
        // 登录成功
        //set_admin_session($row['user_id'], $row['user_name'], $row['action_list'], $row['last_login']);

    } else {
        client_show_message(103);
    }
}

/**
 * 用户注册
 *
 * @param array $post
 */
function API_UserRegister($post)
{
    /* 检查是否注册过 */
    $sql = "SELECT user_id, user_name, password,  last_login_time" .
        " FROM " . $GLOBALS['ecs']->table('ayi_users') .
        " WHERE mobile = '" . $post['mobile'] . "'";

    $row = $GLOBALS['db']->getRow($sql);

    if ($row) {
        client_show_message(502, false, "手机号已经注册过", $row['user_id'], true, EC_CHARSET);
    } else {
        $post['reg_time'] = time();
        $post['validate_status']= 0;

        $GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('ayi_users'), $post, 'INSERT');

        $sql = "SELECT user_id" .
            " FROM " . $GLOBALS['ecs']->table('ayi_users') .
            " WHERE mobile = '" . $post['mobile'] . "'";
        $row = $GLOBALS['db']->getRow($sql);
        client_show_message(200, true, "注册成功", $row['user_id'], true, EC_CHARSET);
    }
    echo 'API_UserRegisterend';
}

/**
 * @param $post 取订单
 */
function API_GetOrder($post) {
    $sqlPlus = '';
    if (isset($post['type'])) {
        $cat=1;
        switch($post['type']) {
            case '1':
                $cat=16;
                break;
            case '2':
                $cat=26;
                break;
            case '3':
                $cat=27;
                break;
            case '4':
                $cat=28;
                break;
        }
        $sqlPlus = ' and cat_id='.$cat;
    }
    $sql = "SELECT distinct x.order_id, x.order_sn, x.order_status, x.shipping_status, x.pay_status, x.add_time,
    x.province,x.city,x.district,x.address,x.consignee, y.goods_name , r1.region_name as province_name,
    r2.region_name as city_name,r3.region_name as district_name,goods_amount".
        " FROM " .$GLOBALS['ecs']->table('order_info') . " as x," .$GLOBALS['ecs']->table('order_goods') . " as y,
           " .$GLOBALS['ecs']->table('region')."as r1, ".$GLOBALS['ecs']->table('region')." as r2,".$GLOBALS['ecs']->table('region')." as r3
            WHERE r1.region_id=province and r2.region_id=city and r3.region_id=district  and y.order_id = x.order_id and  order_status=8 ".$sqlPlus." ORDER BY add_time DESC";

    $res= $GLOBALS['db']->getAll($sql);
    $result = array();
    $result['MessageCode'] = 200;
    $result['list'] = $res;
    show_json($GLOBALS['json'], $result, true);
}

/**
 * @param $post 我的订单
 */
function API_GetMyOrder($post) {
    $sqlPlus = '';
    if (!(isset($post['user_id']))) {
        client_show_message(401, true, "参数错误", 0, true, EC_CHARSET);
    }
    if (isset($post['status'])) {
        $sqlPlus = ' and order_status='.$post['status'];
    }
    $sql = "SELECT distinct x.order_id, x.order_sn, x.order_status, x.shipping_status, x.pay_status, x.add_time,
    x.province,x.city,x.district,x.address,x.consignee, y.goods_name , r1.region_name as province_name,x.first_service_time,
    r2.region_name as city_name,r3.region_name as district_name,goods_amount".
        " FROM " .$GLOBALS['ecs']->table('order_info') . " as x," .$GLOBALS['ecs']->table('order_goods') . " as y,
           " .$GLOBALS['ecs']->table('region')."as r1, ".$GLOBALS['ecs']->table('region')." as r2,".$GLOBALS['ecs']->table('region')." as r3
            WHERE r1.region_id=province and r2.region_id=city and r3.region_id=district
              and y.order_id = x.order_id and ayi_id=".$post['user_id'].$sqlPlus." ORDER BY add_time DESC";

    $res= $GLOBALS['db']->getAll($sql);
    $result = array();
    $result['MessageCode'] = 200;
    $result['list'] = $res;
    show_json($GLOBALS['json'], $result, true);
}

function API_OrderStatusMod($post) {
    if (!(isset($post['order_id']) && isset($post['order_status']))) {
        client_show_message(401, true, "参数错误", 0, true, EC_CHARSET);
    }
    $arr = array(
        'order_status'  => $post['order_status']
    );
    update_order($post['order_id'], $arr);
    client_show_message(200, true, "修改订单成功", 0, true, EC_CHARSET);
}

/**阿姨认证状态获取
 * @param $post
 */
function API_GetAyiStatus($post) {
    if (!isset($post['user_id'])) {
        client_show_message(401, true, "参数错误", 0, true, EC_CHARSET);
    }
    $sql = "SELECT validate_status" .
        " FROM " . $GLOBALS['ecs']->table('ayi_users') .
        " WHERE user_id= '" . $post['user_id'] . "'";

    $row = $GLOBALS['db']->getRow($sql);
    $result = array();
    $result['MessageCode'] = 200;
    $result['data'] = $row['validate_status'];
    show_json($GLOBALS['json'], $result, true);
}

/**订单详情
 * @param $post
 */
function API_OrderDetail($post) {
    if (!(isset($post['order_id']))) {
        client_show_message(401, true, "参数错误", 0, true, EC_CHARSET);
    }
    $order_id= $post['order_id'];
    $res = array();
    $res['MessageCode'] = 200;
    $res['data'] = get_orders_detail($order_id);
    show_json($GLOBALS['json'], $res, true);
}

/**
 * 抢单
 */
function API_RobOrder($post) {
    if (!(isset($post['order_id']) && isset($post['user_id']))) {
        client_show_message(401, true, "参数错误", 0, true, EC_CHARSET);
    }
    $sql = "select ayi_id from " .$GLOBALS['ecs']->table('order_info') . " as x where x.order_id=".$post['order_id'];
    $row = $GLOBALS['db']->getRow($sql);
    if ($row['ayi_id']!=0) {
        client_show_message(402, true, "该订单已被抢走", 0, true, EC_CHARSET);
    }
    $sql = "update " .$GLOBALS['ecs']->table('order_info') . " as x set order_status=16,ayi_id =".$post['user_id']."
    where x.order_id=".$post['order_id'];
    $GLOBALS['db']->query($sql);
    client_show_message(200, true, "抢单成功", 0, true, EC_CHARSET);
}

function get_orders_detail($order_id) {
        /* 取得订单列表 */
        $arr    = array();
        $sql_plus ='';
        if (isset($order_id)) {
            $sql_plus =' and x.order_id='.$order_id;
        }

        $sql = "SELECT x.order_id, x.order_sn, x.order_status , x.add_time,
    x.province,x.city,x.district,x.address,x.consignee, y.goods_name ,y.goods_number,x.goods_amount ,mobile,postscript as leaveword,
    first_service_time,pay_type,r1.region_name as province_name,r2.region_name as city_name,r3.region_name as district_name".
            " FROM " .$GLOBALS['ecs']->table('order_info') . " as x," .$GLOBALS['ecs']->table('order_goods') . " as y,
           " .$GLOBALS['ecs']->table('region')."as r1, ".$GLOBALS['ecs']->table('region')." as r2,".$GLOBALS['ecs']->table('region')." as r3
            WHERE  r1.region_id=province and r2.region_id=city and r3.region_id=district ".$sql_plus;
        $row = $GLOBALS['db']->getRow($sql);
        return $row;
}
/**
 * 出错函数
 *
 */
function API_Error()
{
    client_show_message(102);
}

/**
 * 输出信息到客户端
 *
 * @param int $code 错误代号
 * @param boolean $result 返回结果
 * @param string $msg 错误信息
 * @param int $id 返回值
 */
function client_show_message($code = 0, $result = false, $message = '', $id = 0, $custom_message = false, $charset = '')
{
    $msg = $GLOBALS['common_message'];
    $msg['Result'] = $result;
    $msg['MessageCode'] = $code;
    $msg['MessageString'] = ($custom_message === false) ? $GLOBALS['_ALANG'][$code] . $message : $message;
    $msg['UserID'] = $id;
    $msg['Charset'] = $charset;
    show_json($GLOBALS['json'], $msg);
}
?>