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
                $goods_amount,$order_amount,$common['consignee'],$common['mobile'],-1,$common['pay_id'],$common['pay_type']);
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
                $goods_amount,$order_amount,$common['consignee'],$common['mobile'],-1,$common['pay_id'],$common['pay_type']);
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
                $goods_amount,$order_amount,$common['consignee'],$common['mobile'],-1,$common['pay_id'],$common['pay_type']);
            break;

        // 深度清洁-二居1卫
        case '010302':
            $common = getCommonOrderInfo($post);
            $good_attr_name = '';
            $goods_amount =580;
            $order_amount = $goods_amount;
            doOrder($goods_sn, 1, $common['province'], $common['city'], $common['district'], $common['detailAddress'], '',
                $good_attr_name, $common['leaveword'],$common['firstServiceTime'], $common['uid'],
                $goods_amount,$order_amount,$common['consignee'],$common['mobile'],-1,$common['pay_id'],$common['pay_type']);
            break;
        // 深度清洁-二居2卫
        case '010303':
            $common = getCommonOrderInfo($post);
            $good_attr_name = '';
            $goods_amount =650;
            $order_amount = $goods_amount;
            doOrder($goods_sn, 1, $common['province'], $common['city'], $common['district'], $common['detailAddress'], '',
                $good_attr_name, $common['leaveword'],$common['firstServiceTime'], $common['uid'],
                $goods_amount,$order_amount,$common['consignee'],$common['mobile'],-1,$common['pay_id'],$common['pay_type']);
            break;
        // 深度清洁-三居1卫
        case '010304':
            $common = getCommonOrderInfo($post);
            $good_attr_name = '';
            $goods_amount =720;
            $order_amount = $goods_amount;
            doOrder($goods_sn, 1, $common['province'], $common['city'], $common['district'], $common['detailAddress'], '',
                $good_attr_name, $common['leaveword'],$common['firstServiceTime'], $common['uid'],
                $goods_amount,$order_amount,$common['consignee'],$common['mobile'],-1,$common['pay_id'],$common['pay_type']);
            break;
        // 深度清洁-三居2卫
        case '010311':
            $common = getCommonOrderInfo($post);
            $good_attr_name = '';
            $goods_amount =830;
            $order_amount = $goods_amount;
            doOrder($goods_sn, 1, $common['province'], $common['city'], $common['district'], $common['detailAddress'], '',
                $good_attr_name, $common['leaveword'],$common['firstServiceTime'], $common['uid'],
                $goods_amount,$order_amount,$common['consignee'],$common['mobile'],-1,$common['pay_id'],$common['pay_type']);
            break;
        // 深度清洁-4居3卫
        case '010306':
            $common = getCommonOrderInfo($post);
            $good_attr_name = '';
            $goods_amount =980;
            $order_amount = $goods_amount;
            doOrder($goods_sn, 1, $common['province'], $common['city'], $common['district'], $common['detailAddress'], '',
                $good_attr_name, $common['leaveword'],$common['firstServiceTime'], $common['uid'],
                $goods_amount,$order_amount,$common['consignee'],$common['mobile'],-1,$common['pay_id'],$common['pay_type']);
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
                $goods_amount,$order_amount,$common['consignee'],$common['mobile'],-1,$common['pay_id'],$common['pay_type']);
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
                $goods_amount,$order_amount,$common['consignee'],$common['mobile'],-1,$common['pay_id'],$common['pay_type']);
            break;
        // 单独卫生间
        case '010307':
            $common = getCommonOrderInfo($post);
            $good_attr_name = '';
            $goods_amount = 210;
            $order_amount = $goods_amount;
            doOrder($goods_sn, 1, $common['province'], $common['city'], $common['district'], $common['detailAddress'], '',
                $good_attr_name, $common['leaveword'],$common['firstServiceTime'], $common['uid'],
                $goods_amount,$order_amount,$common['consignee'],$common['mobile'],-1,$common['pay_id'],$common['pay_type']);
            break;
        // 单独厨房
        case '010308':
            $common = getCommonOrderInfo($post);
            $good_attr_name = '';
            $goods_amount = 260;
            $order_amount = $goods_amount;
            doOrder($goods_sn, 1, $common['province'], $common['city'], $common['district'], $common['detailAddress'], '',
                $good_attr_name, $common['leaveword'],$common['firstServiceTime'], $common['uid'],
                $goods_amount,$order_amount,$common['consignee'],$common['mobile'],-1,$common['pay_id'],$common['pay_type']);
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
                $goods_amount,$order_amount,$common['consignee'],$common['mobile'],$price,$common['pay_id'],$common['pay_type']);
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
                $goods_amount,$order_amount,$common['consignee'],$common['mobile'],-1,$common['pay_id'],$common['pay_type']);
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
                $goods_amount,$order_amount,$common['consignee'],$common['mobile'],-1,$common['pay_id'],$common['pay_type']);
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
                $goods_amount,$order_amount,$common['consignee'],$common['mobile'],-1,$common['pay_id'],$common['pay_type']);
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
                $goods_amount,$order_amount,$common['consignee'],$common['mobile'],-1,$common['pay_id'],$common['pay_type']);
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
                $goods_amount,$order_amount,$common['consignee'],$common['mobile'],-1,$common['pay_id'],$common['pay_type']);
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
                $goods_amount,$order_amount,$common['consignee'],$common['mobile'],-1,$common['pay_id'],$common['pay_type']);
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
                $goods_amount,$order_amount,$common['consignee'],$common['mobile'],-1,$common['pay_id'],$common['pay_type']);
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
                $goods_amount,$order_amount,$common['consignee'],$common['mobile'],-1,$common['pay_id'],$common['pay_type']);
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
                $goods_amount,$order_amount,$common['consignee'],$common['mobile'],-1,$common['pay_id'],$common['pay_type']);
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
                $goods_amount,$order_amount,$common['consignee'],$common['mobile'],-1,$common['pay_id'],$common['pay_type']);
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
                $goods_amount,$order_amount,$common['consignee'],$common['mobile'],-1,$common['pay_id'],$common['pay_type']);
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
                $goods_amount,$order_amount,$common['consignee'],$common['mobile'],-1,$common['pay_id'],$common['pay_type']);
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
                $goods_amount,$order_amount,$common['consignee'],$common['mobile'],-1,$common['pay_id'],$common['pay_type']);
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
                $goods_amount,$order_amount,$common['consignee'],$common['mobile'],-1,$common['pay_id'],$common['pay_type']);
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
                $goods_amount,$order_amount,$common['consignee'],$common['mobile'],-1,$common['pay_id'],$common['pay_type']);
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
                $goods_amount,$order_amount,$common['consignee'],$common['mobile'],-1,$common['pay_id'],$common['pay_type']);
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
                $goods_amount,$order_amount,$common['consignee'],$common['mobile'],-1,$common['pay_id'],$common['pay_type']);
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
                $goods_amount,$order_amount,$common['consignee'],$common['mobile'],-1,$common['pay_id'],$common['pay_type']);
            break;
    }


}

