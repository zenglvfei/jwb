<?php

function API_OrderWash($post) {

    $goods_sn = isset($post['goodsid']) ? $post['goodsid'] : Array();
    if (count($goods_sn) == 0) {
        client_show_message(401, true, "请选择服务", 0, true, EC_CHARSET);
    }
    $common = getCommonOrderInfo($post);
    $serviceTime = isset($post['servicetime']) ? trim($post['servicetime']) : '';

    doOrder($goods_sn, $serviceTime, $common['province'], $common['city'], $common['district'], $common['detailAddress'], '',
        '', $common['leaveword'],$common['firstServiceTime'], $common['uid'],
        -1,-1,$common['consignee'],$common['mobile'],-1,$common['pay_id'],$common['pay_type'],$common['play_ayi']);

}

function API_OrderCook($post) {
    $goods_sn = isset($post['goodsid']) ? $post['goodsid'] : Array();
    if (count($goods_sn) == 0) {
        client_show_message(401, true, "请选择服务", 0, true, EC_CHARSET);
    }
    $common = getCommonOrderInfo($post);
    $serviceTime = isset($post['servicetime']) ? trim($post['servicetime']) : '';

    doOrder($goods_sn, $serviceTime, $common['province'], $common['city'], $common['district'], $common['detailAddress'], '',
        '', $common['leaveword'],$common['firstServiceTime'], $common['uid'],
        -1,-1,$common['consignee'],$common['mobile'],-1,$common['pay_id'],$common['pay_type'],$common['play_ayi']);

}

