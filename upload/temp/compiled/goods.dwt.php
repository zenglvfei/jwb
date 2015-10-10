<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="Generator" content="ECSHOP v2.7.3" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Keywords" content="<?php echo $this->_var['keywords']; ?>" />
<meta name="Description" content="<?php echo $this->_var['description']; ?>" />

<title><?php echo $this->_var['page_title']; ?></title>

<link rel="shortcut icon" href="favicon.ico" />
<link rel="icon" href="animated_favicon.gif" type="image/gif" />
<link href="<?php echo $this->_var['ecs_css_path']; ?>" rel="stylesheet" type="text/css" />
<link href="themes/default/css/base.css" rel="stylesheet" type="text/css" />
    <link href="themes/default/css/goods.css" rel="stylesheet" type="text/css" />

<?php echo $this->smarty_insert_scripts(array('files'=>'common.js')); ?>
<script type="text/javascript">
function $id(element) {
  return document.getElementById(element);
}
//切屏--是按钮，_v是内容平台，_h是内容库
function reg(str){
  var bt=$id(str+"_b").getElementsByTagName("h2");
  for(var i=0;i<bt.length;i++){
    bt[i].subj=str;
    bt[i].pai=i;
    bt[i].style.cursor="pointer";
    bt[i].onclick=function(){
      $id(this.subj+"_v").innerHTML=$id(this.subj+"_h").getElementsByTagName("blockquote")[this.pai].innerHTML;
      for(var j=0;j<$id(this.subj+"_b").getElementsByTagName("h2").length;j++){
        var _bt=$id(this.subj+"_b").getElementsByTagName("h2")[j];
        var ison=j==this.pai;
        _bt.className=(ison?"":"h2bg");
      }
    }
  }
  $id(str+"_h").className="none";
  $id(str+"_v").innerHTML=$id(str+"_h").getElementsByTagName("blockquote")[0].innerHTML;
}

</script>



    
    <script type="text/javascript" id="bdshare_js" data="type=tools"></script>
    <script type="text/javascript" id="bdshell_js"></script>
    <script type="text/javascript">
        //默认分享内容
        var share = {
            "title" : '在外这么多年了，终于有让人值得信赖的保洁服务啦！  家务宝-专业家庭服务预定平台 #<?php echo $this->_var['goods']['goods_style_name']; ?># 预订地址&gt;&gt;',
            "pic" : '<?php echo $this->_var['goods']['goods_img']; ?>',
            "url" : '<?php echo $this->_var['goods']['url']; ?>'
        }
        try{
            var shareJson = JSON.parse('');
            if(shareJson){
                if(shareJson.text){
                    share.title = shareJson.text;
                }
                if(shareJson.pic){
                    share.pic = shareJson.pic;
                }
            }
        }catch(err){}
        window._bd_share_config = {
            "common" : {
                "bdStyle" : "1",
                "bdText" : share.title,
                "bdPic" : share.pic,
                "bdUrl" : "<?php echo $this->_var['goods']['url']; ?>"
            },
            "share" : {
                "bdSize" : 16
            }
        };
        with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];
        var servicesId = 209;
        var cycle = '60';
        var nowDate = new Date(1443186323246);
        var dateSelect = '';
        var limitNum = '10';
        var serviceDate;
        var serviceTime;
    </script>
    <?php echo $this->smarty_insert_scripts(array('files'=>'share.js')); ?>


</head>
<body>
<?php echo $this->fetch('library/page_header.lbi'); ?>
<?php echo $this->fetch('library/sub_page_header.lbi'); ?>


