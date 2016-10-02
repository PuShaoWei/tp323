<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>购物车页面</title>
	<link rel="stylesheet" href="/Public/Front/style/base.css" type="text/css">
	<link rel="stylesheet" href="/Public/Front/style/global.css" type="text/css">
	<link rel="stylesheet" href="/Public/Front/style/header.css" type="text/css">
	<link rel="stylesheet" href="/Public/Front/style/cart.css" type="text/css">
	<link rel="stylesheet" href="/Public/Front/style/footer.css" type="text/css">
	<link rel="stylesheet" href="/Public/Front/style/index.css" type="text/css">
	<link rel="stylesheet" href="/Public/Front/style/bottomnav.css" type="text/css">
	<link rel="stylesheet" href="/Public/Front/style/footer.css" type="text/css">
	<script type="text/javascript" src="/Public/Front/js/jquery-1.8.3.min.js"></script>
	<script type="text/javascript" src="/Public/Front/js/cart1.js"></script>
	
</head>
<body>
	<!-- 顶部导航 start -->
<body>
	<!-- 顶部导航 start -->
	<div class="topnav">
		<div class="topnav_bd w1210 bc">
			<div class="topnav_left">
				
			</div>
			<div class="topnav_right fr">
				<ul>
					<li id="loginfo">[<a href="<?=U('login')?>">登录</a>] [<a href="<?=U('regist')?>">免费注册</a>]</li>
					<li class="line">|</li>
					<li>我的订单</li>
					<li class="line">|</li>
					<li>客户服务</li>

				</ul>
			</div>
		</div>
	</div>
	<!-- 顶部导航 end -->
	
	<div style="clear:both;"></div>

