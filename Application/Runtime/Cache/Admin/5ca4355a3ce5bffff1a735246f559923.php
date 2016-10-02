<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>管理中心 - 添加商品 </title>
<meta name="robots" content="noindex, nofollow">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/Public/Admin/Styles/general.css" rel="stylesheet" type="text/css" />
<link href="/Public/Admin/Styles/main.css" rel="stylesheet" type="text/css" />
</head>
<body>
<h1>
    <span class="action-span"><a href="<?=U('Category/lst')?>">商品分类</a></span>
    <span class="action-span1"><a href="javascript:location.reload()">管理中心</a></span>
    <span id="search_id" class="action-span1"> - 添加商品 </span>
    <div style="clear:both"></div>
</h1>
<div class="main-div">
    <form  method="POST" name="theForm" enctype="multipart/form-data">
        <table width="100%" id="general-table">
<?php  $temp=[]; foreach($price as $k=>$v) { $temp[$v['level_id']]=$v['price']; } ?>
            <?php foreach($level as $k=>$v): ?>
            <tr>
                <td class="label"><?=$v['m_name']?>:</td>
                <td>
                    <input type='text' name="price[<?=$v['id']?>] " maxlength="20" value="<?=$temp[$v['id']];?>" size="10"> <font color="red">元</font>
                </td>
            </tr>   
            <?php endforeach;?>

        </table>
        <div class="button-div">
            <input type="submit" value=" 确定 " >
            <input type="reset" value=" 重置 " >
        </div>
    </form>
</div>

<div id="footer">特战旅商城后台2016</div>

</body>
</html>

<script type="text/javascript">


   
</script>