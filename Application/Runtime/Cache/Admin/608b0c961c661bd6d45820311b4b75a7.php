<?php if (!defined('THINK_PATH')) exit();?><!-- $Id: category_info.htm 16752 2009-10-20 09:59:38Z wangleisvn $ -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>管理中心 - 更改商品 </title>
<meta name="robots" content="noindex, nofollow">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/Public/Admin/Styles/general.css" rel="stylesheet" type="text/css" />
<link href="/Public/Admin/Styles/main.css" rel="stylesheet" type="text/css" />
</head>
<body>
<h1>
    <span class="action-span"><a href="<?=U('Category/lst')?>">商品分类</a></span>
    <span class="action-span1"><a href="javascript:location.reload()">管理中心</a></span>
    <span id="search_id" class="action-span1"> - 更改商品 </span>
    <div style="clear:both"></div>
</h1>
<div class="main-div">



<form  method="POST" name="theForm" enctype="multipart/form-data">
<!-- 
ThinkPHP当中要求 修改表单 的时候要添加一个隐藏域 -->
<input type="hidden" name="id" value="<?=$data['id']?>">
<input type="hidden" name="ologo" value="<?=$data['logo']?>">
<input type="hidden" name="osm_logo" value="<?=$data['sm_logo']?>">
<input type="hidden" name="omid_logo" value="<?=$data['mid_logo']?>">
<input type="hidden" name="obig_logo" value="<?=$data['big_logo']?>">
    

<!-- 
ThinkPHP当中要求 修改表单 的时候要添加一个隐藏域 -->
        <table width="100%" id="general-table">
             <tr>
                <td class="label">商品图片:</td>
                <td>

                    &nbsp;&nbsp;<input type="file" name="logo">
                    <img src="<?=IMG.$data['mid_logo']?>">
                </td>
            </tr>
            <tr>
                <td class="label">商品名称:</td>
                <td>
                        &nbsp;&nbsp;<input type='text' name='goods_name' maxlength="20" value="<?=$data['goods_name']?>" > <font color="red">*</font>
                </td>
            </tr>   
              <tr>
                <td class="label">商品分类:</td>
                <td>
                        &nbsp;&nbsp;<select name="cat_id">
                         <option value="">顶级分类</option>
                        <?php foreach($catData as $k=>$v): if($data['cat_id']==$v['id']) $selected='selected="selected"'; else $selected=''; ?>
                         <option <?=$selected;?> value="<?=$v['id']?>"><?=str_repeat('_',$v['buff']*4).$v['cat_name']?></option>
         
                        <?php endforeach;?>
                     </select>
                </td>
            </tr>
               <tr>
                <td class="label">商品品牌:</td>
                
                <td>
                        &nbsp;&nbsp;<select name="goods_brand">
                        <option value="" >品牌用户点这里</option>  
                        <?php foreach($brand as $k=>$v): if($data['goods_brand']==$v['id']) $selected='selected="selected"'; else $selected=''; ?>
                         <option  <?=$selected;?> value="<?=$v['id']?>"><?=$v['brand_name']?></option>
                        <?php endforeach;?>
                     </select>
                </td>
            </tr>              
            <tr>
                <td class="label">市场价格:</td>
                <td>
                    &nbsp;&nbsp;<input type="text" name="market_price"size="15" value="<?=$data['market_price']?>"> 元
                </td>
            </tr>
            <tr>
                   <tr>
                <td class="label">本店价格:</td>
                <td>
                  &nbsp;&nbsp;<input type="text" name="shop_price" size="15" value="<?=$data['shop_price']?>">元
                </td>
            </tr>             
            <tr>
                <td class="label">促销价格:</td>
                <td>
                 &nbsp;&nbsp;<input type="text" name="promote_price" size="15" value="<?= $data['promote_price']=='0.00'?'':$data['promote_price']?>">元
                </td>
            </tr>
            <tr>
                <td class="label">促销开始时间:</td>
                <td>
                  &nbsp;&nbsp;<input type="text" name="promote_start"  onClick="WdatePicker()"class="Wdate"  size="25" value="<?= $data['promote_start']=='0000-00-00 00:00:00'?'':$data['promote_start']?>">
                </td>
            </tr>            
            <tr>
                <td class="label">促销结束时间:</td>
                <td>
                   &nbsp;&nbsp;<input type="text" name="promote_end" onClick="WdatePicker()"class="Wdate"   size="25" value="<?= $data['promote_end']=='0000-00-00 00:00:00'?'':$data['promote_end']?>">
                </td>
            </tr>            
            <tr>
                <td class="label">商品描述:</td>
                <td>
                <br/>
                <script id="content" name="goods_desc" type="text/plain" style="width:600px; "><?=$data['goods_desc']?></script>
                </td>
            </tr>
            <tr>
                <td class="label">是否上架:</td>
                <td>
                    <input type="radio" name="is_on_sale" value="y" <?php if($data['is_on_sale']=='y') echo checked?> > 上架
                    <input type="radio" name="is_on_sale" value="n" <?php if($data['is_on_sale']=='n') echo checked?> > 下架  
                </td>
            </tr>
               <tr>
                <td class="label">是否新品:</td>
                <td>
                    <input type="radio" name="is_new" value="y" <?php if($data['is_new']=='y') echo checked?> >是
                    <input type="radio" name="is_new" value="n"<?php if($data['is_new']=='n') echo checked?> >否  
                </td>
            </tr>            
            <tr>
                <td class="label">是否热卖:</td>
                <td>
                    <input type="radio" name="is_hot" value="y"<?php if($data['is_hot']=='y') echo checked?> >是
                    <input type="radio" name="is_hot" value="n"<?php if($data['is_hot']=='n') echo checked?> >否  
                </td>
            </tr>            
            <tr>
                <td class="label">是否推荐:</td>
                <td>
                    <input type="radio" name="is_rec" value="y"<?php if($data['is_rec']=='y') echo checked?> >是
                    <input type="radio" name="is_rec" value="n" <?php if($data['is_rec']=='n') echo checked?> >否 
                </td>
            </tr>
             <tr>
                <td class="label">是否楼层:</td>
                <td>
                    <input type="radio" name="is_folor" value="y"<?php if($data['is_folor']=='y') echo checked?> >是
                    <input type="radio" name="is_folor" value="n" <?php if($data['is_folor']=='n') echo checked?> >否 
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
    <script type="text/javascript" charset="utf-8" src="/Public/ueditor/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="/Public/ueditor/ueditor.all.min.js"> </script>
    <!--建议手动加在语言，避免在ie下有时因为加载语言失败导致编辑器加载失败-->
    <!--这里加载的语言文件会覆盖你在配置项目里添加的语言类型，比如你在配置项目里配置的是英文，这里加载的中文，那最后就是中文-->
    <script type="text/javascript" charset="utf-8" src="/Public/ueditor/lang/zh-cn/zh-cn.js"></script>
<script type="text/javascript">
    
 UE.getEditor('content').setHeight(300);
        

   
</script>   
<script language="javascript" type="text/javascript" src="/Public/My97DatePicker/WdatePicker.js"></script>