function getCommonOrderInfo($post,$goodType=1) {
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
    $res['pay_type']= isset($post['pay_type']) ? trim($post['pay_type']) : '1';
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
 * 取得支付方式信息
 * @param   int     $pay_id     支付方式id
 * @return  array   支付方式信息
 */
function payment_info($pay_id)
{
    $sql = 'SELECT * FROM ' . $GLOBALS['ecs']->table('payment') .
        " WHERE pay_id = '$pay_id' AND enabled = 1";

    return $GLOBALS['db']->getRow($sql);
}

/**
 * 添加分类
 *
 * @param array $post
 */

function doOrder($goods_sn, $serviceTime, $province, $city, $district, $detailAddress, $good_attr_id,
                       $good_attr_name, $leaveword,$firstServiceTime, $user_id,$goods_amount,$order_amount,$consignee,$mobile,$price=-1,
      $pay_id,$pay_type
)
{
    $order['order_sn'] = get_order_sn();
    $order['user_id'] = $user_id;
    $order['pay_id'] = $pay_id;
    $order['pay_type'] = $pay_type;
    $payment = payment_info($order['pay_id']);
    $order['pay_name'] = addslashes($payment['pay_name']);
    $order['timenum'] = $serviceTime;
    $order['province'] = $province;
    $order['city'] = $city;
    $order['district'] = $district;
    $order['address'] = $detailAddress;
    $order['good_attr_id'] = $good_attr_id;
    $order['good_attr_name'] = $good_attr_name;
    $order['leaveword'] = $leaveword;
    $order['firstServiceTime'] = $firstServiceTime;
    $order['addTime'] =time();
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
                $order['order_status'] = 1;
                $order['confirm_time'] = gmtime();
                $order['pay_status']   = PS_PAYED;
                $order['pay_time']     = gmtime();
                $order['order_amount'] = 0;
                log_account_change($order['user_id'], $order['surplus'] * (-1), 0, 0, 0, '支付订单', $order['order_sn']);
            }
        }
    }
   // $GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('order_info'), $order, 'INSERT');


    $sql = "select goods_id ,goods_name,shop_price,cat_id from " . $GLOBALS['ecs']->table('goods') . "where goods_sn=" . $goods_sn . "";
    $goodsrow = $GLOBALS['db']->getRow($sql);
    $goodPrice = $goodsrow['shop_price'];
    if ($price !=-1) {
        $goodPrice  = $price ;
    }

    $sql = "select parent_id from " . $GLOBALS['ecs']->table('category') . "where cat_id=" . $goodsrow['cat_id'] . "";
    $catrow = $GLOBALS['db']->getRow($sql);

    $sql = "insert into " . $GLOBALS['ecs']->table('order_info') .
        "(order_sn,user_id,province,city,district,address,order_status,pay_status,postscript,country,
        first_service_time,add_time,goods_amount,order_amount,shipping_id,shipping_name,pay_id,pay_name,
        referer,consignee,mobile,surplus,pay_type,cat_id) values('" .
        $order['order_sn'] . "'," . $order['user_id'] . "," . $order['province'] . "," . $order['city'] . "," . $order['district']
        . ",'" . $order['detailAddress'] . "'," .
        $order['order_status'] . "," . $order['pay_status'] . ",'" . $order['leaveword'] . "',1,"
        . $order['firstServiceTime'] . "," . $order['addTime'] . "," . $order['goods_amount'] . "," . $order['order_amount']
        . ",8,'上门服务',".$order['pay_id'].",'".$order['pay_name']."','app','".$order['consignee']."','".$order['mobile']
        ."',".$order['surplus'].",".$order['pay_type']."," . $catrow['parent_id'] . ")";

    $GLOBALS['db']->query($sql);

    $sql = "select order_id from " . $GLOBALS['ecs']->table('order_info') . " where order_sn='" . $order['order_sn'] . "'";

    $orderrow = $GLOBALS['db']->getRow($sql);


    $sql = "insert into " . $GLOBALS['ecs']->table('order_goods')
        . "(order_id,goods_id,goods_name,goods_sn,goods_number,goods_price,goods_attr,goods_attr_id) values (" .
        $orderrow['order_id'] . "," . $goodsrow['goods_id'] . ",'" . $goodsrow['goods_name'] . "','" . $goods_sn . "',"
        . $order['timenum'] . "," . $goodPrice . ",'" . $order['good_attr_name'] . "','" . $order['good_attr_id'] . "')";
    $GLOBALS['db']->query($sql);
    client_show_message(200, true, "预约成功", 0, true, EC_CHARSET);
}


?>