<div class="blank"></div>
<div class="block clearfix">
  
  <div class="AreaR good-area-r">
  <div class="good-right">
      <div id="goodsInfo" class="clearfix">
          <div class="textInfo">
              <form action="javascript:addToCart(<?php echo $this->_var['goods']['goods_id']; ?>)" method="post" name="ECS_FORMBUY" id="ECS_FORMBUY" >
                  <div class="clearfix">
                      <p class="f_l"><?php echo $this->_var['goods']['goods_style_name']; ?></p>
                      <p class="f_r">
                          <?php if ($this->_var['prev_good']): ?>
                          <a href="<?php echo $this->_var['prev_good']['url']; ?>"><img alt="prev" src="themes/default/images/up.gif" /></a>
                          <?php endif; ?>
                          <?php if ($this->_var['next_good']): ?>
                          <a href="<?php echo $this->_var['next_good']['url']; ?>"><img alt="next" src="themes/default/images/down.gif" /></a>
                          <?php endif; ?>
                      </p>
                  </div>
                  <ul>
                      <?php if ($this->_var['promotion']): ?>
                      <li class="padd">
                          <?php $_from = $this->_var['promotion']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
                          <?php echo $this->_var['lang']['activity']; ?>
                          <?php if ($this->_var['item']['type'] == "snatch"): ?>
                          <a href="snatch.php" title="<?php echo $this->_var['lang']['snatch']; ?>" style="font-weight:100; color:#006bcd; text-decoration:none;">[<?php echo $this->_var['lang']['snatch']; ?>]</a>
                          <?php elseif ($this->_var['item']['type'] == "group_buy"): ?>
                          <a href="group_buy.php" title="<?php echo $this->_var['lang']['group_buy']; ?>" style="font-weight:100; color:#006bcd; text-decoration:none;">[<?php echo $this->_var['lang']['group_buy']; ?>]</a>
                          <?php elseif ($this->_var['item']['type'] == "auction"): ?>
                          <a href="auction.php" title="<?php echo $this->_var['lang']['auction']; ?>" style="font-weight:100; color:#006bcd; text-decoration:none;">[<?php echo $this->_var['lang']['auction']; ?>]</a>
                          <?php elseif ($this->_var['item']['type'] == "favourable"): ?>
                          <a href="activity.php" title="<?php echo $this->_var['lang']['favourable']; ?>" style="font-weight:100; color:#006bcd; text-decoration:none;">[<?php echo $this->_var['lang']['favourable']; ?>]</a>
                          <?php endif; ?>
                          <a href="<?php echo $this->_var['item']['url']; ?>" title="<?php echo $this->_var['lang'][$this->_var['item']['type']]; ?> <?php echo $this->_var['item']['act_name']; ?><?php echo $this->_var['item']['time']; ?>" style="font-weight:100; color:#006bcd;"><?php echo $this->_var['item']['act_name']; ?></a><br />
                          <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                      </li>
                      <?php endif; ?>
                      <li class="clearfix">
                          <dd>
                              <?php if ($this->_var['cfg']['show_goodssn']): ?>
                              <strong><?php echo $this->_var['lang']['goods_sn']; ?></strong><?php echo $this->_var['goods']['goods_sn']; ?>
                              <?php endif; ?>
                          </dd>
                          <dd class="ddR">
                              <?php if ($this->_var['goods']['goods_number'] != "" && $this->_var['cfg']['show_goodsnumber']): ?>
                              <?php if ($this->_var['goods']['goods_number'] == 0): ?>
                              <strong><?php echo $this->_var['lang']['goods_number']; ?></strong>
                              <font color='red'><?php echo $this->_var['lang']['stock_up']; ?></font>
                              <?php else: ?>
                              <strong><?php echo $this->_var['lang']['goods_number']; ?></strong>
                              <?php echo $this->_var['goods']['goods_number']; ?> <?php echo $this->_var['goods']['measure_unit']; ?>
                              <?php endif; ?>
                              <?php endif; ?>
                          </dd>
                      </li>
                      <li class="clearfix">
                          <dd>
                              <?php if ($this->_var['goods']['goods_brand'] != "" && $this->_var['cfg']['show_brand']): ?>
                              <strong><?php echo $this->_var['lang']['goods_brand']; ?></strong><a href="<?php echo $this->_var['goods']['goods_brand_url']; ?>" ><?php echo $this->_var['goods']['goods_brand']; ?></a>
                              <?php endif; ?>
                          </dd>
                          <dd class="ddR">
                              <?php if ($this->_var['cfg']['show_goodsweight']): ?>
                              <strong><?php echo $this->_var['lang']['goods_weight']; ?></strong><?php echo $this->_var['goods']['goods_weight']; ?>
                              <?php endif; ?>
                          </dd>
                      </li>
                      <li class="clearfix">
                          <dd>
                              <?php if ($this->_var['cfg']['show_addtime']): ?>
                              <strong><?php echo $this->_var['lang']['add_time']; ?></strong><?php echo $this->_var['goods']['add_time']; ?>
                              <?php endif; ?>
                          </dd>
                          <dd class="ddR">
                              
                              <strong><?php echo $this->_var['lang']['goods_click_count']; ?>：</strong><?php echo $this->_var['goods']['click_count']; ?>
                          </dd>
                      </li>
                      <li class="clearfix">
                          <dd class="ddL">
                              <?php if ($this->_var['cfg']['show_marketprice']): ?>
                              <strong><?php echo $this->_var['lang']['market_price']; ?></strong><font class="market"><?php echo $this->_var['goods']['market_price']; ?></font><br />
                              <?php endif; ?>
                              
                              <strong><?php echo $this->_var['lang']['shop_price']; ?></strong><font class="shop" id="ECS_SHOPPRICE"><?php echo $this->_var['goods']['shop_price_formated']; ?></font><br />
                              <?php $_from = $this->_var['rank_prices']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'rank_price');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['rank_price']):
