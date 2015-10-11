<?php

function API_OrderFrame($post) {

    $goods_sn = isset($post['goodsid']) ? trim($post['goodsid']) : '';

    switch ($goods_sn) {

        //小时工 30
        case '010101':

            $serviceTime = isset($post['servicetime']) ? trim($post['servicetime']) : '';
            $province = isset($post['province']) ? trim($post['province']) : '';
            $city = isset($post['city']) ? trim($post['city']) : '';
            $district = isset($post['district']) ? trim($post['district']) : '';
            $detailAddress = isset($post['detailaddress']) ? trim($post['detailaddress']) : '';
            $tip = isset($post['tip']) ? trim($post['tip']) : '';
            $leaveword = isset($post['leaveword']) ? trim($post['leaveword']) : '';
            $uid = isset($post['user_id']) ? trim($post['user_id']) : '';
            $firstServiceTime= isset($post['firstServiceTime']) ? trim($post['firstServiceTime']) : '';
            $price= isset($post['price']) ? intval(($post['price'])) : 0;
            $consignee= isset($post['consignee']) ? trim(($post['consignee'])) : '';
            $mobile= isset($post['mobile']) ? trim(($post['mobile'])) : '';

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
            doOrder($goods_sn, $serviceTime, $province, $city, $district, $detailAddress, $good_attr_id,
                $good_attr_name, $leaveword,$firstServiceTime, $uid,$goods_amount,$order_amount,$consignee,$mobile);
            break;

        //小时工 40
        case '010102':
            $serviceTime = isset($post['servicetime']) ? trim($post['servicetime']) : '';
            $province = isset($post['province']) ? trim($post['province']) : '';
            $city = isset($post['city']) ? trim($post['city']) : '';
            $district = isset($post['district']) ? trim($post['district']) : '';
            $detailAddress = isset($post['detailaddress']) ? trim($post['detailaddress']) : '';
            $tip = isset($post['tip']) ? trim($post['tip']) : '';
            $leaveword = isset($post['leaveword']) ? trim($post['leaveword']) : '';

            doOrder($goods_sn, $serviceTime, $province, $city, $district, $detailAddress, $tip, '', $leaveword, '');
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
            // 柜机
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
                       $good_attr_name, $leaveword,$firstServiceTime, $user_id,$goods_amount,$order_amount,$consignee,$mobile,$price=-1)
{

    $order['order_sn'] = get_order_sn();
    $order['user_id'] = $user_id;
    $order['timenum'] = $serviceTime;
    $order['province'] = $province;
    $order['city'] = $city;
    $order['district'] = $district;
    $order['detailAddress'] = $detailAddress;
    $order['good_attr_id'] = $good_attr_id;
    $order['good_attr_name'] = $good_attr_name;
    $order['leaveword'] = $leaveword;
    $order['firstServiceTime'] = $firstServiceTime;
    $order['addTime'] =time();
    $order['order_status'] = 1;
    $order['pay_status'] = 0;
    $order['goods_amount'] =$goods_amount ;
    $order['order_amount'] =$order_amount ;
    $order['consignee'] =$consignee;
    $order['mobile'] =$mobile;

    $sql = "insert into " . $GLOBALS['ecs']->table('order_info') .
        "(order_sn,user_id,province,city,district,address,order_status,pay_status,postscript,country,
        first_service_time,add_time,goods_amount,order_amount,shipping_id,shipping_name,pay_id,pay_name,referer,consignee,mobile) values('" .
        $order['order_sn'] . "'," . $order['user_id'] . "," . $order['province'] . "," . $order['city'] . "," . $order['district']
        . ",'" . $order['detailAddress'] . "'," .
        $order['order_status'] . "," . $order['pay_status'] . ",'" . $order['leaveword'] . "',1,"
        . $order['firstServiceTime'] . "," . $order['addTime'] . "," . $order['goods_amount'] . "," . $order['order_amount']
        . ",5,'申通快递',2,'银行转帐','app','".$order['consignee']."','".$order['mobile']."')";

    $GLOBALS['db']->query($sql);

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
?>
