<?php

function API_OrderFrame($post) {

    $goods_sn = isset($post['goodsid']) ? trim($post['goodsid']) : '';

    switch ($goods_sn) {

        //小时工 30
        case '010101':

            $common = getCommonOrderInfo($post);
            $serviceTime = isset($post['servicetime']) ? trim($post['servicetime']) : '';
            $tip = isset($post['tip']) ? trim($post['tip']) : '';
            $price= isset($post['price']) ? intval(($post['price'])) : 0;

            //
            if ($tip == 1) {
                $good_attr_id = 241;
            } else if ($tip == 2) {
                $good_attr_id = 243;
                $attr_price = 30;

            } else if ($tip == 3) {
                $good_attr_id = 242;
            }
            $good_attr_name = get_goods_attr_info(Array($good_attr_id),'pice');
            $goods_amount =$price * $serviceTime + $attr_price;
            $order_amount = $goods_amount;


            doOrder($goods_sn, $serviceTime, $common['province'], $common['city'], $common['district'], $common['detailAddress'], $good_attr_id,
                $good_attr_name, $common['leaveword'],$common['firstServiceTime'], $common['uid'],
                $goods_amount,$order_amount,$common['consignee'],$common['mobile']);
            break;

        //小时工 40
        case '010102':
            $common = getCommonOrderInfo($post);
            $serviceTime = isset($post['servicetime']) ? trim($post['servicetime']) : '';
            $tip = isset($post['tip']) ? trim($post['tip']) : '';
            $price= isset($post['price']) ? intval(($post['price'])) : 0;

            //
            if ($tip == 1) {
                $good_attr_id = 241;
            } else if ($tip == 2) {
                $good_attr_id = 243;
                $attr_price = 30;

            } else if ($tip == 3) {
                $good_attr_id = 242;
            }
            $good_attr_name = get_goods_attr_info(Array($good_attr_id),'pice');
            $goods_amount =$price * $serviceTime + $attr_price;
            $order_amount = $goods_amount;
            doOrder($goods_sn, $serviceTime, $common['province'], $common['city'], $common['district'], $common['detailAddress'], $tip,
                '', $common['leaveword'],$common['firstServiceTime'], $common['uid'],
                $goods_amount,$order_amount,$common['consignee'],$common['mobile']);
            break;

        case '010201':


            break;

        // 深度清洁-一居
        case '010301':
            $common = getCommonOrderInfo($post);
            $good_attr_name = '';
            $goods_amount =380;
            $order_amount = $goods_amount;
            doOrder($goods_sn, 1, $common['province'], $common['city'], $common['district'], $common['detailAddress'], '',
                $good_attr_name, $common['leaveword'],$common['firstServiceTime'], $common['uid'],
                $goods_amount,$order_amount,$common['consignee'],$common['mobile']);
            break;

        // 深度清洁-二居1卫
        case '010302':
            $common = getCommonOrderInfo($post);
            $good_attr_name = '';
            $goods_amount =580;
            $order_amount = $goods_amount;
            doOrder($goods_sn, 1, $common['province'], $common['city'], $common['district'], $common['detailAddress'], '',
                $good_attr_name, $common['leaveword'],$common['firstServiceTime'], $common['uid'],
                $goods_amount,$order_amount,$common['consignee'],$common['mobile']);
            break;
        // 深度清洁-二居2卫
        case '010303':
            $common = getCommonOrderInfo($post);
            $good_attr_name = '';
            $goods_amount =650;
            $order_amount = $goods_amount;
            doOrder($goods_sn, 1, $common['province'], $common['city'], $common['district'], $common['detailAddress'], '',
                $good_attr_name, $common['leaveword'],$common['firstServiceTime'], $common['uid'],
                $goods_amount,$order_amount,$common['consignee'],$common['mobile']);
            break;
        // 深度清洁-三居1卫
        case '010304':
            $common = getCommonOrderInfo($post);
            $good_attr_name = '';
            $goods_amount =720;
            $order_amount = $goods_amount;
            doOrder($goods_sn, 1, $common['province'], $common['city'], $common['district'], $common['detailAddress'], '',
                $good_attr_name, $common['leaveword'],$common['firstServiceTime'], $common['uid'],
                $goods_amount,$order_amount,$common['consignee'],$common['mobile']);
            break;
        // 深度清洁-三居2卫
        case '010311':
            $common = getCommonOrderInfo($post);
            $good_attr_name = '';
            $goods_amount =830;
            $order_amount = $goods_amount;
            doOrder($goods_sn, 1, $common['province'], $common['city'], $common['district'], $common['detailAddress'], '',
                $good_attr_name, $common['leaveword'],$common['firstServiceTime'], $common['uid'],
                $goods_amount,$order_amount,$common['consignee'],$common['mobile']);
            break;
        // 深度清洁-4居3卫
        case '010306':
            $common = getCommonOrderInfo($post);
            $good_attr_name = '';
            $goods_amount =980;
            $order_amount = $goods_amount;
            doOrder($goods_sn, 1, $common['province'], $common['city'], $common['district'], $common['detailAddress'], '',
                $good_attr_name, $common['leaveword'],$common['firstServiceTime'], $common['uid'],
                $goods_amount,$order_amount,$common['consignee'],$common['mobile']);
            break;
        // 深度清洁-4居以上
        case '010309':
            $common = getCommonOrderInfo($post);
            $goodNum= isset($post['goodNum']) ? intval($post['goodNum']) : 1;
            $good_attr_name = '';
            $goods_amount = 6*$goodNum;
            $order_amount = $goods_amount;
            doOrder($goods_sn, $goodNum, $common['province'], $common['city'], $common['district'], $common['detailAddress'], '',
                $good_attr_name, $common['leaveword'],$common['firstServiceTime'], $common['uid'],
                $goods_amount,$order_amount,$common['consignee'],$common['mobile']);
            break;
        // 深度清洁-新居开荒
        case '010312':
            $common = getCommonOrderInfo($post);
            $goodNum= isset($post['goodNum']) ? intval($post['goodNum']) : 1;
            $good_attr_name = '';
            $goods_amount = 0; // 后付款
            $order_amount = $goods_amount;
            doOrder($goods_sn, $goodNum, $common['province'], $common['city'], $common['district'], $common['detailAddress'], '',
                $good_attr_name, $common['leaveword'],$common['firstServiceTime'], $common['uid'],
                $goods_amount,$order_amount,$common['consignee'],$common['mobile']);
            break;
        // 单独卫生间
        case '010307':
            $common = getCommonOrderInfo($post);
            $good_attr_name = '';
            $goods_amount = 210;
            $order_amount = $goods_amount;
            doOrder($goods_sn, 1, $common['province'], $common['city'], $common['district'], $common['detailAddress'], '',
                $good_attr_name, $common['leaveword'],$common['firstServiceTime'], $common['uid'],
                $goods_amount,$order_amount,$common['consignee'],$common['mobile']);
            break;
        // 单独厨房
        case '010308':
            $common = getCommonOrderInfo($post);
            $good_attr_name = '';
            $goods_amount = 260;
            $order_amount = $goods_amount;
            doOrder($goods_sn, 1, $common['province'], $common['city'], $common['district'], $common['detailAddress'], '',
                $good_attr_name, $common['leaveword'],$common['firstServiceTime'], $common['uid'],
                $goods_amount,$order_amount,$common['consignee'],$common['mobile']);
            break;


        // 地板打蜡
        case '010403':
            $common = getCommonOrderInfo($post);
            $good_attr_name = '';
            $goodNum= isset($post['goodNum']) ? intval($post['goodNum']) : 1;
            $price = 15;
            if ($goodNum> 50 && $goodNum< 100 ) {
                $price = 12;
            } else if ($goodNum >= 100) {
                $price = 10;
            }
            $goods_amount = $price *$goodNum;
            $order_amount = $goods_amount;
            doOrder($goods_sn, $goodNum, $common['province'], $common['city'], $common['district'], $common['detailAddress'], '',
                $good_attr_name, $common['leaveword'],$common['firstServiceTime'], $common['uid'],
                $goods_amount,$order_amount,$common['consignee'],$common['mobile'],$price);
            break;

        // 石材抛光
        case '010404':
            $common = getCommonOrderInfo($post);
            $good_attr_name = '';
            $goodNum= isset($post['goodNum']) ? intval($post['goodNum']) : 1;
            $price = 50;
            $goods_amount = $price *$goodNum;
            $order_amount = $goods_amount;
            doOrder($goods_sn, $goodNum, $common['province'], $common['city'], $common['district'], $common['detailAddress'], '',
                $good_attr_name, $common['leaveword'],$common['firstServiceTime'], $common['uid'],
                $goods_amount,$order_amount,$common['consignee'],$common['mobile']);
            break;

        // 清除甲醛
        case '010405':
            $common = getCommonOrderInfo($post);
            $good_attr_name = '';
            $goodNum= isset($post['goodNum']) ? intval($post['goodNum']) : 1;
            $price = 200;
            $goods_amount = $price *$goodNum;
            $order_amount = $goods_amount;
            doOrder($goods_sn, $goodNum, $common['province'], $common['city'], $common['district'], $common['detailAddress'], '',
                $good_attr_name, $common['leaveword'],$common['firstServiceTime'], $common['uid'],
                $goods_amount,$order_amount,$common['consignee'],$common['mobile']);
            break;
        // 除螨加香
        case '010406':
            $common = getCommonOrderInfo($post);
            $good_attr_name = '';
            $goodNum= isset($post['goodNum']) ? intval($post['goodNum']) : 1;
            $price = 200;
            $goods_amount = $price *$goodNum;
            $order_amount = $goods_amount;
            doOrder($goods_sn, $goodNum, $common['province'], $common['city'], $common['district'], $common['detailAddress'], '',
                $good_attr_name, $common['leaveword'],$common['firstServiceTime'], $common['uid'],
                $goods_amount,$order_amount,$common['consignee'],$common['mobile']);
            break;
        // 皮沙发护理
        case '010407':
            $common = getCommonOrderInfo($post);
            $good_attr_name = '';
            $goodNum= isset($post['goodNum']) ? intval($post['goodNum']) : 1;
            $type = isset($post['type']) ? trim($post['type']) : '';
            $price = 90;
            // 深色
            if ($type == '2') {
                $price = 80;
                $good_attr_id = 272;
            } else if($type == '1') {
                $price = 90;
                $good_attr_id = 271;
            }
            $good_attr_name = get_goods_attr_info(Array($good_attr_id),'pice');
            $goods_amount = $price *$goodNum;
            $order_amount = $goods_amount;
            doOrder($goods_sn, $goodNum, $common['province'], $common['city'], $common['district'], $common['detailAddress'], $good_attr_id,
                $good_attr_name, $common['leaveword'],$common['firstServiceTime'], $common['uid'],
                $goods_amount,$order_amount,$common['consignee'],$common['mobile']);
            break;
        // 洗玻璃
        case '010410':
            $common = getCommonOrderInfo($post);
            $good_attr_name = '';
            $goodNum= isset($post['goodNum']) ? intval($post['goodNum']) : 1;
            $price = 12;
            $goods_amount = $price *$goodNum;
            $order_amount = $goods_amount;
            doOrder($goods_sn, $goodNum, $common['province'], $common['city'], $common['district'], $common['detailAddress'], '',
                $good_attr_name, $common['leaveword'],$common['firstServiceTime'], $common['uid'],
                $goods_amount,$order_amount,$common['consignee'],$common['mobile']);
            break;


        // 空调清洗
        case '010501':
            $common = getCommonOrderInfo($post);
            $good_attr_name = '';
            $goodNum= isset($post['goodNum']) ? intval($post['goodNum']) : 1;
            $type = isset($post['type']) ? trim($post['type']) : '';
            $price = 120;
            // 柜机
            if ($type == '2') {
                $price = 140;
                $good_attr_id = 278;
            } else if($type == '1') {
                $price = 120;
                $good_attr_id = 277;
            }
            $good_attr_name = get_goods_attr_info(Array($good_attr_id),'pice');
            $goods_amount = $price *$goodNum;
            $order_amount = $goods_amount;
            doOrder($goods_sn, $goodNum, $common['province'], $common['city'], $common['district'], $common['detailAddress'], $good_attr_id,
                $good_attr_name, $common['leaveword'],$common['firstServiceTime'], $common['uid'],
                $goods_amount,$order_amount,$common['consignee'],$common['mobile']);
            break;
        // 冰箱除臭
        case '010502':
            $common = getCommonOrderInfo($post);
            $good_attr_name = '';
            $goodNum= isset($post['goodNum']) ? intval($post['goodNum']) : 1;
            $price = 120;
            $goods_amount = $price *$goodNum;
            $order_amount = $goods_amount;
            doOrder($goods_sn, $goodNum, $common['province'], $common['city'], $common['district'], $common['detailAddress'], '',
                $good_attr_name, $common['leaveword'],$common['firstServiceTime'], $common['uid'],
                $goods_amount,$order_amount,$common['consignee'],$common['mobile']);
            break;
        //灯具清洗
        case '010503':
            $common = getCommonOrderInfo($post);
            $good_attr_name = '';
            $goodNum= isset($post['goodNum']) ? intval($post['goodNum']) : 1;
            $price = 120;
            $goods_amount = $price *$goodNum;
            $order_amount = $goods_amount;
            doOrder($goods_sn, $goodNum, $common['province'], $common['city'], $common['district'], $common['detailAddress'], '',
                $good_attr_name, $common['leaveword'],$common['firstServiceTime'], $common['uid'],
                $goods_amount,$order_amount,$common['consignee'],$common['mobile']);
            break;
        //微波炉清洗
        case '010504':
            $common = getCommonOrderInfo($post);
            $good_attr_name = '';
            $goodNum= isset($post['goodNum']) ? intval($post['goodNum']) : 1;
            $price = 100;
            $goods_amount = $price *$goodNum;
            $order_amount = $goods_amount;
            doOrder($goods_sn, $goodNum, $common['province'], $common['city'], $common['district'], $common['detailAddress'], '',
                $good_attr_name, $common['leaveword'],$common['firstServiceTime'], $common['uid'],
                $goods_amount,$order_amount,$common['consignee'],$common['mobile']);
            break;
        //电烤箱清洗
        case '010506':
            $common = getCommonOrderInfo($post);
            $good_attr_name = '';
            $goodNum= isset($post['goodNum']) ? intval($post['goodNum']) : 1;
            $price = 100;
            $goods_amount = $price *$goodNum;
            $order_amount = $goods_amount;
            doOrder($goods_sn, $goodNum, $common['province'], $common['city'], $common['district'], $common['detailAddress'], '',
                $good_attr_name, $common['leaveword'],$common['firstServiceTime'], $common['uid'],
                $goods_amount,$order_amount,$common['consignee'],$common['mobile']);
            break;
        //油烟机清洗
        case '010507':
            $common = getCommonOrderInfo($post);
            $good_attr_name = '';
            $goodNum= isset($post['goodNum']) ? intval($post['goodNum']) : 1;
            $type = isset($post['type']) ? trim($post['type']) : '';
            $price = 160;
            //
            if ($type == '2') {
                $price = 200;
                $good_attr_id = 284;
            } else if($type == '1') {
                $price = 160;
                $good_attr_id = 283;
            }
            $good_attr_name = get_goods_attr_info(Array($good_attr_id),'pice');
            $goods_amount = $price *$goodNum;
            $order_amount = $goods_amount;
            doOrder($goods_sn, $goodNum, $common['province'], $common['city'], $common['district'], $common['detailAddress'], $good_attr_id,
                $good_attr_name, $common['leaveword'],$common['firstServiceTime'], $common['uid'],
                $goods_amount,$order_amount,$common['consignee'],$common['mobile']);
            break;



        // 外墙清洗
        case '010601':
            $common = getCommonOrderInfo($post);
            $good_attr_name = '';
            $goodNum= isset($post['goodNum']) ? intval($post['goodNum']) : 1;
            $price = 500;
            $goods_amount = $price *$goodNum;
            $order_amount = $goods_amount;
            doOrder($goods_sn, $goodNum, $common['province'], $common['city'], $common['district'], $common['detailAddress'], '',
                $good_attr_name, $common['leaveword'],$common['firstServiceTime'], $common['uid'],
                $goods_amount,$order_amount,$common['consignee'],$common['mobile']);
            break;
        // 大型拓荒
        case '010602':
            $common = getCommonOrderInfo($post);
            $good_attr_name = '';
            $goodNum= isset($post['goodNum']) ? intval($post['goodNum']) : 1;
            $price = 500;
            $goods_amount = $price *$goodNum;
            $order_amount = $goods_amount;
            doOrder($goods_sn, $goodNum, $common['province'], $common['city'], $common['district'], $common['detailAddress'], '',
                $good_attr_name, $common['leaveword'],$common['firstServiceTime'], $common['uid'],
                $goods_amount,$order_amount,$common['consignee'],$common['mobile']);
            break;
        // 保洁托管
        case '010603':
            $common = getCommonOrderInfo($post);
            $good_attr_name = '';
            $goodNum= isset($post['goodNum']) ? intval($post['goodNum']) : 1;
            $type = isset($post['type']) ? trim($post['type']) : '';
            $price = 0;
            //
            if ($type == '1') {
                $price = 159;
                $good_attr_id = 285;
            } else if($type == '2') {
                $price = 469;
                $good_attr_id = 286;
            }else if($type == '3') {
                $price = 7399;
                $good_attr_id = 287;
            }
            $good_attr_name = get_goods_attr_info(Array($good_attr_id),'pice');
            $goods_amount = $price *$goodNum;
            $order_amount = $goods_amount;
            doOrder($goods_sn, $goodNum, $common['province'], $common['city'], $common['district'], $common['detailAddress'], $good_attr_id,
                $good_attr_name, $common['leaveword'],$common['firstServiceTime'], $common['uid'],
                $goods_amount,$order_amount,$common['consignee'],$common['mobile']);
            break;
        // 绿化养护
        case '010604':
            $common = getCommonOrderInfo($post);
            $good_attr_name = '';
            $goodNum= isset($post['goodNum']) ? intval($post['goodNum']) : 1;
            $price = 500;
            $goods_amount = $price *$goodNum;
            $order_amount = $goods_amount;
            doOrder($goods_sn, $goodNum, $common['province'], $common['city'], $common['district'], $common['detailAddress'], '',
                $good_attr_name, $common['leaveword'],$common['firstServiceTime'], $common['uid'],
                $goods_amount,$order_amount,$common['consignee'],$common['mobile']);
            break;
        // 化粪池处理
        case '010605':
            $common = getCommonOrderInfo($post);
            $good_attr_name = '';
            $goodNum= isset($post['goodNum']) ? intval($post['goodNum']) : 1;
            $price = 500;
            $goods_amount = $price *$goodNum;
            $order_amount = $goods_amount;
            doOrder($goods_sn, $goodNum, $common['province'], $common['city'], $common['district'], $common['detailAddress'], '',
                $good_attr_name, $common['leaveword'],$common['firstServiceTime'], $common['uid'],
                $goods_amount,$order_amount,$common['consignee'],$common['mobile']);
            break;
        // 油烟管道
        case '010606':
            $common = getCommonOrderInfo($post);
            $good_attr_name = '';
            $goodNum= isset($post['goodNum']) ? intval($post['goodNum']) : 1;
            $price = 500;
            $goods_amount = $price *$goodNum;
            $order_amount = $goods_amount;
            doOrder($goods_sn, $goodNum, $common['province'], $common['city'], $common['district'], $common['detailAddress'], '',
                $good_attr_name, $common['leaveword'],$common['firstServiceTime'], $common['uid'],
                $goods_amount,$order_amount,$common['consignee'],$common['mobile']);
            break;
        // 中央空调
        case '010607':
            $common = getCommonOrderInfo($post);
            $good_attr_name = '';
            $goodNum= isset($post['goodNum']) ? intval($post['goodNum']) : 1;
            $price = 500;
            $goods_amount = $price *$goodNum;
            $order_amount = $goods_amount;
            doOrder($goods_sn, $goodNum, $common['province'], $common['city'], $common['district'], $common['detailAddress'], '',
                $good_attr_name, $common['leaveword'],$common['firstServiceTime'], $common['uid'],
                $goods_amount,$order_amount,$common['consignee'],$common['mobile']);
            break;
    }


}

