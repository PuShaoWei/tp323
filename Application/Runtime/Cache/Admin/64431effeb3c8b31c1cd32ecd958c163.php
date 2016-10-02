<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>管理中心 - 角色列表 </title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/Public/Admin/Styles/general.css" rel="stylesheet" type="text/css" />
<link href="/Public/Admin/Styles/main.css" rel="stylesheet" type="text/css" />
</head>
<body>
<h1>
    <span class="action-span"><a href="<?=U('Role/add') ?>">添加新角色</a></span>
    <span class="action-span1"><a href="javascript:location.reload()">管理中心</a></span>
    <span id="search_id" class="action-span1"> - 角色列表 </span>
    <div style="clear:both"></div>
</h1>
<div class="form-div">
    <form action="" name="searchForm">
        <img src="/Public/Admin/Images/icon_search.gif" width="26" height="22" border="0" alt="search" />

        <!-- 关键字 -->
        角色名称 <input type="text" name="rn" size="25" value="<?=I('get.rn')?>" />
        <input type="submit" value=" 搜索 " class="button" />
    </form>
</div>

<!-- 角色列表 -->
<form method="post" action="" name="listForm" class="form_img">
    <div class="list-div" id="listDiv">
        <table cellpadding="3" cellspacing="1">
            <tr> 
                <th>ID</th>                           
                <th>角色名称</th>                           
                <th>权限列表</th>
                <th>角色编辑</th>
            </tr>
            <?php $num=1;?>
          <?php foreach($data as $k=>$v): $v['num']=$num++; ?>
            <tr>
                <td><?=$v['num'];?></td>
                <td  class="first-cell"><span><?=$v['role_name']?></span></td>          
                <td width="1000"><?=$v['pri_name'];?></td>

                <td align="center">
                <a href="<?=U('edit?id='.$v['id'])?>" title="编辑"><img src="/Public/Admin/Images/icon_edit.gif" width="16" height="16" border="0" /></a>

                <a onclick="return confirm('确定删除吗');" href="<?=U('delete?id='.$v['id'])?>" onclick="" title="回收站"><img src="/Public/Admin/Images/icon_trash.gif" width="16" height="16" border="0" /></a></td>
            </tr>
            <?php endforeach;?>
        </table>



     </div>
</form>
<div id="footer">特战旅商城后台2016</div>
</body>
</html>