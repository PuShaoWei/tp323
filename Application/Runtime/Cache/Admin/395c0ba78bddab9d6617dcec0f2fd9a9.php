<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>管理中心 - 分类列表 </title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/Public/Admin/Styles/general.css" rel="stylesheet" type="text/css" />
<link href="/Public/Admin/Styles/main.css" rel="stylesheet" type="text/css" />
</head>
<body>
<h1>
    <span class="action-span"><a href="<?=U('Category/add') ?>">添加新分类</a></span>
    <span class="action-span1"><a href="javascript:location.reload()">管理中心</a></span>
    <span id="search_id" class="action-span1"> - 分类列表 </span>
    <div style="clear:both"></div>
</h1>

<!-- 商品列表 -->
<form method="post" action="" name="listForm" class="form_img">
    <div class="list-div" id="listDiv">
        <table cellpadding="3" cellspacing="1">
            <tr>
                <th>商品分类</th>                           
                <th>是否楼层</th>                           
                <th>排序字段</th>                           
                <th>分类编辑</th>
            </tr>
          <?php foreach($data as $k=>$v): ?>
            <tr>

                <td  class="first-cell"><span><?=str_repeat('_',$v['buff']*8).$v['cat_name']?></span></td>          
                <td align="center"><?=$v['is_show']=='y'?'是':'否'?></td>
                <td align="center"><?=$v['sort_num']?></td>
                <td align="center">

                <a href="<?=U('edit?id='.$v['id'])?>" title="编辑"><img src="/Public/Admin/Images/icon_edit.gif" width="16" height="16" border="0" /></a>

                <a onclick="return confirm('确定删除吗');" href="<?=U('delete?id='.$v['id'])?>" onclick="" title="回收站"><img src="/Public/Admin/Images/icon_trash.gif" width="16" height="16" border="0" /></a></td>
            </tr>
            <?php endforeach;?>
        </table>

<div id="footer">特战旅商城后台2016</div>
</body>
</html>