function getCommonOrderInfo($post) {
    $res = array();
    $res['province'] = isset($post['province']) ? trim($post['province']) : '';
    $res['city'] = isset($post['city']) ? trim($post['city']) : '';
    $res['district'] = isset($post['district']) ? trim($post['district']) : '';
    $res['detailAddress'] = isset($post['detailaddress']) ? trim($post['detailaddress']) : '';
    $res['leaveword'] = isset($post['leaveword']) ? trim($post['leaveword']) : '';
    $res['uid'] = isset($post['user_id']) ? trim($post['user_id']) : '';
    $res['consignee']= isset($post['consignee']) ? trim(($post['consignee'])) : '';
    $res['mobile']= isset($post['mobile']) ? trim(($post['mobile'])) : '';
    $res['firstServiceTime']= isset($post['firstServiceTime']) ? trim($post['firstServiceTime']) : '';
    $res['pay_id']= isset($post['pay_id']) ? trim($post['pay_id']) : '1';
    return $res;
}

function get_goods_attr_info($arr, $type = 'pice')
{
    $attr   = '';

    if (!empty($arr))
    {
        $fmt = "%s:%s[%s] \n";

        $sql = "SELECT a.attr_name, ga.attr_value, ga.attr_price ".
            "FROM ".$GLOBALS['ecs']->table('goods_attr')." AS ga, ".
            $GLOBALS['ecs']->table('attribute')." AS a ".
            "WHERE " .db_create_in($arr, 'ga.goods_attr_id')." AND a.attr_id = ga.attr_id";
        $res = $GLOBALS['db']->query($sql);

        while ($row = $GLOBALS['db']->fetchRow($res))
        {
            $attr_price = round(floatval($row['attr_price']), 2);
            $attr .= sprintf($fmt, $row['attr_name'], $row['attr_value'], $attr_price);
        }

        $attr = str_replace('[0]', '', $attr);
    }

    return $attr;
}
/**
 * 添加分类
 *
 * @param array $post
 */

