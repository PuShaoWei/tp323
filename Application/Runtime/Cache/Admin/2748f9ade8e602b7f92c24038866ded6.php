<?php if (!defined('THINK_PATH')) exit();?> <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>管理中心 - 商品库存量 </title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/Public/Admin/Styles/general.css" rel="stylesheet" type="text/css" />
<link href="/Public/Admin/Styles/main.css" rel="stylesheet" type="text/css" />
</head>
<body>
<h1>
    <span class="action-span"><a href="<?=U('add') ?>">添加新商品</a></span>
    <span class="action-span1"><a href="javascript:location.reload()">管理中心</a></span>
    <span id="search_id" class="action-span1"> - 商品库存量 </span>
    <div style="clear:both"></div>
</h1>

<!-- 商品库存量 -->
<form method="post" action="" name="listForm" class="form_img">
    <div class="list-div" id="listDiv">
        <table cellpadding="3" cellspacing="1">
            <tr>
            <?php foreach($aData as $k=>$v):?>
                <th><?=$v[0]['attr_name']?></th>           
            <?php endforeach;?>

            <th width="200">库存量</th>
            </tr>  
            <?php  $j=0; $row=count($storeGrop)/count($aData); ?>

            <?php for($i=0;$i<$row;$i++):?>
            <tr>
            <?php  $_str=[]; foreach($aData as $k=>$v):?>
                        <td align="center" >
                    <?php  $_arr=explode('-',$storeGrop[$j++]); echo $_arr[0]; $_str[]=$_arr[1]; ?>           
                     <input type="hidden" name="gaid[]" value="<?=$_arr[1]?>"> 
                    </td>
                    <?php endforeach; $_str=implode(',',$_str); ?> 
                     <td><input name="gn[]" type="text" value="<?=$gData[$_str]?>"></td>
                </tr>
            <?php endfor;?>

        </table>
        <div class="button-div">
            <input type="submit" value=" 确定 " >
            <input type="reset" value=" 重置 " >
        </div>
</form>

<div id="footer">特战旅商城后台2016</div>
</body>
</html>
    <script type="text/javascript" charset="utf-8" src="/Public/ueditor/third-party/jquery-1.10.2.min.js"></script>
<script type="text/javascript">

$('#c').change(function()

{
     location.href='?'+'cat_id'+'='+$("#c").val(); 

});


</script>