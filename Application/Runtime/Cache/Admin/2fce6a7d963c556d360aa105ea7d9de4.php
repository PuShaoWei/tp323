<?php if (!defined('THINK_PATH')) exit();?><!-- $Id: category_info.htm 16752 2009-10-20 09:59:38Z wangleisvn $ -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>管理中心 - 添加品牌 </title>
<meta name="robots" content="noindex, nofollow">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/Public/Admin/Styles/general.css" rel="stylesheet" type="text/css" />
<link href="/Public/Admin/Styles/main.css" rel="stylesheet" type="text/css" />
</head>
<body>
<h1>
    <span class="action-span"><a href="<?=U('lst')?>">品牌列表</a></span>
    <span class="action-span1"><a href="javascript:location.reload()">管理中心</a></span>
    <span id="search_id" class="action-span1"> - 添加品牌 </span>
    <div style="clear:both"></div>
</h1>
<div class="main-div">
    <form  method="POST" name="theForm" enctype="multipart/form-data" >
        <table width="100%" id="general-table">
            <tr>
                <td class="label">品牌logo:</td>
                    <td>
                      <input type="file" name="logo">
                    </td>
            </tr>
            <tr>
                <td class="label">品牌名称:</td>
                    <td>
                        <input type='text' name='brand_name' maxlength="20" value='' >   <font color="red">*</font>
                    </td>
            </tr>
                 <tr>
                <td class="label">品牌地址:</td>
                    <td>
                        <input type='text' name='site' maxlength="20" value='' >   <font color="red">*</font>
                    </td>
            </tr> 
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