function doOrder($goods_sn, $serviceTime, $province, $city, $district, $detailAddress, $good_attr_id,
                       $good_attr_name, $leaveword,$firstServiceTime, $user_id,$goods_amount,$order_amount,$consignee,$mobile,$price=-1,
      $pay_id
)
{

    $order['order_sn'] = get_order_sn();
    $order['user_id'] = $user_id;
    $order['pay_id'] = $pay_id;
    $payment = payment_info($order['pay_id']);
    $order['pay_name'] = addslashes($payment['pay_name']);
    $order['timenum'] = $serviceTime;
    $order['province'] = $province;
    $order['city'] = $city;
    $order['district'] = $district;
    $order['address'] = $detailAddress;
    $order['good_attr_id'] = $good_attr_id;
    $order['good_attr_name'] = $good_attr_name;
    $order['postscript'] = $leaveword;
    $order['first_service_time'] = $firstServiceTime;
    $order['add_time'] =time();
    $order['order_status'] = 0;
    $order['pay_status'] = 0;
    $order['goods_amount'] =$goods_amount ;
    $order['order_amount'] =$order_amount ;
    $order['consignee'] =$consignee;
    $order['mobile'] =$mobile;
    $order['surplus'] =0;
    $order['shipping_id'] =8;
    $order['country'] =1;
    $order['shipping_name'] = '上门服务';
    $order['referer'] = '';
    $user_info = user_info($user_id);


   // 1 余额，3见面付，
    if ($pay_id== 1) {
        if ($order['goods_amount'] >$user_info['user_money']) {
            client_show_message(400, true, "余额不足，不能余额支付", $user_id, true, EC_CHARSET);
        } else {
            $order['order_amount'] =0;
            $order['surplus'] =$order['goods_amount'];
            /* 如果订单金额为0（使用余额或积分或红包支付），修改订单状态为已确认、已付款 */
            if ($order['order_amount'] <= 0)
            {
                $order['order_status'] = OS_CONFIRMED;
                $order['confirm_time'] = gmtime();
                $order['pay_status']   = PS_PAYED;
                $order['pay_time']     = gmtime();
                $order['order_amount'] = 0;
                log_account_change($order['user_id'], $order['surplus'] * (-1), 0, 0, 0, '支付订单', $order['order_sn']);
            }
        }
    }
    $GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('order_info'), $order, 'INSERT');



