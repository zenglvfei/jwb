<?php

include_once(ROOT_PATH . 'includes/lib_transaction.php');
function API_OrderList($post) {
    $user_id = isset($post['user_id']) ? trim($post['user_id']) : '';
    $page_size= isset($post['page_size']) ? intval($post['page_size']) : 10;
    $page_num= isset($post['page_num']) ? intval($post['page_num']) : 0;
    $res = array();
    $res['MessageCode'] = 200;
    $res['list'] = get_user_orders($user_id, $page_size, $page_num);
    show_json($GLOBALS['json'], $res, true);
}
function API_OrderDetail($post) {
    if (!(isset($post['user_id']) && isset($post['order_id']))) {
        client_show_message(401, true, "参数错误", 0, true, EC_CHARSET);
    }
    $user_id = $post['user_id'];
    $order_id= $post['order_id'];

    $sql = "SELECT distinct x.order_id, x.order_sn, x.order_status,  x.add_time,x.pay_status,
    x.province,x.city,x.district,x.address,x.consignee,x.pay_type, y.goods_name, y.goods_number, r1.region_name as province_name,x.first_service_time,
    r2.region_name as city_name,r3.region_name as district_name,goods_amount".
        " FROM " .$GLOBALS['ecs']->table('order_info') . " as x," .$GLOBALS['ecs']->table('order_goods') . " as y,
           " .$GLOBALS['ecs']->table('region')."as r1, ".$GLOBALS['ecs']->table('region')." as r2,".$GLOBALS['ecs']->table('region')." as r3
            WHERE r1.region_id=province and r2.region_id=city and r3.region_id=district
              and y.order_id = x.order_id and user_id=".$user_id." and x.order_id=".$order_id." ORDER BY add_time DESC";
    $res= $GLOBALS['db']->getRow($sql);
    $result = array();
    $result['MessageCode'] = 200;
    $result['data'] = $res;
    show_json($GLOBALS['json'], $result, true);
}

/**取消订单
 * @param $post
 */
