<?php if (!defined('THINK_PATH')) exit();?> <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>管理中心 - 商品列表 </title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/Public/Admin/Styles/general.css" rel="stylesheet" type="text/css" />
<link href="/Public/Admin/Styles/main.css" rel="stylesheet" type="text/css" />
</head>
<body>
<h1>
    <span class="action-span"><a href="<?=U('Goods/Add') ?>">添加新商品</a></span>
    <span class="action-span1"><a href="javascript:location.reload()">管理中心</a></span>
    <span id="search_id" class="action-span1"> - 商品列表 </span>
    <div style="clear:both"></div>
</h1>
<div class="form-div">
    <form action="" name="searchForm">
        <img src="/Public/Admin/Images/icon_search.gif" width="26" height="22" border="0" alt="search" />
        <!-- 分类 -->
        <select id="c" name="cat_id">
            <option value="0">所有分类</option>                
            <?php
 $cat_id=(int)I('get.cat_id',0); foreach($catData as $k=>$v): if($cat_id==$v['id']) $selected='selected="selected"'; else $selected=''; ?>
            <option <?=$selected;?> value="<?=$v['id'];?>"><?=str_repeat('_',$v['buff']*8).$v['cat_name']?></option>
            <?php endforeach?>
        </select>
        <!-- 品牌 -->
        <?php $brand_id=I('get.brand_id/d');?>
           <?=ComboBox('brand',$brand_id,'brand','品牌分类')?>
        <!-- 推荐 -->
        <select name="intro_type">
            <option value="0">全部</option>
            <option value="is_best">精品</option>
            <option value="is_new">新品</option>
            <option value="is_hot">热销</option>
        </select>
        <!-- 上架 -->
        <select name="is_on_sale">
            <option value=''>全部</option>
            <option value="1">上架</option>
            <option value="0">下架</option>
        </select>
        <!-- 关键字 -->
        关键字 <input type="text" name="keyword" size="15" value="<?=I('get.keyword/s')?>" />
        <input type="submit" value=" 搜索 " class="button" />
    </form>
</div>

<!-- 商品列表 -->
<form method="post" action="" name="listForm" class="form_img">
    <div class="list-div" id="listDiv">
        <table cellpadding="3" cellspacing="1">
            <tr>
                <th>编号</th>
                <th>所在分类</th>
                <th>商品名称</th>               
                <th>商品图片</th>               
                <th>所属品牌</th>               
                <th>市场价格</th>
                <th>本店价格</th>
                <th>上架</th>
                <th>是否楼层</th>
                <th>总库存量</th>
                <th>操作</th>
            </tr>  
            <?php $num=1;?>                 
          <?php foreach($list as $k=>$v): $v['num']=$num++; ?>
            <tr>
                <td align="center"> <?=$v['num']?> </td>
                <td align="center"><?=$v['cat_name']?></td>
                <td align="center" class="first-cell"><span><?=$v['goods_name']?></span></td>
                <td align="center" ><span><img  class="img" src ="<?=IMG.$v['sm_logo']?>"></span></td>
                <td align="center" ><span><img  class="img" src ="<?=IMG.$v['logo']?>"></span><p><?=$v['site']?></p></td>
                <td align="center"><span onclick=""><?=$v['market_price']?></span></td>
                <td align="center"><span><?=$v['shop_price']?></span></td>
                <td align="center"><span><?=$v['is_on_sale']=='y'?'上架':'下架'?></span></td>
                <td align="center"><span><?=$v['is_folor']=='y'?'是':'否'?></span></td>
                <td align="center"><?=isset($v['number'])?$v['number']:'暂时无库存'?></td>     
                <td  width="80">        
                   <p> <a href="<?=U('edit?id='.$v['id'])?>" title="编辑">编辑</a> 
                   <a onclick="return confirm('确定删除吗');" href="<?=U('delete?id='.$v['id'])?>" onclick="" title="回收站">删除</a></p>
                    <p><a href="<?=U('goods_pic?id='.$v['id'])?>" title="相册">商品相册</a>  </p>
                    <p><a href="<?=U('member_price?id='.$v['id'])?>" title="会员价">会员价格</a>  </p>
                    <p><a href="<?=U('goods_arrt?id='.$v['id'])?>" title="商品属性">商品属性</a>  </p>
                    <p><a href="<?=U('goods_number?id='.$v['id'])?>" title="商品库存">商品库存</a>  </p>

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
    <script type="text/javascript" charset="utf-8" src="/Public/ueditor/third-party/jquery-1.10.2.min.js"></script>
<script type="text/javascript">

$('#c').change(function()
{
     location.href='?'+'cat_id'+'='+$("#c").val()+'&'+'brand_id'+'='+$("#diy").val();  

});

$('#diy').change(function()
{
     location.href='?'+'cat_id'+'='+$("#c").val()+'&'+'brand_id'+'='+$("#diy").val(); 

});


</script>