?>
                              <strong><?php echo $this->_var['rank_price']['rank_name']; ?>：</strong><font class="shop" id="ECS_RANKPRICE_<?php echo $this->_var['key']; ?>"><?php echo $this->_var['rank_price']['price']; ?></font><br />
                              <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                          </dd>
                          <dd style="width:48%; padding-left:7px;">
                              <strong><?php echo $this->_var['lang']['goods_rank']; ?></strong>
                              <img src="themes/default/images/stars<?php echo $this->_var['goods']['comment_rank']; ?>.gif" alt="comment rank <?php echo $this->_var['goods']['comment_rank']; ?>" />
                          </dd>
                      </li>

                      <?php if ($this->_var['volume_price_list']): ?>
                      <li class="padd">
                          <font class="f1"><?php echo $this->_var['lang']['volume_price']; ?>：</font><br />
                          <table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#aad6ff">
                              <tr>
                                  <td align="center" bgcolor="#FFFFFF"><strong><?php echo $this->_var['lang']['number_to']; ?></strong></td>
                                  <td align="center" bgcolor="#FFFFFF"><strong><?php echo $this->_var['lang']['preferences_price']; ?></strong></td>
                              </tr>
                              <?php $_from = $this->_var['volume_price_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('price_key', 'price_list');if (count($_from)):
    foreach ($_from AS $this->_var['price_key'] => $this->_var['price_list']):
?>
                              <tr>
                                  <td align="center" bgcolor="#FFFFFF" class="shop"><?php echo $this->_var['price_list']['number']; ?></td>
                                  <td align="center" bgcolor="#FFFFFF" class="shop"><?php echo $this->_var['price_list']['format_price']; ?></td>
                              </tr>
                              <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                          </table>
                      </li>
                      <?php endif; ?>

                      <?php if ($this->_var['goods']['is_promote'] && $this->_var['goods']['gmt_end_time']): ?>
                      <?php echo $this->smarty_insert_scripts(array('files'=>'lefttime.js')); ?>
                      <li class="padd loop" style="margin-bottom:5px; border-bottom:1px dashed #ccc;">
                          <strong><?php echo $this->_var['lang']['promote_price']; ?></strong><font class="shop"><?php echo $this->_var['goods']['promote_price']; ?></font><br />
                          <strong><?php echo $this->_var['lang']['residual_time']; ?></strong>
                          <font class="f4" id="leftTime"><?php echo $this->_var['lang']['please_waiting']; ?></font><br />
                      </li>
                      <?php endif; ?>
                      <li class="clearfix">
                          <dd>
                              <strong><?php echo $this->_var['lang']['amount']; ?>：</strong><font id="ECS_GOODS_AMOUNT" class="shop"></font>
                          </dd>
                          <dd class="ddR">
                              <?php if ($this->_var['goods']['give_integral'] > 0): ?>
                              <strong><?php echo $this->_var['lang']['goods_give_integral']; ?></strong><font class="f4"><?php echo $this->_var['goods']['give_integral']; ?> <?php echo $this->_var['points_name']; ?></font>
                              <?php endif; ?>
                          </dd>
                      </li>
                      <?php if ($this->_var['goods']['bonus_money']): ?>
                      <li class="padd loop" style="margin-bottom:5px; border-bottom:1px dashed #ccc;">
                          <strong><?php echo $this->_var['lang']['goods_bonus']; ?></strong><font class="shop"><?php echo $this->_var['goods']['bonus_money']; ?></font><br />
                      </li>
                      <?php endif; ?>
                      <li class="clearfix">
                          <dd>
                              <strong><?php echo $this->_var['lang']['number']; ?>：</strong>
                              <input name="number" type="text" id="number" value="1" size="4" onblur="changePrice()" style="border:1px solid #ccc; "/>
                          </dd>
                          <dd class="ddR">
                              <?php if ($this->_var['cfg']['use_integral']): ?>
                              <strong><?php echo $this->_var['lang']['goods_integral']; ?></strong><font class="f4"><?php echo $this->_var['goods']['integral']; ?> <?php echo $this->_var['points_name']; ?></font>
                              <?php endif; ?>
                          </dd>
                      </li>
                      <?php if ($this->_var['goods']['is_shipping']): ?>
                      <li style="height:30px;padding-top:4px;">
                          <?php echo $this->_var['lang']['goods_free_shipping']; ?><br />
                      </li>
                      <?php endif; ?>
                      
                      <?php $_from = $this->_var['specification']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('spec_key', 'spec');if (count($_from)):
    foreach ($_from AS $this->_var['spec_key'] => $this->_var['spec']):
?>
                      <li class="padd loop">
                          <strong><?php echo $this->_var['spec']['name']; ?>:</strong><br />
                          
                          <?php if ($this->_var['spec']['attr_type'] == 1): ?>
                          <?php if ($this->_var['cfg']['goodsattr_style'] == 1): ?>
                          <?php $_from = $this->_var['spec']['values']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'value');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['value']):