function API_OrderCancel($post) {
    if (!(isset($post['user_id']) && isset($post['order_id']))) {
        client_show_message(401, true, "参数错误", 0, true, EC_CHARSET);
    }
    $user_id = $post['user_id'];
    $order_id= $post['order_id'];
    /* 查询订单信息，检查状态 */
    $sql = "SELECT user_id, order_id, order_sn , surplus , integral , bonus_id, order_status,
shipping_status, pay_status FROM " .$GLOBALS['ecs']->table('order_info') ." WHERE order_id = '$order_id'";
    $order = $GLOBALS['db']->getRow($sql);

    if (empty($order))
    {
        client_show_message(400, true, "订单不存在", 0, true, EC_CHARSET);
        return;
    }

    //将用户订单设置为取消
    $sql = "UPDATE ".$GLOBALS['ecs']->table('order_info') ." SET order_status = 6  WHERE order_id = '$order_id'";
    if ($GLOBALS['db']->query($sql))
    {
        /* 记录log */
        order_action($order['order_sn'], OS_CANCELED, $order['shipping_status'], PS_UNPAYED,$GLOBALS['_LANG']['buyer_cancel'],'buyer');
        /* 退货用户余额、积分、红包 */
        if ($order['user_id'] > 0 && $order['surplus'] > 0)
        {
            $change_desc = sprintf($GLOBALS['_LANG']['return_surplus_on_cancel'], $order['order_sn']);
            log_account_change($order['user_id'], $order['surplus'], 0, 0, 0, $change_desc);
        }
        if ($order['user_id'] > 0 && $order['integral'] > 0)
        {
            $change_desc = sprintf($GLOBALS['_LANG']['return_integral_on_cancel'], $order['order_sn']);
            log_account_change($order['user_id'], 0, 0, 0, $order['integral'], $change_desc);
        }
        if ($order['user_id'] > 0 && $order['bonus_id'] > 0)
        {
            change_user_bonus($order['bonus_id'], $order['order_id'], false);
        }

        /* 修改订单 */
        $arr = array(
            'bonus_id'  => 0,
            'bonus'     => 0,
            'integral'  => 0,
            'integral_money'    => 0,
            'surplus'   => 0
        );
        update_order($order['order_id'], $arr);
        client_show_message(200, true, "取消订单成功", 0, true, EC_CHARSET);
    }
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

function API_PayStatusMod($post) {
    if (!(isset($post['order_id']) && isset($post['pay_status']))) {
        client_show_message(401, true, "参数错误", 0, true, EC_CHARSET);
    }
    $arr = array(
        'pay_status'  => $post['pay_status']
    );
    $order_id = $post['order_id'];
	$pay_status = $post['pay_status'];
	
	$sql = 'UPDATE ' . $GLOBALS['ecs']->table('order_info') .
                            " SET " .
                                " pay_status = '$pay_status', " .
                                " pay_time = '".gmtime()."' " .
                       "WHERE order_id = '$order_id'";
    $GLOBALS['db']->query($sql);
	
    client_show_message(200, true, "修改支付状态成功", 0, true, EC_CHARSET);
}


function API_GetAyiList($post) {
    $sqlPlus = '';
    if (isset($post['work_prefer'])) {
        $sqlPlus = ' and work_prefer='.$post['work_prefer'];
    }
    $order_field =isset($post['order_field'])?$post['order_field']:'add_time';

    $sql = "SELECT `user_id`,`user_name`,`age`,`sex`,`home_town`,`province`,`city`,`district`,`detail_address`,
        `work_type`,`work_prefer`,`real_name`,`id_card_num`,`mobile`  FROM " .$GLOBALS['ecs']->table('ayi_users') . " as x
          WHERE validate_status=1 ".$sqlPlus." ORDER BY age DESC";

    $res= $GLOBALS['db']->getAll($sql);
    $result = array();
    $result['MessageCode'] = 200;
    $result['list'] = $res;
    show_json($GLOBALS['json'], $result, true);
}


function API_GetCurOrder($post) {
    $sqlPlus = '';
    if (!(isset($post['user_id']))) {
        client_show_message(401, true, "参数错误", 0, true, EC_CHARSET);
    }
    $sqlPlus = ' and (order_status!=64 and order_status!=70  and order_status!=6 and order_status!=80 )';
    $sql = "SELECT distinct x.order_id, x.order_sn, x.order_status,  x.add_time,
    x.province,x.city,x.district,x.address,x.consignee,x.pay_type, y.goods_name , r1.region_name as province_name,x.first_service_time,
    r2.region_name as city_name,r3.region_name as district_name,goods_amount".
        " FROM " .$GLOBALS['ecs']->table('order_info') . " as x," .$GLOBALS['ecs']->table('order_goods') . " as y,
           " .$GLOBALS['ecs']->table('region')."as r1, ".$GLOBALS['ecs']->table('region')." as r2,".$GLOBALS['ecs']->table('region')." as r3
            WHERE r1.region_id=province and r2.region_id=city and r3.region_id=district
              and y.order_id = x.order_id and user_id=".$post['user_id'].$sqlPlus." ORDER BY add_time DESC";

    $res= $GLOBALS['db']->getAll($sql);
    $result = array();
    $result['MessageCode'] = 200;
    $result['list'] = $res;
    show_json($GLOBALS['json'], $result, true);
}
function API_GetHistoryOrder($post) {
    $sqlPlus = '';
    if (!(isset($post['user_id']))) {
        client_show_message(401, true, "参数错误", 0, true, EC_CHARSET);
    }
    $sqlPlus = ' and (order_status=32  or order_status =80 )';
    $sql = "SELECT distinct x.order_id, x.order_sn, x.order_status, x.add_time,
    x.province,x.city,x.district,x.address,x.consignee,x.pay_type, y.goods_name , r1.region_name as province_name,x.first_service_time,
    r2.region_name as city_name,r3.region_name as district_name,goods_amount".
        " FROM " .$GLOBALS['ecs']->table('order_info') . " as x," .$GLOBALS['ecs']->table('order_goods') . " as y,
           " .$GLOBALS['ecs']->table('region')."as r1, ".$GLOBALS['ecs']->table('region')." as r2,".$GLOBALS['ecs']->table('region')." as r3
            WHERE r1.region_id=province and r2.region_id=city and r3.region_id=district
              and y.order_id = x.order_id and user_id=".$post['user_id'].$sqlPlus." ORDER BY add_time DESC";

    $res= $GLOBALS['db']->getAll($sql);
    $result = array();
    $result['MessageCode'] = 200;
    $result['list'] = $res;
    show_json($GLOBALS['json'], $result, true);
}

/**
 * 获得商品的详细信息
 *
 * @access  public
 * @param   integer     $goods_sn
 * @return  void
 */
function getGoodsInfo($goods_sn)
{
    $sql = 'SELECT g.goods_id, g.goods_sn, g.goods_name,g.shop_price '.
        'FROM ' . $GLOBALS['ecs']->table('goods') . ' AS g '.
        "WHERE g.goods_sn = '$goods_sn' AND g.is_delete = 0 " ;
    $row = $GLOBALS['db']->getRow($sql);

    if ($row !== false)
    {
        $row['shop_price_formated'] = price_format($row['shop_price']);

        return $row;
    }
    else
    {
        return false;
    }
}

/**
 * 获得商品的属性和规格
 *
 * @access  public
 * @param   integer $goods_id
 * @return  array
 */
function getGoodsProperties($goods_id)
{
    /* 对属性进行重新排序和分组 */
    $sql = "SELECT attr_group ".
        "FROM " . $GLOBALS['ecs']->table('goods_type') . " AS gt, " . $GLOBALS['ecs']->table('goods') . " AS g ".
        "WHERE g.goods_id='$goods_id' AND gt.cat_id=g.goods_type";
    $grp = $GLOBALS['db']->getOne($sql);

    if (!empty($grp))
    {
        $groups = explode("\n", strtr($grp, "\r", ''));
    }

    /* 获得商品的规格 */
    $sql = "SELECT a.attr_id, a.attr_name, a.attr_group, a.is_linked, a.attr_type, ".
        "g.goods_attr_id, g.attr_value, g.attr_price " .
        'FROM ' . $GLOBALS['ecs']->table('goods_attr') . ' AS g ' .
        'LEFT JOIN ' . $GLOBALS['ecs']->table('attribute') . ' AS a ON a.attr_id = g.attr_id ' .
        "WHERE g.goods_id= '$goods_id' " .
        'ORDER BY a.sort_order, g.attr_price, g.goods_attr_id';
    $res = $GLOBALS['db']->getAll($sql);

    $arr['spe'] = array();     // 规格

    foreach ($res AS $row)
    {
        $row['attr_value'] = str_replace("\n", '<br />', $row['attr_value']);

        if ($row['attr_type'] != 0)
        {
            $arr['spe'][$row['attr_id']]['attr_type'] = $row['attr_type'];
            $arr['spe'][$row['attr_id']]['name']     = $row['attr_name'];
            $arr['spe'][$row['attr_id']]['values'][] = array(
                'label'        => $row['attr_value'],
                'price'        => $row['attr_price'],
                'format_price' => price_format(abs($row['attr_price']), false),
                'id'           => $row['goods_attr_id']);
        }
    }

    return $arr['spe'];
}


function API_GetGoodsInfo($post) {
    if (!(isset($post['goodsid']))) {
        client_show_message(401, true, "参数错误", 0, true, EC_CHARSET);
    }
    $good_sn = $post['goodsid'];
    $result = array();
    $result['MessageCode'] = 200;
    $result['goodInfo'] = getGoodsInfo($good_sn);
    $result['goodAttr'] = getGoodsProperties($result['goodInfo']['goods_id']);
    show_json($GLOBALS['json'], $result, true);
}


function API_GetGoodsList($post) {
    if (!(isset($post['cat_id']))) {
        client_show_message(401, true, "参数错误", 0, true, EC_CHARSET);
    }
    $cat_id= $post['cat_id'];
    $sql = 'SELECT g.goods_id, g.goods_sn, g.goods_name,g.shop_price '.
        'FROM ' . $GLOBALS['ecs']->table('goods') . ' AS g '.
        "WHERE g.cat_id= '$cat_id' AND g.is_delete = 0 " ;
    $res = $GLOBALS['db']->getAll($sql);
    $result = array();
    $result['MessageCode'] = 200;
    $result['list'] = $res;
    show_json($GLOBALS['json'], $result, true);
}


function API_CollectAdd($post) {
    if (!isset($post['goodsid']) || !isset($post['user_id'])) {
        client_show_message(401, true, "参数错误", 0, true, EC_CHARSET);
    }
    $goodInfo = getGoodsInfo($post['goodsid']);

        /* 检查是否已经存在于用户的收藏夹 */
        $sql = "SELECT COUNT(*) FROM " .$GLOBALS['ecs']->table('collect_goods') .
            " WHERE user_id=".$post['user_id']." AND goods_id = '".$goodInfo['goods_id']."'";
        if ($GLOBALS['db']->GetOne($sql) > 0)
        {
            client_show_message(402, true, "您已经收藏过该服务", 0, true, EC_CHARSET);
        }
        else
        {
            $time = gmtime();
            $sql = "INSERT INTO " .$GLOBALS['ecs']->table('collect_goods'). " (user_id, goods_id, add_time)" .
                "VALUES (".$post['user_id'].", ".$goodInfo['goods_id'].", '$time')";

            if ($GLOBALS['db']->query($sql) === true)
            {
                client_show_message(200, true, "收藏成功", 0, true, EC_CHARSET);
            } else {

                client_show_message(403, true, "收藏失败", 0, true, EC_CHARSET);
            }
        }
}


function API_CollectList($post) {
    if (!isset($post['user_id'])) {
        client_show_message(401, true, "参数错误", 0, true, EC_CHARSET);
    }
    $user_id = $post['user_id'];

    include_once(ROOT_PATH . 'includes/lib_clips.php');

    $pageSize = isset($post['pageSize']) ? intval($post['pageSize']) : 10;
    $pageNum = isset($post['pageNum']) ? intval($post['pageNum']) : 1;
    $pageStart = ($pageNum -1) * $pageSize;

    $record_count = $GLOBALS['db']->getOne("SELECT COUNT(*) FROM " .$GLOBALS['ecs']->table('collect_goods').
        " WHERE user_id='$user_id' ORDER BY add_time DESC");

    $pageTotal = $record_count > 0 ? intval(ceil($record_count / $pageSize)) : 1;
    $goodsList = get_collection_goods($user_id, $pageSize, $pageStart);
    $result = array();
    $result['MessageCode'] = 200;
    $result['list'] = $goodsList;
    $result['pageSize'] = $pageSize;
    $result['pageNum'] = $pageNum;
    $result['pageTotal'] = $pageTotal;
    show_json($GLOBALS['json'], $result, true);
}

function API_CollectDel($post) {
    include_once(ROOT_PATH . 'includes/lib_clips.php');

    if (!isset($post['rec_id'])) {
        client_show_message(401, true, "参数错误", 0, true, EC_CHARSET);
    }

    $rec_id = intval($post['rec_id']);
    $sql = 'DELETE FROM ' .$GLOBALS['ecs']->table('collect_goods'). " WHERE rec_id=".$rec_id;
    if ($GLOBALS['db']->query($sql) == true) {
        client_show_message(200, true, "删除成功", 0, true, EC_CHARSET);
    } else {
        client_show_message(403, true, "删除失败", 0, true, EC_CHARSET);
    }
}

function API_GetUserInfo($post) {
    if (!isset($post['user_id'])) {
        client_show_message(401, true, "参数错误", 0, true, EC_CHARSET);
    }
    include_once(ROOT_PATH .'includes/lib_clips.php');
    $user_id = $post['user_id'];
    $info = get_user_default($user_id);
    $result = array();
    $result['MessageCode'] = 200;
    $result['surplus'] = $info['surplus'];
    $result['userName'] = $info['username'];
    $result['bonus'] = $info['bonus'];
    show_json($GLOBALS['json'], $result, true);
}

function API_DepositMoney($post){
    include_once(ROOT_PATH . 'includes/lib_clips.php');
    // include_once(ROOT_PATH . 'includes/lib_order.php');
    include_once(ROOT_PATH .'includes/lib_payment.php');
    if (!isset($post['user_id']) || !isset($post['amount'])) {
        client_show_message(401, true, "参数错误", 0, true, EC_CHARSET);
    }
    $user_id= $post['user_id'];
    $amount = floatval($post['amount']);
    /* 变量初始化 */
    $surplus = array(
        'user_id'      => $user_id,
        'rec_id'       => 0,
        'process_type' =>  0,
        'payment_id'   =>  0,
        'user_note'    => '',
        'amount'       => $amount
    );
    $sql = 'update ' .$GLOBALS['ecs']->table('users'). " set user_money=user_money+".$amount." WHERE  user_id=".$user_id;
    if ($GLOBALS['db']->query($sql) == true) {
      //插入会员账目明细
        insert_user_account($surplus, $amount);
        client_show_message(200, true, "成功", 0, true, EC_CHARSET);
    } else {
        client_show_message(200, true, "失败", 0, true, EC_CHARSET);
    }

}


function API_AddComment($post)
{

    if (!isset($post['user_id'])
        || !isset($post['order_id'])
    ) {

        client_show_message(401, true, "参数错误", 0, true, EC_CHARSET);
    }

    $quality_status= isset($post['quality_status']) ? intval($post['quality_status']) : 5;
    $attitude_status= isset($post['attitude_status']) ? intval($post['attitude_status']) : 5;
    $asset_status= isset($post['asset_status']) ? intval($post['asset_status']) : 5;
    $wear_status= isset($post['wear_status']) ? intval($post['wear_status']) : 5;
    $content= isset($post['content']) ? htmlspecialchars(trim($post['content'])) : '';


    /* 评论是否需要审核 */
    $status = 1;
    $user_id = $post['user_id'];
    $sql = 'select * from'.$GLOBALS['ecs']->table('users').'where user_id='.$user_id;
    $userInfo= $GLOBALS['db']->getRow($sql);


    $email = $userInfo['email'];
    $user_name = $userInfo['user_name'];
    $email = htmlspecialchars($email);
    $user_name = htmlspecialchars($user_name);
    $order_id = $post['order_id'];


    $sql = 'select * from'.$GLOBALS['ecs']->table('order_info').'where order_id='.$order_id;
    $orderInfo = $GLOBALS['db']->getRow($sql);


    /* 保存评论内容 */
    $sql = "INSERT INTO " .$GLOBALS['ecs']->table('comment') .
        "(comment_type, id_value, email, user_name, content, comment_rank, add_time, ip_address, status, parent_id,
        user_id,ayi_id,quality_status,attitude_status,asset_status,wear_status) VALUES " .
        "('0', '" .$order_id. "', '$email', '$user_name', '" .$content."', '5', ".gmtime().", '".real_ip()."', '$status'
        , '0', '$user_id',".$orderInfo['ayi_id'].",".$quality_status.",".$attitude_status.",".$asset_status.",".$wear_status.")";

    $result = $GLOBALS['db']->query($sql);
    if ($result) {
        client_show_message(200, true, "成功", 0, true, EC_CHARSET);
    } else {
        client_show_message(200, true, "失败", 0, true, EC_CHARSET);
    }
}


