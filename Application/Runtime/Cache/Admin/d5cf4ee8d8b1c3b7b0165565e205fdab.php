<?php if (!defined('THINK_PATH')) exit();?><!-- $Id: category_info.htm 16752 2009-10-20 09:59:38Z wangleisvn $ -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>管理中心 - 修改权限 </title>
<meta name="robots" content="noindex, nofollow">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/Public/Admin/Styles/general.css" rel="stylesheet" type="text/css" />
<link href="/Public/Admin/Styles/main.css" rel="stylesheet" type="text/css" />
</head>
<body>
<h1>
    <span class="action-span"><a href="<?=U('Privilege/lst')?>">商品权限</a></span>
    <span class="action-span1"><a href="javascript:location.reload()">管理中心</a></span>
    <span id="search_id" class="action-span1"> - 添加权限 </span>
    <div style="clear:both"></div>
</h1>
<div class="main-div">
    <form  method="POST" name="theForm" >
    <input type="hidden" name="id" value="<?=$former['id'];?>" >
        <table width="100%" id="general-table">           
                      
            <tr>
                <td class="label"> 上级权限</td>
                <td>

                     <select name="parent_id">
                         <option value="0">顶级权限</option> 
                        <?php foreach($data as $k=>$v): if($former['id']==$v['id']) continue; if(in_array($v['id'],$son)) continue; if($former['parent_id']==$v['id']) $selected='selected="selected"'; else $selected=''; ?>
                         <option <?=$selected;?>value="<?=$v['id']?>"><?=str_repeat('_',$v['buff']*4).$v['pri_name']?></option>
                        
                        <?php endforeach;?>
                     

                     </select>
                </td>
            </tr>
            <tr>
                <td class="label">权限名称:</td>
                    <td>
                        <input type='text' name='pri_name' maxlength="20" value="<?=$former['pri_name'];?>" > <font color="red">*</font>
                    </td>
            </tr>
            <tr>
                <td class="label">模块名称:</td>
                    <td>
                        <input type='text' name='m_name' maxlength="20" value="<?=$former['m_name'];?>" > 
                    </td>
            </tr>   
            <tr>
                <td class="label">控制器名称:</td>
                    <td>
                        <input type='text' name='c_name' maxlength="20" value="<?=$former['c_name'];?>" > 
                    </td>
            </tr>   

            <tr>
                <td class="label">方法名称:</td>
                    <td>
                        <input type='text' name='a_name' maxlength="20" value="<?=$former['a_name'];?>" > 
                    </td>
            </tr>
            <tr>
                <td class="label">排序规则:</td>
                    <td>
                        <input type='text' name='sort_num' maxlength="20" value="<?=$former['sort_num'];?>" > 
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