/*    $sql = "insert into " . $GLOBALS['ecs']->table('order_info') .
        "(order_sn,user_id,province,city,district,address,order_status,pay_status,postscript,country,
        first_service_time,add_time,goods_amount,order_amount,shipping_id,shipping_name,pay_id,pay_name,referer,consignee,mobile) values('" .
        $order['order_sn'] . "'," . $order['user_id'] . "," . $order['province'] . "," . $order['city'] . "," . $order['district']
        . ",'" . $order['detailAddress'] . "'," .
        $order['order_status'] . "," . $order['pay_status'] . ",'" . $order['leaveword'] . "',1,"
        . $order['firstServiceTime'] . "," . $order['addTime'] . "," . $order['goods_amount'] . "," . $order['order_amount']
        . ",8,'上门服务',2,'银行转帐','app','".$order['consignee']."','".$order['mobile']."')";*/

    //$GLOBALS['db']->query($sql);

    $sql = "select order_id from " . $GLOBALS['ecs']->table('order_info') . " where order_sn='" . $order['order_sn'] . "'";

    $orderrow = $GLOBALS['db']->getRow($sql);

    $sql = "select goods_id ,goods_name,shop_price from " . $GLOBALS['ecs']->table('goods') . "where goods_sn=" . $goods_sn . "";
    $goodsrow = $GLOBALS['db']->getRow($sql);
    $goodPrice = $goodsrow['shop_price'];
    if ($price !=-1) {
     $goodPrice  = $price ;
    }


    $sql = "insert into " . $GLOBALS['ecs']->table('order_goods') . "(order_id,goods_id,goods_name,goods_sn,goods_number,goods_price,goods_attr,goods_attr_id) values (" .
        $orderrow['order_id'] . "," . $goodsrow['goods_id'] . ",'" . $goodsrow['goods_name'] . "','" . $goods_sn . "',"
        . $order['timenum'] . "," . $goodPrice . ",'" . $order['good_attr_name'] . "','" . $order['good_attr_id'] . "')";
    $GLOBALS['db']->query($sql);
    client_show_message(200, true, "预约成功", 0, true, EC_CHARSET);
}