function API_GetCommentByAyi($post)
{
    if (!isset($post['ayi_id'])) {
        client_show_message(401, true, "参数错误", 0, true, EC_CHARSET);
    }
    $ayi_id = $post['ayi_id'];
    $pageSize = isset($post['pageSize']) ? intval($post['pageSize']) : 10;
    $pageNum = isset($post['pageNum']) ? intval($post['pageNum']) : 1;
    $pageStart = ($pageNum -1) * $pageSize;

    $record_count = $GLOBALS['db']->getOne("SELECT COUNT(*) FROM " .$GLOBALS['ecs']->table('comment').
        " WHERE ayi_id='$ayi_id' ORDER BY add_time DESC");

    $pageTotal = $record_count > 0 ? intval(ceil($record_count / $pageSize)) : 1;
    $commentList = get_new_comment_list($ayi_id, $pageSize, $pageStart,2);
    $result = array();
    $result['MessageCode'] = 200;
    $result['list'] = $commentList;
    $result['pageSize'] = $pageSize;
    $result['pageNum'] = $pageNum;
    $result['pageTotal'] = $pageTotal;
    show_json($GLOBALS['json'], $result, true);

}


function get_new_comment_list($id, $num = 10, $start = 0,$type=1)
{

    $str = 'id_value='.$id;
    // 按阿姨id查
    if ($type ==2) {
        $str = 'ayi_id='.$id;
    }

    $sql = "select * from ".$GLOBALS['ecs']->table('comment')."where ".$str;
    $res = $GLOBALS['db'] -> selectLimit($sql, $num, $start);
    $list = array();
    while ($row = $GLOBALS['db']->fetchRow($res))
    {
        $list[$row['comment_id']]['comment_id']        = $row['comment_id'];
        $list[$row['comment_id']]['content']      = $row['content'];
        $list[$row['comment_id']]['user_name']      = $row['user_name'];
        $list[$row['comment_id']]['add_time']    = $row['add_time'];
        $list[$row['comment_id']]['email']    = $row['email'];
        $list[$row['comment_id']]['user_id']    = $row['user_id'];
        $list[$row['comment_id']]['quality_status']    = $row['quality_status'];
        $list[$row['comment_id']]['attitude_status']    = $row['attitude_status'];
        $list[$row['comment_id']]['asset_status']    = $row['asset_status'];
        $list[$row['comment_id']]['wear_status']    = $row['wear_status'];
        $list[$row['comment_id']]['ayi_id']    = $row['ayi_id'];
    }

    return $list;
}

