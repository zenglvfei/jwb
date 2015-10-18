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
        client_show_message(401, true, "参数错误", $user_id, true, EC_CHARSET);
    }
    $user_id = $post['user_id'];
    $order_id= $post['order_id'];

    $res = array();
    $res['MessageCode'] = 200;
    $res['list'] = get_user_orders($user_id, 1, 0, $order_id);
    show_json($GLOBALS['json'], $res, true);
}

?>