function doOrder2($goods_sn, $serviceTime, $province, $city, $district, $detailAddress, $good_attr_id,
                 $good_attr_name, $leaveword,$firstServiceTime, $user_id,$goods_amount,$order_amount,$consignee,$mobile,$price=-1,
    $payment
)
    {
        include_once('includes/lib_clips.php');
        include_once('includes/lib_payment.php');

        /* 取得购物类型 */
        $flow_type = isset($_SESSION['flow_type']) ? intval($_SESSION['flow_type']) : CART_GENERAL_GOODS;

        $consignee = get_consignee($_SESSION['user_id']);


        $_POST['how_oos'] = isset($_POST['how_oos']) ? intval($_POST['how_oos']) : 0;
        $_POST['card_message'] = isset($_POST['card_message']) ? compile_str($_POST['card_message']) : '';
        $_POST['inv_type'] = !empty($_POST['inv_type']) ? compile_str($_POST['inv_type']) : '';
        $_POST['inv_payee'] = isset($_POST['inv_payee']) ? compile_str($_POST['inv_payee']) : '';  // 发票抬头
        $_POST['inv_content'] = isset($_POST['inv_content']) ? compile_str($_POST['inv_content']) : ''; // 发票内容
        $_POST['postscript'] = isset($_POST['postscript']) ? compile_str($_POST['postscript']) : '';

        $order = array(
            'province'=> $province,
        'city'=> $city,
        'district'=>$district,
            'detailAddress'=> $detailAddress,
            'consignee'=> $consignee,
            'mobile'=> $mobile,

            'shipping_id'     => intval(8), // 上门取货
            'pay_id'          => intval($payment), // 支付方式 1 余额，3见面付，
            'pack_id'         => isset($_POST['pack']) ? intval($_POST['pack']) : 0,
            'card_id'         => isset($_POST['card']) ? intval($_POST['card']) : 0,
            'card_message'    => trim($_POST['card_message']),
            'surplus'         => isset($_POST['surplus']) ? floatval($_POST['surplus']) : 0.00,
            'integral'        => isset($_POST['integral']) ? intval($_POST['integral']) : 0,
            'bonus_id'        => isset($_POST['bonus']) ? intval($_POST['bonus']) : 0,
            'need_inv'        => empty($_POST['need_inv']) ? 0 : 1,
            'inv_type'        => $_POST['inv_type'],
            'inv_payee'       => trim($_POST['inv_payee']),
            'inv_content'     => $_POST['inv_content'],
            'postscript'      => trim($leaveword),
            'how_oos'         => isset($_LANG['oos'][$_POST['how_oos']]) ? addslashes($_LANG['oos'][$_POST['how_oos']]) : '',
            'need_insure'     => isset($_POST['need_insure']) ? intval($_POST['need_insure']) : 0,
            'user_id'         => $user_id,
            'add_time'        => gmtime(),
            'order_status'    => OS_UNCONFIRMED,
            'shipping_status' => SS_UNSHIPPED,
            'pay_status'      => PS_UNPAYED,
            'agency_id'       => get_agency_by_regions(array($consignee['country'], $consignee['province'], $consignee['city'], $consignee['district']))
        );


            $order['extension_code'] = '';
            $order['extension_id'] = 0;


        /* 检查积分余额是否合法 */

        if ($user_id > 0)
        {
            $user_info = user_info($user_id);

            $order['surplus'] = min($order['surplus'], $user_info['user_money'] + $user_info['credit_line']);
            if ($order['surplus'] < 0)
            {
                $order['surplus'] = 0;
            }

            // 查询用户有多少积分
            $flow_points = flow_available_points();  // 该订单允许使用的积分
            $user_points = $user_info['pay_points']; // 用户的积分总数

            $order['integral'] = min($order['integral'], $user_points, $flow_points);
            if ($order['integral'] < 0)
            {
                $order['integral'] = 0;
            }
        }
        else
        {
            $order['surplus']  = 0;
            $order['integral'] = 0;
        }

        /* 检查红包是否存在 */
        if ($order['bonus_id'] > 0)
        {
            $bonus = bonus_info($order['bonus_id']);

            if (empty($bonus) || $bonus['user_id'] != $user_id || $bonus['order_id'] > 0 || $bonus['min_goods_amount'] > cart_amount(true, $flow_type))
            {
                $order['bonus_id'] = 0;
            }
        }

        $order['bonus']        = 0;
        $order['goods_amount'] = $goods_amount;
        $order['discount']     = 0;
        $order['surplus']      = 0;
        $order['tax']          = 0;

        // 购物车中的商品能享受红包支付的总额
        $discount_amout = 0;
        // 红包和积分最多能支付的金额为商品总额
        $temp_amout = $order['goods_amount'] - $discount_amout;
        if ($temp_amout <= 0)
        {
            $order['bonus_id'] = 0;
        }

        /* 配送方式 */
        if ($order['shipping_id'] > 0)
        {
            $shipping = shipping_info($order['shipping_id']);
            $order['shipping_name'] = addslashes($shipping['shipping_name']);
        }
        $order['shipping_fee'] =0;
        $order['insure_fee']   = 0;

        /* 支付方式 */
        if ($order['pay_id'] > 0)
        {
            $payment = payment_info($order['pay_id']);
            $order['pay_name'] = addslashes($payment['pay_name']);
        }
        $order['pay_fee'] = 0;
        $order['cod_fee'] = 0;

        /* 商品包装 */
        if ($order['pack_id'] > 0)
        {
            $pack               = pack_info($order['pack_id']);
            $order['pack_name'] = addslashes($pack['pack_name']);
        }
        $order['pack_fee'] = 0;

        /* 祝福贺卡 */
        if ($order['card_id'] > 0)
        {
            $card               = card_info($order['card_id']);
            $order['card_name'] = addslashes($card['card_name']);
        }
        $order['card_fee']      = 0;

        $order['order_amount']  = $order_amount;

        /* 如果全部使用余额支付，检查余额是否足够 */
        if ($payment['pay_code'] == 'balance' && $order['order_amount'] > 0)
        {
            if ($order['order_amount'] > ($user_info['user_money'] + $user_info['credit_line']))
            {
                show_message($_LANG['balance_not_enough']);
            }
            else
            {
                $order['surplus'] = $order['order_amount'];
                $order['order_amount'] = 0;
            }
        }

        /* 如果订单金额为0（使用余额或积分或红包支付），修改订单状态为已确认、已付款 */
        if ($order['order_amount'] <= 0)
        {
            $order['order_status'] = OS_CONFIRMED;
            $order['confirm_time'] = gmtime();
            $order['pay_status']   = PS_PAYED;
            $order['pay_time']     = gmtime();
            $order['order_amount'] = 0;
        }

        $order['integral_money']   = 0;
        $order['integral']         = 0;

        $order['from_ad']          = !empty($_SESSION['from_ad']) ? $_SESSION['from_ad'] : '0';
        $order['referer']          = !empty($_SESSION['referer']) ? addslashes($_SESSION['referer']) : '';

        /* 插入订单表 */
        $error_no = 0;
        do
        {
            $order['order_sn'] = get_order_sn(); //获取新订单号
            $GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('order_info'), $order, 'INSERT');

            $error_no = $GLOBALS['db']->errno();

            if ($error_no > 0 && $error_no != 1062)
            {
                die($GLOBALS['db']->errorMsg());
            }
        }
        while ($error_no == 1062); //如果是订单号重复则重新提交数据

        $new_order_id = $GLOBALS['db']->insert_id();
        $order['order_id'] = $new_order_id;

        /* 插入订单商品 */
        $sql = "INSERT INTO " . $GLOBALS['ecs']->table('order_goods') . "( " .
            "order_id, goods_id, goods_name, goods_sn, product_id, goods_number, market_price, ".
            "goods_price, goods_attr, is_real, extension_code, parent_id, is_gift, goods_attr_id) ".
            " SELECT '$new_order_id', goods_id, goods_name, goods_sn, product_id, goods_number, market_price, ".
            "goods_price, goods_attr, is_real, extension_code, parent_id, is_gift, goods_attr_id".
            " FROM " .$GLOBALS['ecs']->table('cart') .
            " WHERE session_id = '".SESS_ID."' AND rec_type = '$flow_type'";
        $GLOBALS['db']->query($sql);
        /* 修改拍卖活动状态 */
        if ($order['extension_code']=='auction')
        {
            $sql = "UPDATE ". $GLOBALS['ecs']->table('goods_activity') ." SET is_finished='2' WHERE act_id=".$order['extension_id'];
            $GLOBALS['db']->query($sql);
        }

        /* 处理余额、积分、红包 */
        if ($order['user_id'] > 0 && $order['surplus'] > 0)
        {
            log_account_change($order['user_id'], $order['surplus'] * (-1), 0, 0, 0, sprintf($_LANG['pay_order'], $order['order_sn']));
        }
        if ($order['user_id'] > 0 && $order['integral'] > 0)
        {
            log_account_change($order['user_id'], 0, 0, 0, $order['integral'] * (-1), sprintf($_LANG['pay_order'], $order['order_sn']));
        }


        if ($order['bonus_id'] > 0 && $temp_amout > 0)
        {
            use_bonus($order['bonus_id'], $new_order_id);
        }

        /* 如果使用库存，且下订单时减库存，则减少库存 */
        if ($_CFG['use_storage'] == '1' && $_CFG['stock_dec_time'] == SDT_PLACE)
        {
            change_order_goods_storage($order['order_id'], true, SDT_PLACE);
        }

        /* 给商家发邮件 */
        /* 增加是否给客服发送邮件选项 */
        if ($_CFG['send_service_email'] && $_CFG['service_email'] != '')
        {
            $tpl = get_mail_template('remind_of_new_order');
            $smarty->assign('order', $order);
            $smarty->assign('goods_list', $cart_goods);
            $smarty->assign('shop_name', $_CFG['shop_name']);
            $smarty->assign('send_date', date($_CFG['time_format']));
            $content = $smarty->fetch('str:' . $tpl['template_content']);
            send_mail($_CFG['shop_name'], $_CFG['service_email'], $tpl['template_subject'], $content, $tpl['is_html']);
        }

        /* 如果需要，发短信 */
        if ($_CFG['sms_order_placed'] == '1' && $_CFG['sms_shop_mobile'] != '')
        {
            include_once('includes/cls_sms.php');
            $sms = new sms();
            $msg = $order['pay_status'] == PS_UNPAYED ?
                $_LANG['order_placed_sms'] : $_LANG['order_placed_sms'] . '[' . $_LANG['sms_paid'] . ']';
            $sms->send($_CFG['sms_shop_mobile'], sprintf($msg, $order['consignee'], $order['tel']),'', 13,1);
        }

        /* 如果订单金额为0 处理虚拟卡 */
        if ($order['order_amount'] <= 0)
        {
            $sql = "SELECT goods_id, goods_name, goods_number AS num FROM ".
                $GLOBALS['ecs']->table('cart') .
                " WHERE is_real = 0 AND extension_code = 'virtual_card'".
                " AND session_id = '".SESS_ID."' AND rec_type = '$flow_type'";

            $res = $GLOBALS['db']->getAll($sql);

            $virtual_goods = array();
            foreach ($res AS $row)
            {
                $virtual_goods['virtual_card'][] = array('goods_id' => $row['goods_id'], 'goods_name' => $row['goods_name'], 'num' => $row['num']);
            }

            if ($virtual_goods AND $flow_type != CART_GROUP_BUY_GOODS)
            {
                /* 虚拟卡发货 */
                if (virtual_goods_ship($virtual_goods,$msg, $order['order_sn'], true))
                {
                    /* 如果没有实体商品，修改发货状态，送积分和红包 */
                    $sql = "SELECT COUNT(*)" .
                        " FROM " . $GLOBALS['ecs']->table('order_goods') .
                        " WHERE order_id = '$order[order_id]' " .
                        " AND is_real = 1";
                    if ($GLOBALS['db']->getOne($sql) <= 0)
                    {
                        /* 修改订单状态 */
                        update_order($order['order_id'], array('shipping_status' => SS_SHIPPED, 'shipping_time' => gmtime()));

                        /* 如果订单用户不为空，计算积分，并发给用户；发红包 */
                        if ($order['user_id'] > 0)
                        {
                            /* 取得用户信息 */
                            $user = user_info($order['user_id']);

                            /* 计算并发放积分 */
                            $integral = integral_to_give($order);
                            log_account_change($order['user_id'], 0, 0, intval($integral['rank_points']), intval($integral['custom_points']), sprintf($_LANG['order_gift_integral'], $order['order_sn']));

                            /* 发放红包 */
                            send_order_bonus($order['order_id']);
                        }
                    }
                }
            }

        }

        /* 清空购物车 */
        clear_cart($flow_type);
        /* 清除缓存，否则买了商品，但是前台页面读取缓存，商品数量不减少 */
        clear_all_files();

        /* 插入支付日志 */
        $order['log_id'] = insert_pay_log($new_order_id, $order['order_amount'], PAY_ORDER);

        /* 取得支付信息，生成支付代码 */
        if ($order['order_amount'] > 0)
        {
            $payment = payment_info($order['pay_id']);

            include_once('includes/modules/payment/' . $payment['pay_code'] . '.php');

            $pay_obj    = new $payment['pay_code'];

            $pay_online = $pay_obj->get_code($order, unserialize_config($payment['pay_config']));

            $order['pay_desc'] = $payment['pay_desc'];

            $smarty->assign('pay_online', $pay_online);
        }
        if(!empty($order['shipping_name']))
        {
            $order['shipping_name']=trim(stripcslashes($order['shipping_name']));
        }

        /* 订单信息 */
        $smarty->assign('order',      $order);
        $smarty->assign('total',      $total);
        $smarty->assign('goods_list', $cart_goods);
        $smarty->assign('order_submit_back', sprintf($_LANG['order_submit_back'], $_LANG['back_home'], $_LANG['goto_user_center'])); // 返回提示

        user_uc_call('add_feed', array($order['order_id'], BUY_GOODS)); //推送feed到uc
        unset($_SESSION['flow_consignee']); // 清除session中保存的收货人信息
        unset($_SESSION['flow_order']);
        unset($_SESSION['direct_shopping']);

}

?>