/**
 *  查看此商品是否已进行过缺货登记
 *
 * @access  public
 * @param   int     $user_id        用户ID
 * @param   int     $goods_id       商品ID
 *
 * @return  int
 */
function get_booking_rec($user_id, $goods_id)
{
    $sql = 'SELECT COUNT(*) '.
        'FROM ' .$GLOBALS['ecs']->table('booking_goods').
        "WHERE user_id = '$user_id' AND goods_id = '$goods_id' AND is_dispose = 0";

    return $GLOBALS['db']->getOne($sql);
}

/**
 *  获取指定用户的留言
 *
 * @access  public
 * @param   int     $user_id        用户ID
 * @param   int     $user_name      用户名
 * @param   int     $num            列表最大数量
 * @param   int     $start          列表其实位置
 * @return  array   $msg            留言及回复列表
 * @return  string  $order_id       订单ID
 */
function get_message_list($user_id, $user_name, $num, $start, $order_id = 0)
{
    /* 获取留言数据 */
    $msg = array();
    $sql = "SELECT * FROM " .$GLOBALS['ecs']->table('feedback');
    if ($order_id)
    {
        $sql .= " WHERE parent_id = 0 AND order_id = '$order_id' AND user_id = '$user_id' ORDER BY msg_time DESC";
    }
    else
    {
        $sql .= " WHERE parent_id = 0 AND user_id = '$user_id' AND user_name = '" . $_SESSION['user_name'] . "' AND order_id=0 ORDER BY msg_time DESC";
    }

    $res = $GLOBALS['db']->SelectLimit($sql, $num, $start);

    while ($rows = $GLOBALS['db']->fetchRow($res))
    {
        /* 取得留言的回复 */
        //if (empty($order_id))
        //{
        $reply = array();
        $sql   = "SELECT user_name, user_email, msg_time, msg_content".
            " FROM " .$GLOBALS['ecs']->table('feedback') .
            " WHERE parent_id = '" . $rows['msg_id'] . "'";
        $reply = $GLOBALS['db']->getRow($sql);

        if ($reply)
        {
            $msg[$rows['msg_id']]['re_user_name']   = $reply['user_name'];
            $msg[$rows['msg_id']]['re_user_email']  = $reply['user_email'];
            $msg[$rows['msg_id']]['re_msg_time']    = local_date($GLOBALS['_CFG']['time_format'], $reply['msg_time']);
            $msg[$rows['msg_id']]['re_msg_content'] = nl2br(htmlspecialchars($reply['msg_content']));
        }
        //}

        $msg[$rows['msg_id']]['msg_content'] = nl2br(htmlspecialchars($rows['msg_content']));
        $msg[$rows['msg_id']]['msg_time']    = local_date($GLOBALS['_CFG']['time_format'], $rows['msg_time']);
        $msg[$rows['msg_id']]['msg_type']    = $order_id ? $rows['user_name'] : $GLOBALS['_LANG']['type'][$rows['msg_type']];
        $msg[$rows['msg_id']]['msg_title']   = nl2br(htmlspecialchars($rows['msg_title']));
        $msg[$rows['msg_id']]['message_img'] = $rows['message_img'];
        $msg[$rows['msg_id']]['order_id'] = $rows['order_id'];
    }

    return $msg;
}

/**
 *  添加留言函数
 *
 * @access  public
 * @param   array       $message
 *
 * @return  boolen      $bool
 */
