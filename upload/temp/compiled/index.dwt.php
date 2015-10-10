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
<link rel="alternate" type="application/rss+xml" title="RSS|<?php echo $this->_var['page_title']; ?>" href="<?php echo $this->_var['feed_url']; ?>" />

<?php echo $this->smarty_insert_scripts(array('files'=>'common.js,index.js')); ?>
</head>
<body>
<?php echo $this->fetch('library/page_header.lbi'); ?>
<div class="block clearfix">
    <div class="header-img">
        <div class="logo"></div>
        <div class="char">
            <p class="big">3000+</p>
            <p class="small">我们在为超过3000个家庭提供家庭服务</p>
            <p class="big">500+</p>
            <p class="small">全国有500+中小企业购买了我们的包年服务</p>
            <p class="big">10000+</p>
            <p class="small">超过10000人享受了我们精细化的贴心服务</p>
        </div>
    </div>
    <div class="service-phone">
        <span class="small">24h服务/</span>
        <span class="big">400-066-1010</span>
    </div>

    <div>
        <ul class="service-slogan">
            <li>
                <div class="img training"></div>
                <p class="tip">全部人员专业培训</p>
            </li>
            <li>
                <div class="img heart"></div>
                <p class="tip">最贴心的服务标准</p>
            </li>
            <li>
                <div class="img quality"></div>
                <p class="tip">100%品质保证</p>
            </li>
            <li>
                <div class="img safe"></div>
                <p class="tip">100%安全保障</p>
            </li>
        </ul>
    </div>
    <div class="slogan-content">
    </div>

    <div class="index-gooder-header">
        <div class="img"></div>
        <span>特惠商城</span>
    </div>
    <?php if ($this->_var['best_goods']): ?>
<?php if ($this->_var['cat_rec_sign'] != 1): ?>
<div class="box">
<div class="box_2 centerPadd">
  <div id="show_best_area" class="clearfix goodsBox">
  <?php endif; ?>
  <?php $_from = $this->_var['best_goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['goods']):
?>
  <div class="goodsItem">
           <a href="<?php echo $this->_var['goods']['url']; ?>"><img src="<?php echo $this->_var['goods']['thumb']; ?>" alt="<?php echo htmlspecialchars($this->_var['goods']['name']); ?>" class="goodsimg" /></a>
      <div class="content">
          <p><a href="<?php echo $this->_var['goods']['url']; ?>" title="<?php echo htmlspecialchars($this->_var['goods']['name']); ?>"><?php echo $this->_var['goods']['name']; ?></a></p>
          <font class="f1">
              <?php if ($this->_var['goods']['promote_price'] != ""): ?>
              <?php echo $this->_var['goods']['promote_price']; ?>
              <?php else: ?>
              <?php echo $this->_var['goods']['shop_price']; ?>
              <?php endif; ?>
          </font>
      </div>
        </div>
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
  <div class="more"><a href="search.php?intro=best"><img src="themes/default/images/more.gif" /></a></div>
  <?php if ($this->_var['cat_rec_sign'] != 1): ?>
  </div>
</div>
</div>
<div class="blank5"></div>
  <?php endif; ?>
<?php endif; ?>

 

<?php echo $this->fetch('library/auction.lbi'); ?>
<?php echo $this->fetch('library/group_buy.lbi'); ?>

  </div>
  
</div>
<div class="blank5"></div>
<div class="blank"></div>
<?php echo $this->fetch('library/page_footer.lbi'); ?>
</body>
</html>