<script>
$.ajax({
	type : "GET",
	url : "<?=U('chklogin')?>",
	dataType : "json",
	success : function(data)
	{
		if(data)
		{
			if(data.ok == 1)
				// 如果登录了就用这个字符串覆盖原来的
				$('#loginfo').html('您好，'+data.account+' [<a href="<?=U('log_out')?>">退出</a>]');		
		}
	}
});
</script>
	<!-- 顶部导航 end -->
	<div style="clear:both;"></div>
	
	<!-- 页面头部 start -->
	<div class="header w990 bc mt15">
		<div class="logo w990">
			<h2 class="fl"><a href="<?=U('index')?>"><img src="/Public/Front/images/logo.png" alt="京西商城"></a></h2>
			<div class="flow fr">
				<ul>
					<li class="cur">1.我的购物车</li>
					<li>2.填写核对订单信息</li>
					<li>3.成功提交订单</li>
				</ul>
			</div>
		</div>
	</div>
	<!-- 页面头部 end -->
	
	<div style="clear:both;"></div>

	<!-- 主体部分 start -->
	<div class="mycart w990 mt10 bc">
	<?php if(empty($_SESSION['front']['id'])):?>
	<p style="padding: 20px;font-size: 15px;border:1px solid red;">您还没有登录，赶紧登录享受更多特权吧</p>
	<?php endif;?>
		<h2><span>我的购物车</span></h2>
		<table>
			<thead>
				<tr>
					<th class="col1">商品名称</th>
					<th class="col2">商品信息</th>
					<th class="col3">单价</th>
					<th class="col4">数量</th>	
					<th class="col5">小计</th>
					<th class="col6">操作</th>
				</tr>
			</thead>
			<tbody>
			<?php
 $priceNum=0; foreach($cartData as $k=>$v):?>
				<tr>
					<td class="col1"><a href=""><img src="<?=IMG.$v['info']['sm_logo'];?>" alt="" /></a>  <strong><a href="<?=U('goods?id='.$v['goods_id'])?>">
						<?=$v['info']['goods_name']?>
					</a></strong></td>
					<td class="col2"> 
					<?php foreach($v['attr'] as $k1=>$v1):?>					
					<p><?=$v1['attr_name']?>：<?=$v1['attr_value']?></p>
					<?php endforeach;?>
					</td>					
					<td class="col3">￥<span><?=$v['price']?></span></td>
					<td class="col4"> 
						<a href="javascript:;" class="reduce_num"></a>
						<input type="text" name="amount" value="<?=$v['goods_number']?>" class="amount"/>
						<a href="javascript:;" class="add_num"></a>
					</td>				
					<td class="col5">￥<span><?=$v['price']*$v['goods_number']?></span></td>
					
					<?php $v['delete']=empty(!$_SESSION)?"<?=U('cartDelete?id='.$v[goods_attr_id])?>":"$v[goods_id]-$v[goods_attr_id];";?>
					
					<td class="col6"><a id="delete[<?=$k;?>]" href="javascript:delete(<?=$k;?>);">删除</a></td>
				</tr>
				<?php $priceNum+=$v['price']*$v['goods_number'];?>
			<?php endforeach;?>	
			</tbody>
			<tfoot>								
				<tr>
					<td colspan="6">购物金额总计： <strong>￥ <span id="total"><?=$priceNum;?></span></strong></td>
				</tr>
			</tfoot>
		</table>
		<div class="cart_btn w990 bc mt10">
			<a href="<?=U('orderInfo')?>" class="checkout">结 算</a>
		</div>
	</div>
	<!-- 主体部分 end -->
	<div style="clear:both;"></div>
		
	<div style="clear:both;"></div>

	<!-- 底部导航 start -->
	<div class="bottomnav w1210 bc mt10">
		<div class="bnav1">
			<h3><b></b> <em>购物指南</em></h3>
			<ul>
				<li><a href="">购物流程</a></li>
				<li><a href="">会员介绍</a></li>
				<li><a href="">团购/机票/充值/点卡</a></li>
				<li><a href="">常见问题</a></li>
				<li><a href="">大家电</a></li>
				<li><a href="">联系客服</a></li>
			</ul>
		</div>
		
		<div class="bnav2">
			<h3><b></b> <em>配送方式</em></h3>
			<ul>
				<li><a href="">上门自提</a></li>
				<li><a href="">快速运输</a></li>
				<li><a href="">特快专递（EMS）</a></li>
				<li><a href="">如何送礼</a></li>
				<li><a href="">海外购物</a></li>
			</ul>
		</div>

		
		<div class="bnav3">
			<h3><b></b> <em>支付方式</em></h3>
			<ul>
				<li><a href="">货到付款</a></li>
				<li><a href="">在线支付</a></li>
				<li><a href="">分期付款</a></li>
				<li><a href="">邮局汇款</a></li>
				<li><a href="">公司转账</a></li>
			</ul>
		</div>

		<div class="bnav4">
			<h3><b></b> <em>售后服务</em></h3>
			<ul>
				<li><a href="">退换货政策</a></li>
				<li><a href="">退换货流程</a></li>
				<li><a href="">价格保护</a></li>
				<li><a href="">退款说明</a></li>
				<li><a href="">返修/退换货</a></li>
				<li><a href="">退款申请</a></li>
			</ul>
		</div>

		<div class="bnav5">
			<h3><b></b> <em>特色服务</em></h3>
			<ul>
				<li><a href="">夺宝岛</a></li>
				<li><a href="">DIY装机</a></li>
				<li><a href="">延保服务</a></li>
				<li><a href="">家电下乡</a></li>
				<li><a href="">京东礼品卡</a></li>
				<li><a href="">能效补贴</a></li>
			</ul>
		</div>
	</div>
	<!-- 底部导航 end -->
		<div style="clear:both;"></div>
	<!-- 底部版权 start -->
	<div class="footer w1210 bc mt10">
		<p class="links">
			<a href="">关于我们</a> |
			<a href="">联系我们</a> |
			<a href="">人才招聘</a> |
			<a href="">商家入驻</a> |
			<a href="">千寻网</a> |
			<a href="">奢侈品网</a> |
			<a href="">广告服务</a> |
			<a href="">移动终端</a> |
			<a href="">友情链接</a> |
			<a href="">销售联盟</a> |
			<a href="">京西论坛</a>
		</p>
		<p class="copyright">
			 © 2005-2013 京东网上商城 版权所有，并保留所有权利。  ICP备案证书号:京ICP证070359号 
		</p>
		<p class="auth">
			<a href=""><img src="/Public/Front/images/xin.png" alt="" /></a>
			<a href=""><img src="/Public/Front/images/kexin.jpg" alt="" /></a>
			<a href=""><img src="/Public/Front/images/police.jpg" alt="" /></a>
			<a href=""><img src="/Public/Front/images/beian.gif" alt="" /></a>
		</p>
	</div>
	<!-- 底部版权 end -->

</body>
</html>
<script type="text/javascript">

	$('#delete[data]').click(function()
		{
			console.log('1');
			var td=$('#delete[data]').parent;				
		});


</script>