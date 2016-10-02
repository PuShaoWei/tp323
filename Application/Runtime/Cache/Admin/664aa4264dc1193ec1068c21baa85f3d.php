<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>管理中心 - 会员列表 </title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/Public/Admin/Styles/general.css" rel="stylesheet" type="text/css" />
<link href="/Public/Admin/Styles/main.css" rel="stylesheet" type="text/css" />
<style type="text/css">
</style>
</head>
<body>
<h1>
    <span class="action-span"><a href="<?=U('add') ?>">添加新会员</a></span>
    <span class="action-span1"><a href="javascript:location.reload()">管理中心</a></span>
    <span id="search_id" class="action-span1"> - 会员列表 </span>
    <div style="clear:both"></div>
</h1>

<!-- 会员列表 -->
<form method="post" action="" name="listForm" class="form_img">
    <div class="list-div" id="listDiv">
        <table cellpadding="3" cellspacing="1">
            <tr> 
                <th>编号</th>                           
                <th>级别名称</th>                           
                <th>积分上限</th>                           
                <th>积分下限</th>
                <th>级别操作</th>
            </tr>   
            <?php foreach($data as $k=>$v):?>

                <td ><?=$v['id'];?></td>  
                <td><?=$v['m_name'];?></td>                
                <td><?=$v['jf_sx'];?></td>                
                <td><?=$v['jf_xx'];?></td>
                <td align="center">
                  <a href="<?=U('edit?id='.$v['id'])?>" title="编辑"><img src="/Public/Admin/Images/icon_edit.gif" width="16" height="16" border="0" /></a>
             
                <a onclick="return confirm('确定删除吗');" href="<?=U('delete?id='.$v['id'])?>" onclick="" title="回收站"><img src="/Public/Admin/Images/icon_trash.gif" width="16" height="16" border="0" /></a>
                </td>
            </tr>
            <?php endforeach;?>
        </table>

    <!-- 分页开始 -->
        <table id="page-table" cellspacing="0" class="page">
            <tr>
                <td width="80%">&nbsp;</td>
                <td align="center" nowrap="true">
                    <?=$page?>
                </td>
            </tr>
        </table>
    <!-- 分页结束 -->

     </div>
</form>
<div id="footer">特战旅商城后台2016</div>
</body>
</html>