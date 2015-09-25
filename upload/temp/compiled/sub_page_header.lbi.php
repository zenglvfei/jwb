
<script type="text/javascript">
    var process_request = "<?php echo $this->_var['lang']['process_request']; ?>";
</script>
<div class="content logo_content">
    <a href="index.php" title="家务宝">
        <img src="themes/default/images/logo.png" alt="家务宝-logo"></a>

    <div style="float: left; width: 550px">
        <form id="searchForm" name="searchForm" method="get" action="search.php" onSubmit="return checkSearchForm()">
            <div class="search_content" style="left: 0;">
                <input name="keywords" value="" type="text"
                       placeholder="请输入服务名称 如：保洁" x-webkit-speech=""
                       lang="zh-CN"
                       style="width: 220px; color: rgb(102, 102, 102);">
                <input name="imageField" type="submit" value="" class="search_btn" style="cursor:pointer;" />
            </div>
        </form>
    </div>
    <div class="mobile">

    </div>
    <div  class="new-category">
        <ul class="category-ul">
            <li><a href="">企业洁净管家</a></li>
            <li><a href="">家庭服务</a></li>
            <li><a href="">小时工</a></li>
            <li><a href="">营养配送</a></li>
        </ul>
    </div>
    <div class="clearboth"></div>
</div>
