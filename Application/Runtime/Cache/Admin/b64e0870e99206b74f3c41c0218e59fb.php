<?php if (!defined('THINK_PATH')) exit();?><!-- $Id: category_info.htm 16752 2009-10-20 09:59:38Z wangleisvn $ -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>管理中心 - 添加管理员 </title>
<meta name="robots" content="noindex, nofollow">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/Public/Admin/Styles/general.css" rel="stylesheet" type="text/css" />
<link href="/Public/Admin/Styles/main.css" rel="stylesheet" type="text/css" />
</head>
<body>
<h1>
    <span class="action-span"><a href="<?=U('Admin/lst')?>">管理员列表</a></span>
    <span class="action-span1"><a href="javascript:location.reload()">管理中心</a></span>
    <span id="search_id" class="action-span1"> - 添加管理员 </span>
    <div style="clear:both"></div>
</h1>
<div class="main-div">
    <form  method="POST" name="theForm" >
        <table width="100%" id="general-table">
        <input  type="hidden" name="id" value="<?=$adm['id']?>">
            <tr>  
                <td class="label">角色:</td>
                    <td>
                    <?php foreach($Role as $v): if( in_array($v['id'],$roleId) ) $check='checked'; else $check=''; ?>
                 <input <?=$check?>  name="r_id[]" type="checkbox" value="<?=$v['id'];?>" > <?=$v['role_name']?>
                    <?php endforeach;?><font color="red">*</font>
                    </td>
            </tr>
            <tr>
                <td class="label">昵称:</td>
                    <td>
                        <input type='text' name='name' maxlength="20" value="<?=$adm['name']?>" >
                    </td>
            </tr>
            <tr>
                <td class="label">账号:</td>
                    <td>
                        <input type='text' name='account' maxlength="20" value="<?=$adm['account']?>" > <font color="red">*</font>
                    </td>
            </tr>
            <tr>
                <td class="label">密码:</td>
                    <td>
                        <input type='password' name='password' maxlength="20" value='' > 
                    </td>
            </tr>
            <tr>
                <td class="label">确认密码:</td>
                    <td>
                        <input type='password' name='cpassword' maxlength="20" value='' > 
                    </td>
            </tr>
  
            <tr>

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