function add_message($message)
{
    $upload_size_limit = $GLOBALS['_CFG']['upload_size_limit'] == '-1' ? ini_get('upload_max_filesize') : $GLOBALS['_CFG']['upload_size_limit'];
    $status = 1 - $GLOBALS['_CFG']['message_check'];

    $last_char = strtolower($upload_size_limit{strlen($upload_size_limit)-1});

    switch ($last_char)
    {
        case 'm':
            $upload_size_limit *= 1024*1024;
            break;
        case 'k':
            $upload_size_limit *= 1024;
            break;
    }

    if ($message['upload'])
    {
        if($_FILES['message_img']['size'] / 1024 > $upload_size_limit)
        {
            $GLOBALS['err']->add(sprintf($GLOBALS['_LANG']['upload_file_limit'], $upload_size_limit));
            return false;
        }
        $img_name = upload_file($_FILES['message_img'], 'feedbackimg');

        if ($img_name === false)
        {
            return false;
        }
    }
    else
    {
        $img_name = '';
    }

    if (empty($message['msg_title']))
    {
        $GLOBALS['err']->add($GLOBALS['_LANG']['msg_title_empty']);

        return false;
    }

    $message['msg_area'] = isset($message['msg_area']) ? intval($message['msg_area']) : 0;
    $sql = "INSERT INTO " . $GLOBALS['ecs']->table('feedback') .
        " (msg_id, parent_id, user_id, user_name, user_email, msg_title, msg_type, msg_status,  msg_content, msg_time, message_img, order_id, msg_area)".
        " VALUES (NULL, 0, '$message[user_id]', '$message[user_name]', '$message[user_email]', ".
        " '$message[msg_title]', '$message[msg_type]', '$status', '$message[msg_content]', '".gmtime()."', '$img_name', '$message[order_id]', '$message[msg_area]')";
    $GLOBALS['db']->query($sql);

    return true;
}

/**
 *  获取用户的tags
 *
 * @access  public
 * @param   int         $user_id        用户ID
 *
 * @return array        $arr            tags列表
 */
function get_user_tags($user_id = 0)
{
    if (empty($user_id))
    {
        $GLOBALS['error_no'] = 1;

        return false;
    }

    $tags = get_tags(0, $user_id);

    if (!empty($tags))
    {
        color_tag($tags);
    }

    return $tags;
}

/**
 *  验证性的删除某个tag
 *
 * @access  public
 * @param   int         $tag_words      tag的ID
 * @param   int         $user_id        用户的ID
 *
 * @return  boolen      bool
 */
function delete_tag($tag_words, $user_id)
{
    $sql = "DELETE FROM ".$GLOBALS['ecs']->table('tag').
        " WHERE tag_words = '$tag_words' AND user_id = '$user_id'";

    return $GLOBALS['db']->query($sql);
}

/**
 *  获取某用户的缺货登记列表
 *
 * @access  public
 * @param   int     $user_id        用户ID
 * @param   int     $num            列表最大数量
 * @param   int     $start          列表其实位置
 *
 * @return  array   $booking
 */
function get_booking_list($user_id, $num, $start)
{
    $booking = array();
    $sql = "SELECT bg.rec_id, bg.goods_id, bg.goods_number, bg.booking_time, bg.dispose_note, g.goods_name ".
        "FROM " .$GLOBALS['ecs']->table('booking_goods')." AS bg , " .$GLOBALS['ecs']->table('goods')." AS g". " WHERE bg.goods_id = g.goods_id AND bg.user_id = '$user_id' ORDER BY bg.booking_time DESC";
    $res = $GLOBALS['db']->SelectLimit($sql, $num, $start);

    while ($row = $GLOBALS['db']->fetchRow($res))
    {
        if (empty($row['dispose_note']))
        {
            $row['dispose_note'] = 'N/A';
        }
        $booking[] = array('rec_id'       => $row['rec_id'],
            'goods_name'   => $row['goods_name'],
            'goods_number' => $row['goods_number'],
            'booking_time' => local_date($GLOBALS['_CFG']['date_format'], $row['booking_time']),
            'dispose_note' => $row['dispose_note'],
            'url'          => build_uri('goods', array('gid'=>$row['goods_id']), $row['goods_name']));
    }

    return $booking;
}

/**
 *  获取某用户的缺货登记列表
 *
 * @access  public
 * @param   int     $goods_id    商品ID
 *
 * @return  array   $info
 */
function get_goodsinfo($goods_id)
{
    $info = array();
    $sql  = "SELECT goods_name FROM " .$GLOBALS['ecs']->table('goods'). " WHERE goods_id = '$goods_id'";

    $info['goods_name']   = $GLOBALS['db']->getOne($sql);
    $info['goods_number'] = 1;
    $info['id']           = $goods_id;

    if (!empty($_SESSION['user_id']))
    {
        $row = array();
        $sql = "SELECT ua.consignee, ua.email, ua.tel, ua.mobile ".
            "FROM ".$GLOBALS['ecs']->table('user_address')." AS ua, ".$GLOBALS['ecs']->table('users')." AS u".
            " WHERE u.address_id = ua.address_id AND u.user_id = '$_SESSION[user_id]'";
        $row = $GLOBALS['db']->getRow($sql) ;
        $info['consignee'] = empty($row['consignee']) ? '' : $row['consignee'];
        $info['email']     = empty($row['email'])     ? '' : $row['email'];
        $info['tel']       = empty($row['mobile'])    ? (empty($row['tel']) ? '' : $row['tel']) : $row['mobile'];
    }

    return $info;
}

/**
 *  验证删除某个收藏商品
 *
 * @access  public
 * @param   int         $booking_id     缺货登记的ID
 * @param   int         $user_id        会员的ID
 * @return  boolen      $bool
 */
function delete_booking($booking_id, $user_id)
{
    $sql = 'DELETE FROM ' .$GLOBALS['ecs']->table('booking_goods').
        " WHERE rec_id = '$booking_id' AND user_id = '$user_id'";

    return $GLOBALS['db']->query($sql);
}

/**
 * 添加缺货登记记录到数据表
 * @access  public
 * @param   array $booking
 *
 * @return void
 */
function add_booking($booking)
{
    $sql = "INSERT INTO " .$GLOBALS['ecs']->table('booking_goods').
        " VALUES ('', '$_SESSION[user_id]', '$booking[email]', '$booking[linkman]', ".
        "'$booking[tel]', '$booking[goods_id]', '$booking[desc]', ".
        "'$booking[goods_amount]', '".gmtime()."', 0, '', 0, '')";
    $GLOBALS['db']->query($sql) or die ($GLOBALS['db']->errorMsg());

    return $GLOBALS['db']->insert_id();
}