/*function API_OrderCook($post) {
    if (!isset($post['goodsid'])) {
        client_show_message(401, true, "参数错误", 0, true, EC_CHARSET);
    }
    $goods_sn = $post['goodsid'];
    $other= isset($post['other'])?$post['other']:array();
    $needHelp= isset($post['needHelp'])?$post['needHelp']:'2'; // 默认不需要
    $attr_id = Array();

    $sql = "select * from ".$GLOBALS['ecs']->table('goods') ." as y  where y.goods_sn=".$goods_sn;

     $goodInfo = $GLOBALS['db']->getRow($sql);

    $sql = "select * from ".$GLOBALS['ecs']->table('goods_attr') ." as x
    where goods_id=".$goodInfo['goods_id'];
    $attrs = $GLOBALS['db']->getAll($sql);
    $mapOther = Array();
    $mapNeedHelp= Array();
    // 找出服务的属性对应的id
    foreach ($attrs AS $row) {
        if ($row['attr_value'] == '面食') {
            $mapOther['1'] = $row['goods_attr_id'];
        }
        if ($row['attr_value'] == '点心') {
            $mapOther['2'] = $row['goods_attr_id'];
        }
        if ($row['attr_value'] == '辣') {
            $mapOther['3'] = $row['goods_attr_id'];
        }
        if ($row['attr_value'] == '不辣') {
            $mapOther['4'] = $row['goods_attr_id'];
        }
        if ($row['attr_value'] == '北方') {
            $mapOther['5'] = $row['goods_attr_id'];
        }
        if ($row['attr_value'] == '南方') {
            $mapOther['6'] = $row['goods_attr_id'];
        }
        if ($row['attr_value'] == '海鲜') {
            $mapOther['7'] = $row['goods_attr_id'];
        }
        if ($row['attr_value'] == '是') {
            $mapNeedHelp['1'] = $row['goods_attr_id'];
        }
        if ($row['attr_value'] == '否') {
            $mapNeedHelp['2'] = $row['goods_attr_id'];
        }

    }
    // 存储真正的attr_id
    foreach ($other AS $value) {
      $attr_id[] = $mapOther[$value];
    }
    $attr_id[] = $mapNeedHelp[$needHelp];

    $common = getCommonOrderInfo($post);
    $serviceTime = isset($post['servicetime']) ? trim($post['servicetime']) : '';
    $good_attr_name = get_goods_attr_info($attr_id,'pice');
    $goods_amount =$goodInfo['shop_price'];
    $order_amount = $goods_amount;
    $goodNum= isset($post['goodNum']) ? intval($post['goodNum']) : 1;
    doOrder($goods_sn, $goodNum, $common['province'], $common['city'], $common['district'], $common['detailAddress'], implode(",",$attr_id),
        $good_attr_name, $common['leaveword'],$common['firstServiceTime'], $common['uid'],
        $goods_amount,$order_amount,$common['consignee'],$common['mobile'],-1,$common['pay_id'],$common['pay_type'],$common['play_ayi']);

}*/
function API_OrderFrame($post) {

    $goods_sn = isset($post['goodsid']) ? trim($post['goodsid']) : '';

    switch ($goods_sn) {

        // 长期小时工 单保洁
        case '010202':

            $common = getCommonOrderInfo($post);
            $serviceTime = isset($post['servicetime']) ? trim($post['servicetime']) : '';
            $tip = isset($post['tip']) ? trim($post['tip']) : '';
            $price= isset($post['price']) ? intval(($post['price'])) : 0;
            $type = isset($post['type']) ? intval(($post['type'])) : 1;

            $good_attr_id = Array();
            if ($tip == 1) {
                $good_attr_id[] = 258;
            } else if ($tip == 2) {
                $good_attr_id[] = 260;
                $attr_price = 30;

            } else if ($tip == 3) {
                $good_attr_id[] = 259;
            }
            //
            if ($type == 1) {
                $good_attr_id[] = 253;
            } else {
                $good_attr_id[] = 255;
            }
            $good_attr_name = get_goods_attr_info($good_attr_id,'pice');
            $goods_amount =$price * $serviceTime + $attr_price;
            $order_amount = $goods_amount;


            doOrder($goods_sn, $serviceTime, $common['province'], $common['city'], $common['district'], $common['detailAddress'], $good_attr_id,
                $good_attr_name, $common['leaveword'],$common['firstServiceTime'], $common['uid'],
                $goods_amount,$order_amount,$common['consignee'],$common['mobile'],-1,$common['pay_id'],$common['pay_type'],$common['play_ayi']);
            break;

        // 长期小时工 做饭看小孩
        case '010203':

            $common = getCommonOrderInfo($post);
            $serviceTime = isset($post['servicetime']) ? trim($post['servicetime']) : '';
            $tip = isset($post['tip']) ? trim($post['tip']) : '';
            $price= isset($post['price']) ? intval(($post['price'])) : 0;
            $type = isset($post['type']) ? intval(($post['type'])) : 1;

            $good_attr_id = Array();
            if ($tip == 1) {
                $good_attr_id[] = 494;
            } else if ($tip == 2) {
                $good_attr_id[] = 496;
                $attr_price = 30;

            } else if ($tip == 3) {
                $good_attr_id[] = 495;
            }
            if ($type == 1) {
                $good_attr_id[] = 492;
            } else {
                $good_attr_id[] = 493;
            }
            $good_attr_name = get_goods_attr_info($good_attr_id,'pice');
            $goods_amount =$price * $serviceTime + $attr_price;
            $order_amount = $goods_amount;


            doOrder($goods_sn, $serviceTime, $common['province'], $common['city'], $common['district'], $common['detailAddress'], $good_attr_id,
                $good_attr_name, $common['leaveword'],$common['firstServiceTime'], $common['uid'],
                $goods_amount,$order_amount,$common['consignee'],$common['mobile'],-1,$common['pay_id'],$common['pay_type'],$common['play_ayi']);
            break;


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
                $goods_amount,$order_amount,$common['consignee'],$common['mobile'],-1,$common['pay_id'],$common['pay_type'],$common['play_ayi']);
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
                $goods_amount,$order_amount,$common['consignee'],$common['mobile'],-1,$common['pay_id'],$common['pay_type'],$common['play_ayi']);
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
                $goods_amount,$order_amount,$common['consignee'],$common['mobile'],-1,$common['pay_id'],$common['pay_type'],$common['play_ayi']);
            break;

        // 深度清洁-二居1卫
        case '010302':
            $common = getCommonOrderInfo($post);
            $good_attr_name = '';
            $goods_amount =580;
            $order_amount = $goods_amount;
            doOrder($goods_sn, 1, $common['province'], $common['city'], $common['district'], $common['detailAddress'], '',
                $good_attr_name, $common['leaveword'],$common['firstServiceTime'], $common['uid'],
                $goods_amount,$order_amount,$common['consignee'],$common['mobile'],-1,$common['pay_id'],$common['pay_type'],$common['play_ayi']);
            break;
        // 深度清洁-二居2卫
        case '010303':
            $common = getCommonOrderInfo($post);
            $good_attr_name = '';
            $goods_amount =650;
            $order_amount = $goods_amount;
            doOrder($goods_sn, 1, $common['province'], $common['city'], $common['district'], $common['detailAddress'], '',
                $good_attr_name, $common['leaveword'],$common['firstServiceTime'], $common['uid'],
                $goods_amount,$order_amount,$common['consignee'],$common['mobile'],-1,$common['pay_id'],$common['pay_type'],$common['play_ayi']);
            break;
        // 深度清洁-三居1卫
        case '010304':
            $common = getCommonOrderInfo($post);
            $good_attr_name = '';
            $goods_amount =720;
            $order_amount = $goods_amount;
            doOrder($goods_sn, 1, $common['province'], $common['city'], $common['district'], $common['detailAddress'], '',
                $good_attr_name, $common['leaveword'],$common['firstServiceTime'], $common['uid'],
                $goods_amount,$order_amount,$common['consignee'],$common['mobile'],-1,$common['pay_id'],$common['pay_type'],$common['play_ayi']);
            break;
        // 深度清洁-三居2卫
        case '010311':
            $common = getCommonOrderInfo($post);
            $good_attr_name = '';
            $goods_amount =830;
            $order_amount = $goods_amount;
            doOrder($goods_sn, 1, $common['province'], $common['city'], $common['district'], $common['detailAddress'], '',
                $good_attr_name, $common['leaveword'],$common['firstServiceTime'], $common['uid'],
                $goods_amount,$order_amount,$common['consignee'],$common['mobile'],-1,$common['pay_id'],$common['pay_type'],$common['play_ayi']);
            break;
        // 深度清洁-4居3卫
        case '010306':
            $common = getCommonOrderInfo($post);
            $good_attr_name = '';
            $goods_amount =980;
            $order_amount = $goods_amount;
            doOrder($goods_sn, 1, $common['province'], $common['city'], $common['district'], $common['detailAddress'], '',
                $good_attr_name, $common['leaveword'],$common['firstServiceTime'], $common['uid'],
                $goods_amount,$order_amount,$common['consignee'],$common['mobile'],-1,$common['pay_id'],$common['pay_type'],$common['play_ayi']);
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
                $goods_amount,$order_amount,$common['consignee'],$common['mobile'],-1,$common['pay_id'],$common['pay_type'],$common['play_ayi']);
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
                $goods_amount,$order_amount,$common['consignee'],$common['mobile'],-1,$common['pay_id'],$common['pay_type'],$common['play_ayi']);
            break;
        // 单独卫生间
        case '010307':
            $common = getCommonOrderInfo($post);
            $good_attr_name = '';
            $goods_amount = 210;
            $order_amount = $goods_amount;
            doOrder($goods_sn, 1, $common['province'], $common['city'], $common['district'], $common['detailAddress'], '',
                $good_attr_name, $common['leaveword'],$common['firstServiceTime'], $common['uid'],
                $goods_amount,$order_amount,$common['consignee'],$common['mobile'],-1,$common['pay_id'],$common['pay_type'],$common['play_ayi']);
            break;
        // 单独厨房
        case '010308':
            $common = getCommonOrderInfo($post);
            $good_attr_name = '';
            $goods_amount = 260;
            $order_amount = $goods_amount;
            doOrder($goods_sn, 1, $common['province'], $common['city'], $common['district'], $common['detailAddress'], '',
                $good_attr_name, $common['leaveword'],$common['firstServiceTime'], $common['uid'],
                $goods_amount,$order_amount,$common['consignee'],$common['mobile'],-1,$common['pay_id'],$common['pay_type'],$common['play_ayi']);
            break;


        // 地板打蜡
        case '010403':
            $common = getCommonOrderInfo($post);
            $good_attr_name = '';
            $goodNum= isset($post['goodNum']) ? intval($post['goodNum']) : 1;
            $goods_amount = 0;
            $order_amount = $goods_amount;
            doOrder($goods_sn, $goodNum, $common['province'], $common['city'], $common['district'], $common['detailAddress'], '',
                $good_attr_name, $common['leaveword'],$common['firstServiceTime'], $common['uid'],
                $goods_amount,$order_amount,$common['consignee'],$common['mobile'],-1,$common['pay_id'],$common['pay_type'],$common['play_ayi']);
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
                $goods_amount,$order_amount,$common['consignee'],$common['mobile'],-1,$common['pay_id'],$common['pay_type'],$common['play_ayi']);
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
                $goods_amount,$order_amount,$common['consignee'],$common['mobile'],-1,$common['pay_id'],$common['pay_type'],$common['play_ayi']);
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
                $goods_amount,$order_amount,$common['consignee'],$common['mobile'],-1,$common['pay_id'],$common['pay_type'],$common['play_ayi']);
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
                $goods_amount,$order_amount,$common['consignee'],$common['mobile'],-1,$common['pay_id'],$common['pay_type'],$common['play_ayi']);
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
                $goods_amount,$order_amount,$common['consignee'],$common['mobile'],-1,$common['pay_id'],$common['pay_type'],$common['play_ayi']);
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
                $goods_amount,$order_amount,$common['consignee'],$common['mobile'],-1,$common['pay_id'],$common['pay_type'],$common['play_ayi']);
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
                $goods_amount,$order_amount,$common['consignee'],$common['mobile'],-1,$common['pay_id'],$common['pay_type'],$common['play_ayi']);
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
                $goods_amount,$order_amount,$common['consignee'],$common['mobile'],-1,$common['pay_id'],$common['pay_type'],$common['play_ayi']);
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
                $goods_amount,$order_amount,$common['consignee'],$common['mobile'],-1,$common['pay_id'],$common['pay_type'],$common['play_ayi']);
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
                $goods_amount,$order_amount,$common['consignee'],$common['mobile'],-1,$common['pay_id'],$common['pay_type'],$common['play_ayi']);
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
                $goods_amount,$order_amount,$common['consignee'],$common['mobile'],-1,$common['pay_id'],$common['pay_type'],$common['play_ayi']);
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
                $goods_amount,$order_amount,$common['consignee'],$common['mobile'],-1,$common['pay_id'],$common['pay_type'],$common['play_ayi']);
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
                $goods_amount,$order_amount,$common['consignee'],$common['mobile'],-1,$common['pay_id'],$common['pay_type'],$common['play_ayi']);
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
            } else if($type == '3') {
                $price = 7399;
                $good_attr_id = 287;
            }
            $good_attr_name = get_goods_attr_info(Array($good_attr_id),'pice');
            $goods_amount = $price *$goodNum;
            $order_amount = $goods_amount;
            doOrder($goods_sn, $goodNum, $common['province'], $common['city'], $common['district'], $common['detailAddress'], $good_attr_id,
                $good_attr_name, $common['leaveword'],$common['firstServiceTime'], $common['uid'],
                $goods_amount,$order_amount,$common['consignee'],$common['mobile'],-1,$common['pay_id'],$common['pay_type'],$common['play_ayi']);
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
                $goods_amount,$order_amount,$common['consignee'],$common['mobile'],-1,$common['pay_id'],$common['pay_type'],$common['play_ayi']);
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
                $goods_amount,$order_amount,$common['consignee'],$common['mobile'],-1,$common['pay_id'],$common['pay_type'],$common['play_ayi']);
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
                $goods_amount,$order_amount,$common['consignee'],$common['mobile'],-1,$common['pay_id'],$common['pay_type'],$common['play_ayi']);
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
                $goods_amount,$order_amount,$common['consignee'],$common['mobile'],-1,$common['pay_id'],$common['pay_type'],$common['play_ayi']);
            break;

        // 母婴护理
        case '020001':
            $common = getCommonOrderInfo($post);
            $good_attr_name = '';
            $goodNum= isset($post['goodNum']) ? intval($post['goodNum']) : 1;
            $goods_amount = 0;
            $order_amount = $goods_amount;
            doOrder($goods_sn, $goodNum, $common['province'], $common['city'], $common['district'], $common['detailAddress'], '',
                $good_attr_name, $common['leaveword'],$common['firstServiceTime'], $common['uid'],
                $goods_amount,$order_amount,$common['consignee'],$common['mobile'],-1,$common['pay_id'],
                $common['pay_type'],$common['plan_ayi']);
            break;
        // 老人陪护
        case '020002':
            $sex= isset($post['sex']) ? intval($post['sex']) : 1;
            $good_attr_id = 0;
            if ($sex == 1) {
                $good_attr_id = 290;
            } else if ($sex== 2) {
                $good_attr_id = 291;
            }

            $good_attr_name = '老人年龄:'.$post['age'].'岁;'.get_goods_attr_info(Array($good_attr_id),'pice');
            $common = getCommonOrderInfo($post);
            $goodNum= isset($post['goodNum']) ? intval($post['goodNum']) : 1;
            $goods_amount = 0;
            $order_amount = $goods_amount;
            doOrder($goods_sn, $goodNum, $common['province'], $common['city'], $common['district'], $common['detailAddress'],$good_attr_id,
                $good_attr_name, $common['leaveword'],$common['firstServiceTime'], $common['uid'],
                $goods_amount,$order_amount,$common['consignee'],$common['mobile'],-1,$common['pay_id'],$common['pay_type'],$common['play_ayi']);
            break;
        // 育儿早教
        case '020003':
            $sex= isset($post['leaveHome']) ? intval($post['leaveHome']) : 1;
            $good_attr_id = 0;
            if ($sex == 1) {
                $good_attr_id = 288;
            } else if ($sex== 2) {
                $good_attr_id = 289;
            }

            $good_attr_name = '宝宝出生日期:'.$post['birthday'].';'.get_goods_attr_info(Array($good_attr_id),'pice');
            $common = getCommonOrderInfo($post);
            $goodNum= isset($post['goodNum']) ? intval($post['goodNum']) : 1;
            $goods_amount = 0;
            $order_amount = $goods_amount;
            doOrder($goods_sn, $goodNum, $common['province'], $common['city'], $common['district'], $common['detailAddress'], $good_attr_id,
                $good_attr_name, $common['leaveword'],$common['firstServiceTime'], $common['uid'],
                $goods_amount,$order_amount,$common['consignee'],$common['mobile'],-1,$common['pay_id'],$common['pay_type'],$common['play_ayi']);
            break;
        // 家庭医生
        case '020004':
            $common = getCommonOrderInfo($post);
            $good_attr_name = '';
            $goodNum= isset($post['goodNum']) ? intval($post['goodNum']) : 1;
            $goods_amount = 0;
            $order_amount = $goods_amount;
            doOrder($goods_sn, $goodNum, $common['province'], $common['city'], $common['district'], $common['detailAddress'], '',
                $good_attr_name, $common['leaveword'],$common['firstServiceTime'], $common['uid'],
                $goods_amount,$order_amount,$common['consignee'],$common['mobile'],-1,$common['pay_id'],$common['pay_type'],$common['play_ayi']);
            break;
        // 病人护理
        case '020005':
            $common = getCommonOrderInfo($post);
            $good_attr_name = '';
            $goodNum= isset($post['goodNum']) ? intval($post['goodNum']) : 1;
            $goods_amount = 0;
            $order_amount = $goods_amount;
            doOrder($goods_sn, $goodNum, $common['province'], $common['city'], $common['district'], $common['detailAddress'], '',
                $good_attr_name, $common['leaveword'],$common['firstServiceTime'], $common['uid'],
                $goods_amount,$order_amount,$common['consignee'],$common['mobile'],-1,$common['pay_id'],$common['pay_type'],$common['play_ayi']);
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
     $res['pay_id']= isset($post['pay_id']) ? trim($post['pay_id']) : '3';
    $res['pay_type']= isset($post['pay_type']) ? trim($post['pay_type']) : '1';
    $res['plan_ayi']= isset($post['plan_ayi']) ? trim($post['plan_ayi']) : '';
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
      $pay_id,$pay_type,$plan_ayi
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
   $cat_id = 0;
    $first_goods_sn = 0;
   if (!is_array($goods_sn)) {
       $first_goods_sn =$goods_sn;
   } else {// 洗衣洗鞋， 厨师到家
       $first_goods_sn =$goods_sn[0]['sn'];
   }
    $sql = "select goods_id ,goods_name,shop_price,cat_id from " . $GLOBALS['ecs']->table('goods') . " where goods_sn=" . $first_goods_sn. "";
    $goodsrow = $GLOBALS['db']->getRow($sql);
    $goods_id = $goodsrow['goods_id'];
    $goodsrow['final_price'] = get_final_price($goods_id, $order['timenum'], true, $order['good_attr_id']);
    $sql = "select parent_id from " . $GLOBALS['ecs']->table('category') . "where cat_id=" . $goodsrow['cat_id'] . "";
    $catrow = $GLOBALS['db']->getRow($sql);
    $cat_id = $catrow['parent_id'];

    if (!is_array($goods_sn)) {
        $order['goods_amount'] = $goodsrow['final_price']*$order['timenum'];
        $order['order_amount'] = $order['goods_amount'];
    }



    $sql = "insert into " . $GLOBALS['ecs']->table('order_info') .
        "(order_sn,user_id,province,city,district,address,order_status,pay_status,postscript,country,
        first_service_time,add_time,goods_amount,order_amount,shipping_id,shipping_name,pay_id,pay_name,
        referer,consignee,mobile,surplus,pay_type,cat_id,plan_ayi) values('" .
        $order['order_sn'] . "'," . $order['user_id'] . "," . $order['province'] . "," . $order['city'] . "," . $order['district']
        . ",'" . $order['detailAddress'] . "'," .
        $order['order_status'] . "," . $order['pay_status'] . ",'" . $order['leaveword'] . "',1,"
        . $order['firstServiceTime'] . "," . $order['addTime'] . "," . $order['goods_amount'] . "," . $order['order_amount']
        . ",8,'上门服务',".$order['pay_id'].",'".$order['pay_name']."','app','".$order['consignee']."','".$order['mobile']
        ."',".$order['surplus'].",".$order['pay_type']."," . $cat_id . ",'".$plan_ayi."')";

    $GLOBALS['db']->query($sql);

    $sql = "select order_id from " . $GLOBALS['ecs']->table('order_info') . " where order_sn='" . $order['order_sn'] . "'";

    $orderrow = $GLOBALS['db']->getRow($sql);

    // 洗衣洗鞋，厨师到家的逻辑
    if (is_array($goods_sn)) {
        $total = 0;
        foreach($goods_sn as $good) {
            $sql = "select goods_id ,goods_name,shop_price,cat_id from " . $GLOBALS['ecs']->table('goods') . "where goods_sn=" . $good['sn']. "";
            $goodsrow = $GLOBALS['db']->getRow($sql);
            $total  +=$goodsrow['shop_price']*intval($good['num']);
            $sql = "insert into " . $GLOBALS['ecs']->table('order_goods')
                . "(order_id,goods_id,goods_name,goods_sn,goods_number,goods_price,goods_attr,goods_attr_id) values (" .
                $orderrow['order_id'] . "," . $goodsrow['goods_id'] . ",'" . $goodsrow['goods_name'] . "','" . $good['sn'] . "',"
                . $good['num'] . "," . $goodsrow['shop_price'] . ",'" . $order['good_attr_name'] . "','" . $order['good_attr_id'] . "')";
            $GLOBALS['db']->query($sql);
        }
       // 更新订单价格
        $sql = "update " . $GLOBALS['ecs']->table('order_info')."set goods_amount=".$total." , order_amount=".$total." where order_id=".$orderrow['order_id'];
        $GLOBALS['db']->query($sql);
        client_show_message(200, true, "预约成功", 0, true, EC_CHARSET);

    } else {
        $goodPrice = $goodsrow['final_price'];
/*        if ($price !=-1) {
            $goodPrice  = $price ;
        }*/
        $sql = "insert into " . $GLOBALS['ecs']->table('order_goods')
            . "(order_id,goods_id,goods_name,goods_sn,goods_number,goods_price,goods_attr,goods_attr_id) values (" .
            $orderrow['order_id'] . "," . $goodsrow['goods_id'] . ",'" . $goodsrow['goods_name'] . "','" . $goods_sn . "',"
            . $order['timenum'] . "," . $goodPrice . ",'" . $order['good_attr_name'] . "','" . $order['good_attr_id'] . "')";
        $GLOBALS['db']->query($sql);

        client_show_message(200, true, "预约成功", 0, true, EC_CHARSET);
    }

}

?>
