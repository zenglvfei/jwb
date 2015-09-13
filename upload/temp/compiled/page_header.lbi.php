<script type="text/javascript">
var process_request = "<?php echo $this->_var['lang']['process_request']; ?>";
</script>
<div class="header-block block clearfix">
 <div class="f_l"><a href="index.php" name="top"></a></div>
 <div class="f_r log">
   <ul>
   <li class="userInfo">
   <?php echo $this->smarty_insert_scripts(array('files'=>'transport.js,utils.js')); ?>
   <font id="ECS_MEMBERZONE"><?php 
$k = array (
  'name' => 'member_info',
);
echo $this->_echash . $k['name'] . '|' . serialize($k) . $this->_echash;
?> </font>
   </li>
   <?php if ($this->_var['navigator_list']['top']): ?>
   <li id="topNav" class="clearfix">
       <a href="index.php">首页</a>
       <a href="">会员优惠</a>
       <a href="flow.php">购物车</a>
       <a href="">APP下载</a>
       <a href="" class="find-job">找工作</a>
   </li>
   <?php endif; ?>
   </ul>
 </div>
</div>