/**
 * 插入会员账目明细
 *
 * @access  public
 * @param   array     $surplus  会员余额信息
 * @param   string    $amount   余额
 *
 * @return  int
 */
function insert_user_account($surplus, $amount)
{
    $sql = 'INSERT INTO ' .$GLOBALS['ecs']->table('user_account').
        ' (user_id, admin_user, amount, add_time, paid_time, admin_note, user_note, process_type, payment, is_paid)'.
        " VALUES ('$surplus[user_id]', '', '$amount', '".gmtime()."', 0, '', '$surplus[user_note]', '$surplus[process_type]', '$surplus[payment]', 0)";
    $GLOBALS['db']->query($sql);

    return $GLOBALS['db']->insert_id();
}

/**
 * 更新会员账目明细
 *
 * @access  public
 * @param   array     $surplus  会员余额信息
 *
 * @return  int
 */
function update_user_account($surplus)
{
    $sql = 'UPDATE ' .$GLOBALS['ecs']->table('user_account'). ' SET '.
        "amount     = '$surplus[amount]', ".
        "user_note  = '$surplus[user_note]', ".
        "payment    = '$surplus[payment]' ".
        "WHERE id   = '$surplus[rec_id]'";
    $GLOBALS['db']->query($sql);

    return $surplus['rec_id'];
}

/**
 * 将支付LOG插入数据表
 *
 * @access  public
 * @param   integer     $id         订单编号
 * @param   float       $amount     订单金额
 * @param   integer     $type       支付类型
 * @param   integer     $is_paid    是否已支付
 *
 * @return  int
 */
function insert_pay_log($id, $amount, $type = PAY_SURPLUS, $is_paid = 0)
{
    $sql = 'INSERT INTO ' .$GLOBALS['ecs']->table('pay_log')." (order_id, order_amount, order_type, is_paid)".
        " VALUES  ('$id', '$amount', '$type', '$is_paid')";
    $GLOBALS['db']->query($sql);

    return $GLOBALS['db']->insert_id();
}

/**
 * 取得上次未支付的pay_lig_id
 *
 * @access  public
 * @param   array     $surplus_id  余额记录的ID
 * @param   array     $pay_type    支付的类型：预付款/订单支付
 *
 * @return  int
 */
function get_paylog_id($surplus_id, $pay_type = PAY_SURPLUS)
{
    $sql = 'SELECT log_id FROM' .$GLOBALS['ecs']->table('pay_log').
        " WHERE order_id = '$surplus_id' AND order_type = '$pay_type' AND is_paid = 0";

    return $GLOBALS['db']->getOne($sql);
}

/**
 * 根据ID获取当前余额操作信息
 *
 * @access  public
 * @param   int     $surplus_id  会员余额的ID
 *
 * @return  int
 */
function get_surplus_info($surplus_id)
{
    $sql = 'SELECT * FROM ' .$GLOBALS['ecs']->table('user_account').
        " WHERE id = '$surplus_id'";

    return $GLOBALS['db']->getRow($sql);
}

/**
 * 取得已安装的支付方式(其中不包括线下支付的)
 * @param   bool    $include_balance    是否包含余额支付（冲值时不应包括）
 * @return  array   已安装的配送方式列表
 */
function get_online_payment_list($include_balance = true)
{
    $sql = 'SELECT pay_id, pay_code, pay_name, pay_fee, pay_desc ' .
        'FROM ' . $GLOBALS['ecs']->table('payment') .
        " WHERE enabled = 1 AND is_cod <> 1";
    if (!$include_balance)
    {
        $sql .= " AND pay_code <> 'balance' ";
    }

    $modules = $GLOBALS['db']->getAll($sql);

    include_once(ROOT_PATH.'includes/lib_compositor.php');

    return $modules;
}

/**
 * 查询会员余额的操作记录
 *
 * @access  public
 * @param   int     $user_id    会员ID
 * @param   int     $num        每页显示数量
 * @param   int     $start      开始显示的条数
 * @return  array
 */
function get_account_log($user_id, $num, $start)
{
    $account_log = array();
    $sql = 'SELECT * FROM ' .$GLOBALS['ecs']->table('user_account').
        " WHERE user_id = '$user_id'" .
        " AND process_type " . db_create_in(array(SURPLUS_SAVE, SURPLUS_RETURN)) .
        " ORDER BY add_time DESC";
    $res = $GLOBALS['db']->selectLimit($sql, $num, $start);

    if ($res)
    {
        while ($rows = $GLOBALS['db']->fetchRow($res))
        {
            $rows['add_time']         = local_date($GLOBALS['_CFG']['date_format'], $rows['add_time']);
            $rows['admin_note']       = nl2br(htmlspecialchars($rows['admin_note']));
            $rows['short_admin_note'] = ($rows['admin_note'] > '') ? sub_str($rows['admin_note'], 30) : 'N/A';
            $rows['user_note']        = nl2br(htmlspecialchars($rows['user_note']));
            $rows['short_user_note']  = ($rows['user_note'] > '') ? sub_str($rows['user_note'], 30) : 'N/A';
            $rows['pay_status']       = ($rows['is_paid'] == 0) ? $GLOBALS['_LANG']['un_confirm'] : $GLOBALS['_LANG']['is_confirm'];
            $rows['amount']           = price_format(abs($rows['amount']), false);

            /* 会员的操作类型： 冲值，提现 */
            if ($rows['process_type'] == 0)
            {
                $rows['type'] = $GLOBALS['_LANG']['surplus_type_0'];
            }
            else
            {
                $rows['type'] = $GLOBALS['_LANG']['surplus_type_1'];
            }

            /* 支付方式的ID */
            $sql = 'SELECT pay_id FROM ' .$GLOBALS['ecs']->table('payment').
                " WHERE pay_name = '$rows[payment]' AND enabled = 1";
            $pid = $GLOBALS['db']->getOne($sql);

            /* 如果是预付款而且还没有付款, 允许付款 */
            if (($rows['is_paid'] == 0) && ($rows['process_type'] == 0))
            {
                $rows['handle'] = '<a href="user.php?act=pay&id='.$rows['id'].'&pid='.$pid.'">'.$GLOBALS['_LANG']['pay'].'</a>';
            }

            $account_log[] = $rows;
        }

        return $account_log;
    }
    else
    {
        return false;
    }
}

/**
 *  删除未确认的会员帐目信息
 *
 * @access  public
 * @param   int         $rec_id     会员余额记录的ID
 * @param   int         $user_id    会员的ID
 * @return  boolen
 */
