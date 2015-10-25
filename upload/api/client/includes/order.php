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

    $res = array();
    $res['MessageCode'] = 200;
    $res['list'] = get_user_orders($user_id, 1, 0, $order_id);
    show_json($GLOBALS['json'], $res, true);
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
?>
