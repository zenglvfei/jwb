<!-- $Id: bonus_by_goods.htm 14216 2008-03-10 02:27:21Z testyang $ -->
<?php echo $this->fetch('pageheader.htm'); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'../js/utils.js,selectzone.js')); ?>
<!-- 商品搜索 -->
<div class="form-div">
  <form action="javascript:searchGoods()" name="searchForm">
    <img src="images/icon_search.gif" width="26" height="22" border="0" alt="SEARCH" />
    <!-- 分类 -->
    <select name="cat_id"><option value="0"><?php echo $this->_var['lang']['all_category']; ?></caption><?php echo $this->_var['cat_list']; ?></select>
    <!-- 品牌 -->
    <select name="brand_id"><option value="0"><?php echo $this->_var['lang']['all_brand']; ?></caption><?php echo $this->html_options(array('options'=>$this->_var['brand_list'])); ?></select>
    <!-- 关键字 -->
    <input type="text" name="keyword" size="30" />
    <input type="submit" value="<?php echo $this->_var['lang']['button_search']; ?>" class="button" />
  </form>
</div>

<!-- 商品列表 -->
<div class="list-div">
<form name="theForm">
<table cellspacing='1' cellpadding='3'>
  <tr>
    <th><?php echo $this->_var['lang']['all_goods']; ?></th>
    <th><?php echo $this->_var['lang']['handler']; ?></th>
    <th><?php echo $this->_var['lang']['send_bouns_goods']; ?></th>
  </tr>
  <tr>
    <td width="45%" align="center">
      <select name="source_select" size="20" style="width:90%" ondblclick="sz.addItem(false, 'add_bonus_goods', bounsTypeId)" multiple="true">
      </select>
    </td>
    <td align="center">
      <p><input type="button" value="&gt;&gt;" onclick="sz.addItem(true, 'add_bonus_goods', bounsTypeId)" class="button" /></p>
      <p><input type="button" value="&gt;" onclick="sz.addItem(false, 'add_bonus_goods', bounsTypeId)" class="button" /></p>
      <p><input type="button" value="&lt;" onclick="sz.dropItem(false, 'drop_bonus_goods', bounsTypeId)" class="button" /></p>
      <p><input type="button" value="&lt;&lt;" onclick="sz.dropItem(true, 'drop_bonus_goods', bounsTypeId)" class="button" /></p>
    </td>
    <td width="45%" align="center">
      <select name="target_select" multiple="true" size="20" style="width:90%" ondblclick="sz.dropItem(false, 'drop_bonus_goods', bounsTypeId)">
        <?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['goods']):
?>
        <option value="<?php echo $this->_var['goods']['goods_id']; ?>"><?php echo $this->_var['goods']['goods_name']; ?></option>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
      </select>
    </td>
  </tr>
  <tr>
    <td colspan="3" align="center"><input type="button"  class="button" value="<?php echo $this->_var['lang']['send']; ?>" onClick="javascript:history.back()" /></td>
  </td>
</table>
</form>
</div>
<script language="JavaScript">
  var bounsTypeId = '<?php echo $this->_var['bonus_type']['type_id']; ?>';
  var elements    = document.forms['theForm'].elements;
  var sz          = new SelectZone(1, elements['source_select'], elements['target_select'], '');

  
  onload = function()
  {
    startCheckOrder();
  }

  function searchGoods()
  {
    var elements  = document.forms['searchForm'].elements;
    var filters   = new Object;

    filters.cat_id = elements['cat_id'].value;
    filters.brand_id = elements['brand_id'].value;
    filters.keyword = Utils.trim(elements['keyword'].value);

    sz.loadOptions('get_goods_list', filters);
  }

</script>
<?php echo $this->fetch('pagefooter.htm'); ?>