function del_user_account($rec_id, $user_id)
{
    $sql = 'DELETE FROM ' .$GLOBALS['ecs']->table('user_account').
        " WHERE is_paid = 0 AND id = '$rec_id' AND user_id = '$user_id'";

    return $GLOBALS['db']->query($sql);
}

/**
 * 查询会员余额的数量
 * @access  public
 * @param   int     $user_id        会员ID
 * @return  int
 */
function get_user_surplus($user_id)
{
    $sql = "SELECT SUM(user_money) FROM " .$GLOBALS['ecs']->table('account_log').
        " WHERE user_id = '$user_id'";

    return $GLOBALS['db']->getOne($sql);
}

/**
 * 获取用户中心默认页面所需的数据
 *
 * @access  public
 * @param   int         $user_id            用户ID
 *
 * @return  array       $info               默认页面所需资料数组
 */
function get_user_default($user_id)
{
    $user_bonus = get_user_bonus();

    $sql = "SELECT pay_points, user_money, credit_line, last_login, is_validated FROM " .$GLOBALS['ecs']->table('users'). " WHERE user_id = '$user_id'";
    $row = $GLOBALS['db']->getRow($sql);
    $info = array();
    $info['username']  = stripslashes($_SESSION['user_name']);
    $info['shop_name'] = $GLOBALS['_CFG']['shop_name'];
    $info['integral']  = $row['pay_points'] . $GLOBALS['_CFG']['integral_name'];
    /* 增加是否开启会员邮件验证开关 */
    $info['is_validate'] = ($GLOBALS['_CFG']['member_email_validate'] && !$row['is_validated'])?0:1;
    $info['credit_line'] = $row['credit_line'];
    $info['formated_credit_line'] = price_format($info['credit_line'], false);

    //如果$_SESSION中时间无效说明用户是第一次登录。取当前登录时间。
    /*    $last_time = !isset($_SESSION['last_time']) ? $row['last_login'] : $_SESSION['last_time'];

        if ($last_time == 0)
        {
            $_SESSION['last_time'] = $last_time = gmtime();
        }

        $info['last_time'] = local_date($GLOBALS['_CFG']['time_format'], $last_time);*/
    $info['surplus']   = price_format($row['user_money'], false);
    $info['bonus']     = sprintf($GLOBALS['_LANG']['user_bonus_info'], $user_bonus['bonus_count'], price_format($user_bonus['bonus_value'], false));

    $sql = "SELECT COUNT(*) FROM " .$GLOBALS['ecs']->table('order_info').
        " WHERE user_id = '" .$user_id. "' AND add_time > '" .local_strtotime('-1 months'). "'";
    $info['order_count'] = $GLOBALS['db']->getOne($sql);

    /*    include_once(ROOT_PATH . 'includes/lib_order.php');
        $sql = "SELECT order_id, order_sn ".
                " FROM " .$GLOBALS['ecs']->table('order_info').
                " WHERE user_id = '" .$user_id. "' AND shipping_time > '" .$last_time. "'". order_query_sql('shipped');
        $info['shipped_order'] = $GLOBALS['db']->getAll($sql);*/

    return $info;
}

/**
 * 添加商品标签
 *
 * @access  public
 * @param   integer     $id
 * @param   string      $tag
 * @return  void
 */
function add_tag($id, $tag)
{
    if (empty($tag))
    {
        return;
    }

    $arr = explode(',', $tag);

    foreach ($arr AS $val)
    {
        /* 检查是否重复 */
        $sql = "SELECT COUNT(*) FROM ". $GLOBALS['ecs']->table("tag").
            " WHERE user_id = '".$_SESSION['user_id']."' AND goods_id = '$id' AND tag_words = '$val'";

        if ($GLOBALS['db']->getOne($sql) == 0)
        {
            $sql = "INSERT INTO ".$GLOBALS['ecs']->table("tag")." (user_id, goods_id, tag_words) ".
                "VALUES ('".$_SESSION['user_id']."', '$id', '$val')";
            $GLOBALS['db']->query($sql);
        }
    }
}

/**
 * 标签着色
 *
 * @access   public
 * @param    array
 * @author   Xuan Yan
 *
 * @return   none
 */
function color_tag(&$tags)
{
    $tagmark = array(
        array('color'=>'#666666','size'=>'0.8em','ifbold'=>1),
        array('color'=>'#333333','size'=>'0.9em','ifbold'=>0),
        array('color'=>'#006699','size'=>'1.0em','ifbold'=>1),
        array('color'=>'#CC9900','size'=>'1.1em','ifbold'=>0),
        array('color'=>'#666633','size'=>'1.2em','ifbold'=>1),
        array('color'=>'#993300','size'=>'1.3em','ifbold'=>0),
        array('color'=>'#669933','size'=>'1.4em','ifbold'=>1),
        array('color'=>'#3366FF','size'=>'1.5em','ifbold'=>0),
        array('color'=>'#197B30','size'=>'1.6em','ifbold'=>1),
    );

    $maxlevel = count($tagmark);
    $tcount = $scount = array();

    foreach($tags AS $val)
    {
        $tcount[] = $val['tag_count']; // 获得tag个数数组
    }
    $tcount = array_unique($tcount); // 去除相同个数的tag

    sort($tcount); // 从小到大排序

    $tempcount = count($tcount); // 真正的tag级数
    $per = $maxlevel >= $tempcount ? 1 : $maxlevel / ($tempcount - 1);

    foreach ($tcount AS $key => $val)
    {
        $lvl = floor($per * $key);
        $scount[$val] = $lvl; // 计算不同个数的tag相对应的着色数组key
    }

    $rewrite = intval($GLOBALS['_CFG']['rewrite']) > 0;

    /* 遍历所有标签，根据引用次数设定字体大小 */
    foreach ($tags AS $key => $val)
    {
        $lvl = $scount[$val['tag_count']]; // 着色数组key

        $tags[$key]['color'] = $tagmark[$lvl]['color'];
        $tags[$key]['size']  = $tagmark[$lvl]['size'];
        $tags[$key]['bold']  = $tagmark[$lvl]['ifbold'];
        if ($rewrite)
        {
            if (strtolower(EC_CHARSET) !== 'utf-8')
            {
                $tags[$key]['url'] = 'tag-' . urlencode(urlencode($val['tag_words'])) . '.html';
            }
            else
            {
                $tags[$key]['url'] = 'tag-' . urlencode($val['tag_words']) . '.html';
            }
        }
        else
        {
            $tags[$key]['url'] = 'search.php?keywords=' . urlencode($val['tag_words']);
        }
    }
    shuffle($tags);
}