?>
                          <label for="spec_value_<?php echo $this->_var['value']['id']; ?>">
                              <input type="radio" name="spec_<?php echo $this->_var['spec_key']; ?>" value="<?php echo $this->_var['value']['id']; ?>" id="spec_value_<?php echo $this->_var['value']['id']; ?>" <?php if ($this->_var['key'] == 0): ?>checked<?php endif; ?> onclick="changePrice()" />
                              <?php echo $this->_var['value']['label']; ?> [<?php if ($this->_var['value']['price'] > 0): ?><?php echo $this->_var['lang']['plus']; ?><?php elseif ($this->_var['value']['price'] < 0): ?><?php echo $this->_var['lang']['minus']; ?><?php endif; ?> <?php echo $this->_var['value']['format_price']; ?>] </label><br />
                          <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                          <input type="hidden" name="spec_list" value="<?php echo $this->_var['key']; ?>" />
                          <?php else: ?>
                          <select name="spec_<?php echo $this->_var['spec_key']; ?>" onchange="changePrice()">
                              <?php $_from = $this->_var['spec']['values']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'value');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['value']):
?>
                              <option label="<?php echo $this->_var['value']['label']; ?>" value="<?php echo $this->_var['value']['id']; ?>"><?php echo $this->_var['value']['label']; ?> <?php if ($this->_var['value']['price'] > 0): ?><?php echo $this->_var['lang']['plus']; ?><?php elseif ($this->_var['value']['price'] < 0): ?><?php echo $this->_var['lang']['minus']; ?><?php endif; ?><?php if ($this->_var['value']['price'] != 0): ?><?php echo $this->_var['value']['format_price']; ?><?php endif; ?></option>
                              <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                          </select>
                          <input type="hidden" name="spec_list" value="<?php echo $this->_var['key']; ?>" />
                          <?php endif; ?>
                          <?php else: ?>
                          <?php $_from = $this->_var['spec']['values']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'value');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['value']):
