<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>管理中心 - 属性列表 </title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/Public/Admin/Styles/general.css" rel="stylesheet" type="text/css" />
<link href="/Public/Admin/Styles/main.css" rel="stylesheet" type="text/css" />
</head>
<body>
<h1>
    <span class="action-span"><a href="<?=U('add?type_id='.I('get.type_id'))?>">添加新属性</a></span>
    <span class="action-span1"><a href="javascript:location.reload()">管理中心</a></span>
    <span id="search_id" class="action-span1"> - 属性列表 </span>
    <div style="clear:both"></div>
</h1>
<div class="form-div">
    <form action="" name="searchForm">
        <img src="/Public/Admin/Images/icon_search.gif" width="26" height="22" border="0" alt="search" />

        <!-- 关键字 -->
        属性名称 <input type="text" name="rn" size="25" value="<?=I('get.rn')?>" />

       类型 <select id="c" name="type_id">
    <?php
 $id=(int)I('get.type_id'); foreach($tData as $k=>$v): if($id==$v['id']) $select='selected="selected"'; else $select=''; ?>
     <option  <?=$select?> value="<?=$v['id']?>"><?=$v['type_name']?></option>
    <?php endforeach;?> 
 </select> 
  <input type="submit" value=" 搜索 " class="button" />  


 

<!-- <?php  foreach(ComboBox('type',$id) as $v) { echo $v; } ?>  -->
    </form>
</div>

<!-- 属性列表 -->
<form method="post" action="" name="listForm" class="form_img">
    <div class="list-div" id="listDiv">
        <table cellpadding="3" cellspacing="1">
            <tr> 
                <th width="40">ID</th>                           
                <th>属性名称</th>                           
                <th>属性类型</th>                           
                <th>属性可选值</th>                           
                <th width="80">属性编辑</th>
            </tr>
            <?php $num=1;?>
          <?php foreach($data as $k=>$v): $v['num']=$num++; ?>
            <tr>
                <td><?=$v['num'];?></td>
                <td  class="first-cell"><span><?=$v['attr_name']?></span></td>          
                <td><?=$v['attr_type'];?></td>
                <td><?=$v['attr_values'];?></td>
                <td align="center">
                <a href="<?=U('edit?id='.$v['id'].'&type_id='.I('get.type_id'))?>" title="编辑"><img src="/Public/Admin/Images/icon_edit.gif" width="16" height="16" border="0" /></a>

                <a onclick="return confirm('确定删除吗');" href="<?=U('delete?id='.$v['id'].'&type_id='.I('get.type_id'))?>" onclick="" title="回收站"><img src="/Public/Admin/Images/icon_trash.gif" width="16" height="16" border="0" /></a></td>
            </tr>
            <?php endforeach;?>
        </table>

     </div>
</form>
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
<div id="footer">特战旅商城后台2016</div>
</body>
</html>
    <script type="text/javascript" charset="utf-8" src="/Public/ueditor/third-party/jquery-1.10.2.min.js"></script>
<script type="text/javascript">

$('#c').change(function()

{
     location.href= $("#c").val(); 

});


</script>