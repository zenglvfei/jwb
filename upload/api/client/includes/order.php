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

    $sql = "SELECT distinct x.order_id, x.order_sn, x.order_status,  x.add_time,
    x.province,x.city,x.district,x.address,x.consignee, y.goods_name, y.goods_number, r1.region_name as province_name,x.first_service_time,
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
    $sql = "SELECT user_id, order_id, order_sn , surplus , integral , bonus_id, order_status, shipping_status, pay_status FROM " .$GLOBALS['ecs']->table('order_info') ." WHERE order_id = '$order_id'";
    $order = $GLOBALS['db']->GetRow($sql);

    if (empty($order))
    {
        client_show_message(400, true, "订单不存在", 0, true, EC_CHARSET);
        return;
    }

    //将用户订单设置为取消
    $sql = "UPDATE ".$GLOBALS['ecs']->table('order_info') ." SET order_status = '".OS_CANCELED."' WHERE order_id = '$order_id'";
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



function API_GetAyiList($post) {
    $sqlPlus = '';
    if (isset($post['work_prefer'])) {
        $sqlPlus = ' and work_prefer='.$post['work_prefer'];
    }
    $order_field =isset($post['order_field'])?$post['order_field']:'add_time';

    $sql = "SELECT `user_id`,`user_name`,`birthday`,`sex`,`home_town`,`province`,`city`,`district`,`detail_address`,
        `work_type`,`work_prefer`,`real_name`,`id_card_num`,`mobile`  FROM " .$GLOBALS['ecs']->table('ayi_users') . " as x
          WHERE validate_status=1 ".$sqlPlus." ORDER BY birthday DESC";

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
    $sqlPlus = ' and (order_status!=64 and order_status!=70  and order_status!=80 )';
    $sql = "SELECT distinct x.order_id, x.order_sn, x.order_status,  x.add_time,
    x.province,x.city,x.district,x.address,x.consignee, y.goods_name , r1.region_name as province_name,x.first_service_time,
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
    $sqlPlus = ' and (order_status=64 or order_status=70  or order_status =80 )';
    $sql = "SELECT distinct x.order_id, x.order_sn, x.order_status, x.add_time,
    x.province,x.city,x.district,x.address,x.consignee, y.goods_name , r1.region_name as province_name,x.first_service_time,
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
?>
