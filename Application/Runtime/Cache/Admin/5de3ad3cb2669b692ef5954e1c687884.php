<?php if (!defined('THINK_PATH')) exit();?><!-- $Id: category_info.htm 16752 2009-10-20 09:59:38Z wangleisvn $ -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>管理中心 - 添加属性 </title>
<meta name="robots" content="noindex, nofollow">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/Public/Admin/Styles/general.css" rel="stylesheet" type="text/css" />
<link href="/Public/Admin/Styles/main.css" rel="stylesheet" type="text/css" />
</head>
<body>
<h1>
    <span class="action-span"><a href="<?=U('lst?type_id'.I('get.type_id'))?>">属性列表</a></span>
    <span class="action-span1"><a href="javascript:location.reload()">管理中心</a></span>
    <span id="search_id" class="action-span1"> - 添加属性 </span>
    <div style="clear:both"></div>
</h1>
<div class="main-div">
    <form  method="POST" name="theForm" >
        <table width="100%" id="general-table">
<input type="hidden" name="id" value="<?=$data['id']?>">
            <tr>
                <td class="label">属性名称:</td>
                    <td>
                        <input type='text' name='attr_name' maxlength="20" value="<?=$data['attr_name'];?>"> <font color="red">*</font>
                    </td>
            </tr>

            <tr>
                <td class="label">属性内容:</td>
                    <td>
                    <textarea cols="50" rows="10"  name="attr_values"><?=$data['attr_values']?> </textarea>
                    </td>
            </tr> 
            
            <tr>
                <td class="label">属性可选值:</td>
                    <td>
                        <input type='radio' name='attr_type' maxlength="20" value='唯一' <?php if($data['attr_type']=='唯一') echo checked; ?>>唯一
                        <input type='radio' name='attr_type' maxlength="20" value='可选' <?php if($data['attr_type']=='可选') echo checked; ?>>可选
                         <font color="red">*</font>
                    </td>
            </tr>            
            <tr>
                <td class="label">类型选择:</td>
                    <td>
          <select name="type_id">
                <?php
 $id=(int)I('get.type_id'); foreach($tData as $k=>$v): if($id==$v['id']) $select='selected="selected"'; else $select=''; ?>
           <option  <?=$select?> value="<?=$v['id']?>"><?=$v['type_name']?></option>
    <?php endforeach;?> 
       </select>
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