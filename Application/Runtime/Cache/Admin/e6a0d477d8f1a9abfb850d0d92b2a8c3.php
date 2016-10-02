<?php if (!defined('THINK_PATH')) exit();?>    <!-- $Id: category_info.htm 16752 2009-10-20 09:59:38Z wangleisvn $ -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>管理中心 - 添加商品相册 </title>
<meta name="robots" content="noindex, nofollow">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/Public/Admin/Styles/general.css" rel="stylesheet" type="text/css" />
<link href="/Public/Admin/Styles/main.css" rel="stylesheet" type="text/css" />
</head>
<body>
<h1>
    <span class="action-span"><a href="<?=U('Goods/lst')?>">商品列表</a></span>
    <span class="action-span1"><a href="javascript:location.reload()">管理中心</a></span>
    <span id="search_id" class="action-span1"> - 添加商品相册 </span>
    <div style="clear:both"></div>
</h1>
<div class="main-div">
    <form  method="post"  enctype="multipart/form-data">
        <table width="100%" id="general-table">    
         <div style="margin: 0 auto; width: 500px;">  
           <input id="add" type="button" name="add" value="添加商品相册" ><hr>           
                <ul id="photo-list">
                     <li ><input type="file" name="photo[]" ></li>
               </ul><hr>
            </div>
        <div id="c">       
            <?php foreach($picData as $v):?> 
            <div>
                 <img  src="<?=IMG.$v['mid_photo']?>">
                 <input class="del_img" name="<?=$v['id'];?>" type="button" value="X" >   
            </div>         
            <?php endforeach;?>
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
var count=0; 
 $('#add').click(function()
 {
    if(count ++ <5) 
    {
      $('#photo-list').append('<li ><input type="file" name="photo[]" ></li>');        
    }
 
 });       
 /************处理AJAX操作****************/
 
 $('.del_img').click(function()
 {
    if(confirm('确定要删除吗')) 
    {
        //获取当前图片的id
        var imgId=$(this).attr("name");
        //获取上一级 也就是div标签的属性
        var imgDiv=$(this).parent();

        $.ajax({
            type:"GET",
            url:"<?=U('ajaxImg','',FALSE);?>/id/"+imgId,
            success:function()
            {
                //把这个元素从页面中删除
                imgDiv.remove();
            }
        });        
    }
});
 

</script>