?>
                          <label for="spec_value_<?php echo $this->_var['value']['id']; ?>">
                              <input type="checkbox" name="spec_<?php echo $this->_var['spec_key']; ?>" value="<?php echo $this->_var['value']['id']; ?>" id="spec_value_<?php echo $this->_var['value']['id']; ?>" onclick="changePrice()" />
                              <?php echo $this->_var['value']['label']; ?> [<?php if ($this->_var['value']['price'] > 0): ?><?php echo $this->_var['lang']['plus']; ?><?php elseif ($this->_var['value']['price'] < 0): ?><?php echo $this->_var['lang']['minus']; ?><?php endif; ?> <?php echo $this->_var['value']['format_price']; ?>] </label><br />
                          <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                          <input type="hidden" name="spec_list" value="<?php echo $this->_var['key']; ?>" />
                          <?php endif; ?>
                      </li>
                      <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                      
                      <li class="padd">
                          <a href="javascript:addToCart(<?php echo $this->_var['goods']['goods_id']; ?>)"><img src="themes/default/images/bnt_cat.gif" /></a>
                          <a href="javascript:collect(<?php echo $this->_var['goods']['goods_id']; ?>)"><img src="themes/default/images/bnt_colles.gif" /></a>
                          <?php if ($this->_var['affiliate']['on']): ?>
                          <a href="user.php?act=affiliate&goodsid=<?php echo $this->_var['goods']['goods_id']; ?>"><img src='themes/default/images/bnt_recommend.gif'></a>
                          <?php endif; ?>
                      </li>
                  </ul>
              </form>
          </div>
      </div>
      <?php echo $this->fetch('library/service_quality.lbi'); ?>
  </div>
  <div class="good-left">
      <h3 style="padding:0 5px;">
          <div id="tab_b" class="history clearfix">
              <div class="name"><?php echo $this->_var['goods']['goods_style_name']; ?></div>
              <div class="good-tab">
                  <h2>服务介绍</h2>
                  <h2 class="h2bg">用户点评</h2>
              </div>
          </div>
      </h3>
      <div id="tab_v" class="boxCenterList RelaArticle"></div>
      <div id="tab_h">
          <blockquote>
              <img src="<?php echo $this->_var['goods']['goods_img']; ?>"  class="good-img" alt="<?php echo htmlspecialchars($this->_var['goods']['goods_name']); ?>"/>
              <div class="share_wrap">
                  <div class="bdsharebuttonbox bdshare-button-style1-16" data-bd-bind="1443186322580">
                      <a href="<?php echo $this->_var['goods']['url']; ?>" class="bds_more" data-cmd="more">分享到：</a>
                      <a href="goods.php?id=<?php echo $this->_var['goods']['id']; ?>" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a>
                      <a href="<?php echo $this->_var['goods']['url']; ?>" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a>
                      <a href="goods.php?id=<?php echo $this->_var['goods']['id']; ?>" class="bds_renren" data-cmd="renren" title="分享到人人网"></a>
                      <a href="goods.php?id=<?php echo $this->_var['goods']['id']; ?>" class="bds_qq" data-cmd="qq" title="分享到QQ"></a>
                      <a href="goods.php?id=<?php echo $this->_var['goods']['id']; ?>" class="bds_weixin" data-cmd="weixin" title="分享到微信">微信</a>
                  </div>
              </div>

              <?php echo $this->_var['goods']['goods_desc']; ?>
          </blockquote>
          <blockquote>
              
              <?php echo $this->fetch('library/comments.lbi'); ?>
</body>
<script type="text/javascript">
var goods_id = <?php echo $this->_var['goods_id']; ?>;
var goodsattr_style = <?php echo empty($this->_var['cfg']['goodsattr_style']) ? '1' : $this->_var['cfg']['goodsattr_style']; ?>;
var gmt_end_time = <?php echo empty($this->_var['promote_end_time']) ? '0' : $this->_var['promote_end_time']; ?>;
<?php $_from = $this->_var['lang']['goods_js']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
var <?php echo $this->_var['key']; ?> = "<?php echo $this->_var['item']; ?>";
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
var goodsId = <?php echo $this->_var['goods_id']; ?>;
var now_time = <?php echo $this->_var['now_time']; ?>;


onload = function(){
  changePrice();
  fixpng();
  try {onload_leftTime();}
  catch (e) {}
    reg("tab");
}

/**
 * 点选可选属性或改变数量时修改商品价格的函数
 */
function changePrice()
{
  var attr = getSelectedAttributes(document.forms['ECS_FORMBUY']);
  var qty = document.forms['ECS_FORMBUY'].elements['number'].value;

  Ajax.call('goods.php', 'act=price&id=' + goodsId + '&attr=' + attr + '&number=' + qty, changePriceResponse, 'GET', 'JSON');
}

/**
 * 接收返回的信息
 */
function changePriceResponse(res)
{
  if (res.err_msg.length > 0)
  {
    alert(res.err_msg);
  }
  else
  {
    document.forms['ECS_FORMBUY'].elements['number'].value = res.qty;

    if (document.getElementById('ECS_GOODS_AMOUNT'))
      document.getElementById('ECS_GOODS_AMOUNT').innerHTML = res.result;
  }
}

</script>
</html>
