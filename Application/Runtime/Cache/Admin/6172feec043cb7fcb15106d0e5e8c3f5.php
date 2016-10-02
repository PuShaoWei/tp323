<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>管理中心 - 添加商品属性 </title>
<meta name="robots" content="noindex, nofollow">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/Public/Admin/Styles/general.css" rel="stylesheet" type="text/css" />
<link href="/Public/Admin/Styles/main.css" rel="stylesheet" type="text/css" />
</head>
<body>
<h1>
    <span class="action-span"><a href="<?=U('lst')?>">商品列表</a></span>
    <span class="action-span1"><a href="javascript:location.reload()">管理中心</a></span>
    <span id="search_id" class="action-span1"> - 添加商品属性 </span>
    <div style="clear:both"></div>
</h1>
<div class="main-div">
    <form  method="post"  enctype="multipart/form-data">
    <input type="hidden" name="deleteId" id="del_id">
        <table width="100%" id="general-table">    
            <div style="margin: 0 auto; width: 500px;">  
            <tr>    
               <td>选择类型：<?=ComboBox('type',$tid);?></td>
            </tr> 
            <tr>
               <td id="attr-list">
                   <ul>
                <?php  $_attr_id=[]; foreach($formerData as $k=>$v): if(!in_array($v['id'],$_attr_id)) { $opt='+'; $_attr_id[]=$v['id']; } else $opt='-'; ?>
                        <li>
                        <?php if($v['attr_type']=='可选'):?>
                            <a goods_attr_id="<?=$v['goods_attr_id']?>" onclick="li_add(this)" href="#">[ <?=$opt?> ]</a>
                        <?php endif;?>
                            <?=$v['attr_name']?>:
                            <?php if($v['attr_values'] !=''): $_arr=explode('，',$v['attr_values']); ?>
                            <select name="goods_attr[<?=$v['id'];?>][<?=$v['goods_attr_id']?>]" >
                                <option value="">我是一个下拉框</option>
                                <?php foreach($_arr as $k1=>$v1): if($v1==$v['attr_value']) $select='selected="selected"'; else $select=''; ?>
                                    <option <?=$select?> value="<?=$v1?>"  >  <?=$v1?></option>
                                <?php endforeach;?>
                            </select>
                            <?php else:?>
                            <input name="goods_attr[<?=$v['id'];?>][<?=$v['goods_attr_id'];?>]" type="text" value="<?=$v['attr_value']?>"> <!-- 如果下拉框是空的就代表是可选属性 所以成下拉框 -->
                            <?php endif;?> 
                        </li>
                       <?php endforeach;?>
                   </ul>
               </td>
            </tr> 
            <td><p >如果，要新增加商品的属性，就得点下【+】才可以添加进去</p></td>
             </div>
        </table>
        <div class="button-div">
            <input type="submit" value=" 确定 " />
            <input type="reset" value=" 重置 " />
        </div>
    </form>
</div>

<div id="footer">特战旅商城后台2016</div>

</body>
</html>
    <script type="text/javascript" charset="utf-8" src="/Public/ueditor/third-party/jquery-1.10.2.min.js"></script>

<script type="text/javascript">
//JQ中  通过name 选择
$("select[name=type_id]").change(function(){
    //获取当前选择的下拉框到的值是多少
    var tid =$(this).val();
    //执行ajax 提交到服务器
    $.ajax({
        type:"GET",
        //请求地址， 大U 函数 下的 读取模块属性的方法
        url:"<?=U('ajaxGetAttr','',false);?>/tid/" + tid,
        dataType:"json",//代表服务器返回的数据类型
        success:function(data) //这里的data 就代表返回的json数据了
        {
            var html="<ul>";
            //把服务器返回的json数据拼出元素放到页面中
            $(data).each(function(k,v)  //jq 里面的each相当于php里面的foreach循环
                {
                    html+='<li>';//属性名称
                    //如果是可选 状态 可以设个加号
                    if(v.attr_type=="可选")
                        html+='<a onclick="li_add(this)" href="#" >[ + ]</a>';
                    html+=v.attr_name+=":"; //属性名称

                    if(v.attr_values=="")
                        html+='<input name="new_goods_attr['+v.id+'][]" type="text"  >';
                    else                      //因为提交表单的时候考虑到要获取属性的id，还有克隆的时候会出现重名
                   {
                        html+='<select name="new_goods_attr['+v.id+'][]"><option value="">请选择我</option>';
                        //根据逗号 把数据转换成数组
                        var _attr=v.attr_values.split('，');
                        //循环每个值制作下拉项
                        $(_attr).each(function(k,v)
                        {
                            html+='<option ="'+v+'" >'+v+'</option>';
                        });
                        html+='</select>';
                   }
                      html+='</li>';//属性名称
                });
            html+='</ul>';
            //把拼好的HTML放到页面中
            $("#attr-list").html(html);//调用这个函数 然后把字符串放进去
        }

    });

});
//加减号 执行函数
function li_add(obj)
{
    // 获取点击的a标签所在的li标签
    var li = $(obj).parent();
    // 判断是+还是-
    if($(obj).html() == '[ + ]')
    {
        // 把这个LI复制一份
        var newli = $(li).clone();
        // 去掉新的记录的ID
        newli.find('a').removeAttr('goods_attr_id');
        // 新克隆出来的框名字前面有一个new_
        var sel = newli.find('select');  // 找出下拉框
        var oldname = sel.attr('name');  // 取出原名
         
        if(oldname.substring(0, 4) != 'new_')
        {
             var newname = 'new_' + oldname;  // 构造新名
            // 去掉新名字中第二个中换号里面内容
            newname = newname.replace(/\[\d+\]$/, '[]');
            sel.attr('name', newname);       // 设置新名
        }
        // 把+号变-号
        $(newli).find("a").html('[ - ]');
        // 把新的LI放到这个LI的后面
        $(li).after(newli);
    }
    else
    {
        // 先获取删除的这个属性的id
        var gaid = $(obj).attr('goods_attr_id');
        // 如果有ID就放到框中
        if(gaid != undefined)
            $("#del_id").val($("#del_id").val()+","+gaid);
        $(li).remove();
    }
    
};



</script>