/**
 * 取得用户等级信息
 * @access   public
 * @author   Xuan Yan
 *
 * @return array
 */
function get_rank_info()
{
    global $db,$ecs;

    if (!empty($_SESSION['user_rank']))
    {
        $sql = "SELECT rank_name, special_rank FROM " . $ecs->table('user_rank') . " WHERE rank_id = '$_SESSION[user_rank]'";
        $row = $db->getRow($sql);
        if (empty($row))
        {
            return array();
        }
        $rank_name = $row['rank_name'];
        if ($row['special_rank'])
        {
            return array('rank_name'=>$rank_name);
        }
        else
        {
            $user_rank = $db->getOne("SELECT rank_points FROM " . $ecs->table('users') . " WHERE user_id = '$_SESSION[user_id]'");
            $sql = "SELECT rank_name,min_points FROM " . $ecs->table('user_rank') . " WHERE min_points > '$user_rank' ORDER BY min_points ASC LIMIT 1";
            $rt  = $db->getRow($sql);
            $next_rank_name = $rt['rank_name'];
            $next_rank = $rt['min_points'] - $user_rank;
            return array('rank_name'=>$rank_name,'next_rank_name'=>$next_rank_name,'next_rank'=>$next_rank);
        }
    }
    else
    {
        return array();
    }
}

/**
 *  获取用户参与活动信息
 *
 * @access  public
 * @param   int     $user_id        用户id
 *
 * @return  array
 */
function get_user_prompt ($user_id)
{
    $prompt = array();
    $now = gmtime();
    /* 夺宝奇兵 */
    $sql = "SELECT act_id, goods_name, end_time " .
        "FROM " . $GLOBALS['ecs']->table('goods_activity') .
        " WHERE act_type = '" . GAT_SNATCH . "'" .
        " AND (is_finished = 1 OR (is_finished = 0 AND end_time <= '$now'))";
    $res = $GLOBALS['db']->query($sql);
    while ($row = $GLOBALS['db']->fetchRow($res))
    {
        $act_id = $row['act_id'];
        $result = get_snatch_result($act_id);
        if (isset($result['order_count']) && $result['order_count'] == 0 && $result['user_id'] == $user_id)
        {
            $prompt[] = array(
                'text'=>sprintf($GLOBALS['_LANG']['your_snatch'],$row['goods_name'], $row['act_id']),
                'add_time'=> $row['end_time']
            );
        }
        if (isset($auction['last_bid']) && $auction['last_bid']['bid_user'] == $user_id && $auction['order_count'] == 0)
        {
            $prompt[] = array(
                'text' => sprintf($GLOBALS['_LANG']['your_auction'], $row['goods_name'], $row['act_id']),
                'add_time' => $row['end_time']
            );
        }
    }


    /* 竞拍 */

    $sql = "SELECT act_id, goods_name, end_time " .
        "FROM " . $GLOBALS['ecs']->table('goods_activity') .
        " WHERE act_type = '" . GAT_AUCTION . "'" .
        " AND (is_finished = 1 OR (is_finished = 0 AND end_time <= '$now'))";
    $res = $GLOBALS['db']->query($sql);
    while ($row = $GLOBALS['db']->fetchRow($res))
    {
        $act_id = $row['act_id'];
        $auction = auction_info($act_id);
        if (isset($auction['last_bid']) && $auction['last_bid']['bid_user'] == $user_id && $auction['order_count'] == 0)
        {
            $prompt[] = array(
                'text' => sprintf($GLOBALS['_LANG']['your_auction'], $row['goods_name'], $row['act_id']),
                'add_time' => $row['end_time']
            );
        }
    }

    /* 排序 */
    $cmp = create_function('$a, $b', 'if($a["add_time"] == $b["add_time"]){return 0;};return $a["add_time"] < $b["add_time"] ? 1 : -1;');
    usort($prompt, $cmp);

    /* 格式化时间 */
    foreach ($prompt as $key => $val)
    {
        $prompt[$key]['formated_time'] = local_date($GLOBALS['_CFG']['time_format'], $val['add_time']);
    }

    return $prompt;
}

/**
 *  获取用户评论
 *
 * @access  public
 * @param   int     $user_id        用户id
 * @param   int     $page_size      列表最大数量
 * @param   int     $start          列表起始页
 * @return  array
 */
function get_comment_list($user_id, $page_size, $start)
{
    $sql = "SELECT c.*, g.goods_name AS cmt_name, r.content AS reply_content, r.add_time AS reply_time ".
        " FROM " . $GLOBALS['ecs']->table('comment') . " AS c ".
        " LEFT JOIN " . $GLOBALS['ecs']->table('comment') . " AS r ".
        " ON r.parent_id = c.comment_id AND r.parent_id > 0 ".
        " LEFT JOIN " . $GLOBALS['ecs']->table('goods') . " AS g ".
        " ON c.comment_type=0 AND c.id_value = g.goods_id ".
        " WHERE c.user_id='$user_id'";
    $res = $GLOBALS['db']->SelectLimit($sql, $page_size, $start);

    $comments = array();
    $to_article = array();
    while ($row = $GLOBALS['db']->fetchRow($res))
    {
        $row['formated_add_time'] = local_date($GLOBALS['_CFG']['time_format'], $row['add_time']);
        if ($row['reply_time'])
        {
            $row['formated_reply_time'] = local_date($GLOBALS['_CFG']['time_format'], $row['reply_time']);
        }
        if ($row['comment_type'] == 1)
        {
            $to_article[] = $row["id_value"];
        }
        $comments[] = $row;
    }

    if ($to_article)
    {
        $sql = "SELECT article_id , title FROM " . $GLOBALS['ecs']->table('article') . " WHERE " . db_create_in($to_article, 'article_id');
        $arr = $GLOBALS['db']->getAll($sql);
        $to_cmt_name = array();
        foreach ($arr as $row)
        {
            $to_cmt_name[$row['article_id']] = $row['title'];
        }

        foreach ($comments as $key=>$row)
        {
            if ($row['comment_type'] == 1)
            {
                $comments[$key]['cmt_name'] = isset($to_cmt_name[$row['id_value']]) ? $to_cmt_name[$row['id_value']] : '';
            }
        }
    }

    return $comments;
}


?>
