<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>商品页面</title>
	<link rel="stylesheet" href="/Public/Front/style/base.css" type="text/css">
	<link rel="stylesheet" href="/Public/Front/style/global.css" type="text/css">
	<link rel="stylesheet" href="/Public/Front/style/header.css" type="text/css">
	<link rel="stylesheet" href="/Public/Front/style/goods.css" type="text/css">
	<link rel="stylesheet" href="/Public/Front/style/common.css" type="text/css">
	<link rel="stylesheet" href="/Public/Front/style/bottomnav.css" type="text/css">
	<link rel="stylesheet" href="/Public/Front/style/footer.css" type="text/css">
	<!--引入jqzoom css -->
	<link rel="stylesheet" href="/Public/Front/style/jqzoom.css" type="text/css">
	<script type="text/javascript" src="/Public/Front/js/jquery-1.8.3.min.js"></script>
	<script type="text/javascript" src="/Public/Front/js/header.js"></script>
	<script type="text/javascript" src="/Public/Front/js/goods.js"></script>
	<script type="text/javascript" src="/Public/Front/js/jqzoom-core.js"></script>
	
	<!-- jqzoom 效果 -->
	<script type="text/javascript">
		$(function(){
			$('.jqzoom').jqzoom({
	            zoomType: 'standard',
	            lens:true,
	            preloadImages: false,
	            alwaysOn:false,
	            title:false,
	            zoomWidth:400,
	            zoomHeight:400
	        });
		})
	</script>
</head>
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
<!-- 头部 start -->
	<div class="header w1210 bc mt15">
		<!-- 头部上半部分 start 包括 logo、搜索、用户中心和购物车结算 -->
		<div class="logo w1210">
			<h1 class="fl"><a href="<?=U('index/index')?>"><img src="/Public/Front/images/logo.png" alt="京西商城"></a></h1>
			<!-- 头部搜索 start -->
			<div class="search fl">
				<div class="search_form">
					<div class="form_left fl"></div>
					<form action="" name="serarch" method="get" class="fl">
						<input type="text" class="txt" value="请输入商品关键字" /><input type="submit" class="btn" value="搜索" />
					</form>
					<div class="form_right fl"></div>
				</div>
				
				<div style="clear:both;"></div>

				<div class="hot_search">
					<strong>热门搜索:</strong>
					<a href="">D-Link无线路由</a>
					<a href="">休闲男鞋</a>
					<a href="">TCL空调</a>
					<a href="">耐克篮球鞋</a>
				</div>
			</div>
			<!-- 头部搜索 end -->

			<!-- 用户中心 start-->
			<div class="user fl">
				<dl>
					<dt>
						<em></em>
						<a href="">用户中心</a>
						<b></b>
					</dt>
					<dd>
						<div class="prompt">
							您好，请<a href="<?=U('login')?>">登录</a>
						</div>
						<div class="uclist mt10">
							<ul class="list1 fl">
								<li><a href="">用户信息></a></li>
								<li><a href="">我的订单></a></li>
								<li><a href="">收货地址></a></li>
								<li><a href="">我的收藏></a></li>
							</ul>

							<ul class="fl">
								<li><a href="">我的留言></a></li>
								<li><a href="">我的红包></a></li>
								<li><a href="">我的评论></a></li>
								<li><a href="">资金管理></a></li>
							</ul>

						</div>
						<div style="clear:both;"></div>
						<div class="viewlist mt10">
							<h3>最近浏览的商品：</h3>
							<ul>
								<li><a href=""><img src="/Public/Front/images/view_list1.jpg" alt="" /></a></li>
								<li><a href=""><img src="/Public/Front/images/view_list2.jpg" alt="" /></a></li>
								<li><a href=""><img src="/Public/Front/images/view_list3.jpg" alt="" /></a></li>
							</ul>
						</div>
					</dd>
				</dl>
			</div>
			<!-- 用户中心 end-->

			<!-- 购物车 start -->
			<div class="cart fl">
				<dl>
					<dt>
						<a href="">去购物车结算</a>
						<b></b>
					</dt>
					<dd>
						<div class="prompt">
							购物车中还没有商品，赶紧选购吧！
						</div>
					</dd>
				</dl>
			</div>
			<!-- 购物车 end -->
		</div>

		<div style="clear:both;"></div>
		<!-- 导航条部分 start -->
		<div class="nav w1210 bc mt10">
			<!--  商品分类部分 start-->
			<div class="category fl <?php if([open] != 1): ?>cat1<?php endif; ?>"> <!-- 非首页，需要添加cat1类 -->
				<div class="cat_hd <?php if([open] != 1): ?>off<?php endif; ?>">  <!-- 注意，首页在此div上只需要添加cat_hd类，非首页，默认收缩分类时添加上off类，鼠标滑过时展开菜单则将off类换成on类 -->
					<h2>全部商品分类</h2>
					<em></em>
				</div>				
				<div class="cat_bd <?php if([open] != 1): ?>none<?php endif; ?>">
					<?php foreach($Category as $k => $v): ?>
					<div class="cat <?php if($k==0) echo 'item1'; ?>">
						<h3><a href=""><?=$v['cat_name']?></a> <b></b></h3>
						<div class="cat_detail">
							<?php foreach($v['children'] as $k1 => $v1): ?>
								<dl <?php if($k1==0) echo 'class="dl_1st"'; ?>>
									<dt><a href=""><?=$v1['cat_name']?></a></dt>
									<dd>
										<?php foreach($v1['children'] as $k2 => $v2): ?>
											<a href="<?=U('search?cid='.$v2['id'])?>"><?=$v2['cat_name']?></a>				
										<?php endforeach; ?>
									</dd>
								</dl>
							<?php endforeach; ?>
						</div>
					</div>
					<?php endforeach; ?>
				</div>

			</div>
			<!--  商品分类部分 end--> 

			<div class="navitems fl">
				<ul class="fl">
					<li class="current"><a href="">首页</a></li>
					<li><a href="">电脑频道</a></li>
					<li><a href="">家用电器</a></li>
					<li><a href="">品牌大全</a></li>
					<li><a href="">团购</a></li>
					<li><a href="">积分商城</a></li>
					<li><a href="">夺宝奇兵</a></li>
				</ul>
				<div class="right_corner fl"></div>
			</div>
		</div>
		<!-- 导航条部分 end -->
	</div>
	<!-- 头部 end-->
	
	<div style="clear:both;"></div>
	<!-- 商品页面主体 start -->
	<div class="main w1210 mt10 bc">
		<!-- 面包屑导航 start -->
		<div class="breadcrumb">
			<h2 id="category">当前位置：<a href="">首页</a> > <a href="">电脑、办公</a> > <a href="">笔记本</a> >></h2>
		</div>
		<!-- 面包屑导航 end -->
		
		<!-- 主体页面左侧内容 start -->
		<div class="goods_left fl">
			<!-- 相关分类 start -->
			<div class="related_cat leftbar mt10">
				<h2><strong>相关分类</strong></h2>
				<div class="leftbar_wrap">
					<ul>
						<li><a href="">笔记本</a></li>
						<li><a href="">超极本</a></li>
						<li><a href="">平板电脑</a></li>
					</ul>
				</div>
			</div>
			<!-- 相关分类 end -->

			<!-- 相关品牌 start -->
			<div class="related_cat	leftbar mt10">
				<h2><strong>同类品牌</strong></h2>
				<div class="leftbar_wrap">
					<ul>
						<li><a href="">D-Link</a></li>
						<li><a href="">戴尔</a></li>
						<li><a href="">惠普</a></li>
						<li><a href="">苹果</a></li>
						<li><a href="">华硕</a></li>
						<li><a href="">宏基</a></li>
						<li><a href="">神舟</a></li>
					</ul>
				</div>
			</div>
			<!-- 相关品牌 end -->

			<!-- 热销排行 start -->
			<div class="hotgoods leftbar mt10">
				<h2><strong>热销排行榜</strong></h2>
				<div class="leftbar_wrap">
					<ul>
						<li></li>
					</ul>
				</div>
			</div>
			<!-- 热销排行 end -->


			<!-- 浏览过该商品的人还浏览了  start 注：因为和list页面newgoods样式相同，故加入了该class -->
			<div class="related_view newgoods leftbar mt10">
				<h2><strong>浏览了该商品的用户还浏览了</strong></h2>
				<div class="leftbar_wrap">
					<ul>
						<li>
							<dl>
								<dt><a href=""><img src="/Public/Front/images/relate_view1.jpg" alt="" /></a></dt>
								<dd><a href="">ThinkPad E431(62771A7) 14英寸笔记本电脑 (i5-3230 4G 1TB 2G独显 蓝牙 win8)</a></dd>
								<dd><strong>￥5199.00</strong></dd>
							</dl>
						</li>

						<li>
							<dl>
								<dt><a href=""><img src="/Public/Front/images/relate_view2.jpg" alt="" /></a></dt>
								<dd><a href="">ThinkPad X230i(2306-3V9） 12.5英寸笔记本电脑 （i3-3120M 4GB 500GB 7200转 蓝牙 摄像头 Win8）</a></dd>
								<dd><strong>￥5199.00</strong></dd>
							</dl>
						</li>

						<li>
							<dl>
								<dt><a href=""><img src="/Public/Front/images/relate_view3.jpg" alt="" /></a></dt>
								<dd><a href="">T联想（Lenovo） Yoga13 II-Pro 13.3英寸超极本 （i5-4200U 4G 128G固态硬盘 摄像头 蓝牙 Win8）晧月银</a></dd>
								<dd><strong>￥7999.00</strong></dd>
							</dl>
						</li>

						<li>
							<dl>
								<dt><a href=""><img src="/Public/Front/images/relate_view4.jpg" alt="" /></a></dt>
								<dd><a href="">联想（Lenovo） Y510p 15.6英寸笔记本电脑（i5-4200M 4G 1T 2G独显 摄像头 DVD刻录 Win8）黑色</a></dd>
								<dd><strong>￥6199.00</strong></dd>
							</dl>
						</li>

						<li class="last">
							<dl>
								<dt><a href=""><img src="/Public/Front/images/relate_view5.jpg" alt="" /></a></dt>
								<dd><a href="">ThinkPad E530c(33662D0) 15.6英寸笔记本电脑 （i5-3210M 4G 500G NV610M 1G独显 摄像头 Win8）</a></dd>
								<dd><strong>￥4399.00</strong></dd>
							</dl>
						</li>					
					</ul>
				</div>
			</div>
			<!-- 浏览过该商品的人还浏览了  end -->

			<!-- 最近浏览 start -->
			<div class="viewd leftbar mt10">
				<h2><a href="">清空</a><strong>最近浏览过的商品</strong></h2>
				<div class="leftbar_wrap">
					<dl>
						<dt><a href=""><img src="/Public/Front/images/hpG4.jpg" alt="" /></a></dt>
						<dd><a href="">惠普G4-1332TX 14英寸笔记...</a></dd>
					</dl>

					<dl class="last">
						<dt><a href=""><img src="/Public/Front/images/crazy4.jpg" alt="" /></a></dt>
						<dd><a href="">直降200元！TCL正1.5匹空调</a></dd>
					</dl>
				</div>
			</div>
			<!-- 最近浏览 end -->

		</div>
		<!-- 主体页面左侧内容 end -->
		
		<!-- 商品信息内容 start -->
		<div class="goods_content fl mt10 ml10">
			<!-- 商品概要信息 start -->
			<div class="summary">
				<h3><strong><?=$goods['goods_name']?></strong></h3>
				

				<!-- 图片预览区域 start -->
				<div class="preview fl">
					<div class="midpic">
						<a href="<?=IMG.$goods['logo']?>" class="jqzoom" rel="gal1">   <!-- 第一幅图片的大图 class 和 rel属性不能更改 -->
							<img style="width: 350px;height: 350px" src="<?=IMG.$goods['big_logo']?>" alt="" />               <!-- 第一幅图片的中图 -->
						</a>
					</div>
	
					<!--使用说明：此处的预览图效果有三种类型的图片，大图，中图，和小图，取得图片之后，分配到模板的时候，把第一幅图片分配到 上面的midpic 中，其中大图分配到 a 标签的href属性，中图分配到 img 的src上。 下面的smallpic 则表示小图区域，格式固定，在 a 标签的 rel属性中，分别指定了中图（smallimage）和大图（largeimage），img标签则显示小图，按此格式循环生成即可，但在第一个li上，要加上cur类，同时在第一个li 的a标签中，添加类 zoomThumbActive  -->

					<div class="smallpic">
						<a href="javascript:;" id="backward" class="off"></a>
						<a href="javascript:;" id="forward" class="on"></a>
						<div class="smallpic_wrap">
							<ul>
								<li class="cur">
									<a class="zoomThumbActive" href="javascript:void(0);" rel="{gallery: 'gal1', smallimage: '<?=IMG.$goods['big_logo']?>',largeimage: '<?=IMG.$goods['logo']?>'}"><img src="<?=IMG.$goods['sm_logo']?>"></a>
								</li>
								<?php foreach($photo as $v):?>
								<li>
									<a href="javascript:void(0);" rel="{gallery: 'gal1', smallimage: '<?=IMG.$v['big_photo']?>',largeimage: '<?=IMG.$v['photo']?>'}"><img src="<?=IMG.$v['sm_photo']?>"></a>
								</li>
								<?php endforeach;?>
							</ul>
						</div>
					</div>
				</div>
				<!-- 图片预览区域 end -->
				<!-- 商品基本信息区域 start -->
				<div class="goodsinfo fl ml10">
					<ul>
						<li><span>商品编号： </span><?=$goods['id']?></li>
						<li class="market_price"><span>市场定价：</span><em>￥<?=$goods['market_price']?></em></li>
						<li class="shop_price"><span>本店价格：</span> <strong id="price">￥<?=$price?></strong> <a href="">(降价通知)</a></li>
						<li><span>上架时间：</span><?=$goods['addtime']?></li>
						<li class="star"><span>商品评分：</span> <strong></strong><a href="">(已有21人评价)</a></li> <!-- 此处的星级切换css即可 默认为5星 star4 表示4星 star3 表示3星 star2表示2星 star1表示1星 -->
					</ul>
					<form action="<?=U('CartDispose');?>" method="post" class="choose">
						<input type="hidden" name="goods_id"value="<?=I('get.id/d');?>">
						<ul>
						<?php foreach($attr['noSole'] as $k=>$v):?>
							<li class="product">
								<dl>
									<dt><?=$v[0]['attr_name']?>： </dt>
									<dd>
										<?php foreach($v as $k1=>$v1):?>
										<a 	<?php if($k1 == 0) echo 'class="selected"';?> href="javascript:;"><?=$v1['attr_value']?> 
										<input type="radio" name="goods_attr_id[<?=$k?>]" value="<?=$v1['id']?>" <?php if($k1==0) echo 'checked';?>  /></a>
										<?php endforeach;?>
									</dd>
								</dl>
							</li>
							<?php endforeach;?>							
							<li>
								<dl>
									<dt>购买数量：</dt>
									<dd>
										<a href="javascript:;" id="reduce_num"></a>
										<input type="text" name="goods_number" value="1" class="amount"/>
										<a href="javascript:;" id="add_num"></a>
									</dd>
								</dl>
							</li>

							<li>
								<dl>
									<dt>&nbsp;</dt>
									<dd>
										<input type="submit" value="" class="add_btn" />
									</dd>
								</dl>
							</li>

						</ul>
					</form>
				</div>
				<!-- 商品基本信息区域 end -->
			</div>
			<!-- 商品概要信息 end -->
			
			<div style="clear:both;"></div>

			<!-- 商品详情 start -->
			<div class="detail">
				<div class="detail_hd">
					<ul>
						<li class="first"><span>商品介绍</span></li>
						<li class="on"><span>商品评价</span></li>
						<li><span>售后保障</span></li>
					</ul>
				</div>
				<div class="detail_bd">
					<!-- 商品介绍 start -->
					<div class="introduce detail_div none">
						<div class="attr mt15">
							<ul>
							<?php foreach($attr['sole'] as $v):?>
								<li><span><?=$v['attr_name']?>：</span><?=$v['attr_value']?></li>		
							<?php endforeach;?>			
							</ul>
						</div>

						<div class="desc mt10">
							<!-- 此处的内容 一般是通过在线编辑器添加保存到数据库，然后直接从数据库中读出 -->
							<?=$goods['goods_desc']?>
						</div>
					</div>
					<!-- 商品介绍 end -->
					
					<!-- 商品评论 start -->
					<div class="comment detail_div mt10">
						<div class="comment_summary">
							<div class="rate fl">
								<strong><em><span class="hao"></span></em>%</strong> 
								<span>好评度</span>
							</div>
							<div class="percent fl">
								<dl>
									<dt>好评（<span class="hao"></span>）</dt>
									<dd><div class="hao_div"></div></dd>
								</dl>
								<dl>
									<dt>中评（<span class="zhong"></span>）</dt>
									<dd><div class="zhong_div"></div></dd>
								</dl>
								<dl>
									<dt>差评（<span class="cha"></span>）</dt>
									<dd><div class="cha_div"></div></dd>
								</dl>
							</div>
							<div class="buyer fl">
								<dl id="yingxiang">
									
								</dl>
							</div>
						</div>

						<div id="remark"> </div>
						

						<!-- 分页信息 start -->
						<div  id="testPage" class="page mt20"></div>
						<!-- 分页信息 end -->
						<!--  评论表单 start-->
						<div class="comment_form mt20">
					<?php if($_SESSION['front'][id]):?>
							<form action="#" id="addRemark" >
									<ul>
									<li>
										<label for=""> 评分：</label>
										<input value="<?=I('get.id/d')?>" name="goods_id"type="hidden">
										<input value="5" type="radio" name="star" checked/> <strong class="star star5"></strong>
										<input value="4"  type="radio" name="star"/> <strong class="star star4"></strong>
										<input value="3"  type="radio" name="star"/> <strong class="star star3"></strong>
										<input value="2"  type="radio" name="star"/> <strong class="star star2"></strong>
										<input value="1" type="radio" name="star"/> <strong class="star star1"></strong>
									</li>
									<li>
										<label for="">买家映像：</label>
									<input type="text" name="yx">
									</li>
									<li>
										<label for="">评价内容：</label>
										<textarea name="content"   rows=""></textarea>
									</li>
									<li>
									<?php $time=time(); $Ctime=isset($_SESSION['time'])?$_SESSION['time']:0;?>
										<div id="captchaDiv" style="display:none"><img id="form-img" style="width: 200px;height: 50px;"  onclick="this.src='<?=U('captcha')?>?'+Math.random();" src="<?=U('captcha')?>" alt=""/><input type="text" name="captcha" size="5">请输入验证码,要是不想输入就过两分钟来就没了(*^__^*) </div>

									<script type="text/javascript">
										var time="<?=$time?>";
										var Ctime="<?=$Ctime?>";
											if(time - Ctime >120)
												$('#captchaDiv').css("display",'none');
											else
												$('#captchaDiv').css("display",'inline');
									</script>																			
										<input type="hidden" value="1" name="ip" />
										<label for="">&nbsp;</label>
										<input type="button" value="提交评论"  class="comment_btn" onclick="add_remark()" />			
									</li>
									<li>
									</li>
										<li id="img-AJAX" ></li>
<iframe style="display: none;" name="upload" width="500" height="500"></iframe>
								</ul>
							</form>
				<?php else:?>
							<form action="#" id="onclickLogin"></form>
							<script type="text/javascript">
								if($('#onclickLogin'))
	$('#onclickLogin').html('<p>登录后才可以参与评论的吼~~，老子现在就	<a href="<?=U('login')?>">登录</a></p>');
							</script>
				<?php endif;?>
<form  id="upload-list" target="upload" method="POST" enctype="multipart/form-data" action="<?=U('AJAXImg')?>">
	<input id="upload-none"  onchange="document.getElementById('upload-list').submit();document.getElementById('upload-list').reset();" type="file" name="ajaxImg">
</form>
					</div>
					<!-- 商品评论 end -->
					<!-- 售后保障 start -->
					<div class="after_sale mt15 none detail_div">
						<div>
							<p>本产品全国联保，享受三包服务，质保期为：一年质保 <br />如因质量问题或故障，凭厂商维修中心或特约维修点的质量检测证明，享受7日内退货，15日内换货，15日以上在质保期内享受免费保修等三包服务！</p>
							<p>售后服务电话：800-898-9006 <br />品牌官方网站：http://www.lenovo.com.cn/</p>

						</div>

						<div>
							<h3>服务承诺：</h3>
							<p>本商城向您保证所售商品均为正品行货，京东自营商品自带机打发票，与商品一起寄送。凭质保证书及京东商城发票，可享受全国联保服务（奢侈品、钟表除外；奢侈品、钟表由本商城联系保修，享受法定三包售后服务），与您亲临商场选购的商品享受相同的质量保证。本商城还为您提供具有竞争力的商品价格和运费政策，请您放心购买！</p> 
							
							<p>注：因厂家会在没有任何提前通知的情况下更改产品包装、产地或者一些附件，本司不能确保客户收到的货物与商城图片、产地、附件说明完全一致。只能确保为原厂正货！并且保证与当时市场上同样主流新品一致。若本商城没有及时更新，请大家谅解！</p>

						</div>
						
						<div>
							<h3>权利声明：</h3>
							<p>本商城上的所有商品信息、客户评价、商品咨询、网友讨论等内容，是京东商城重要的经营资源，未经许可，禁止非法转载使用。</p>
							<p>注：本站商品信息均来自于厂商，其真实性、准确性和合法性由信息拥有者（厂商）负责。本站不提供任何保证，并不承担任何法律责任。</p>

						</div>
					</div>
					<!-- 售后保障 end -->

				</div>
			</div>
			<!-- 商品详情 end -->

			
		</div>
		<!-- 商品信息内容 end -->		

	</div>
	<!-- 商品页面主体 end -->

	
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
	$.ajax({
		type:"GET",
		url:"<?=U('getPrice?id='.I('get.id/d'))?>", 
		dataType:"json",
		success:function(data)
		{
			if(data.ok==1)
			{
				//那么就运用ajax技术把值放进去
				$('#price').html(data.presentPrice);
			}
		}
	});

	/****************************商品分类*******************/
	$.ajax({
		type:"GET",
		url:"<?=U('AJAXcategory?id='.I('get.id/d'))?>",
		dataType:"json",
		success:function(data)
		{
			if(data.ok==1)
			{
				$('#category').html(data.category+" ><?=$goods['goods_name']?>");
			}
		}
	});

//获取某一页数据并放到页面中

function getRemark(p)
{
	var pl='';
	$.ajax({
		type:"GET",
		url:"<?=U('get_reark?id='.I('get.id'),'',FALSE)?>/page/"+p+"/ac.html",
		dataType:"json",//解析JSON
		success:function(data)
		{
			if(p==1)
			{
				//加载好中差评
				$(".hao").html(data.hao);
				$(".zhong").html(data.zhong);
				$(".cha").html(data.cha);
				$(".hao_div").css('width',data.hao);
				$(".zhong_div").css('width',data.zhong);
				$(".cha_div").css('width',data.cha); 				
				//加载映像
					var yx='<dt>买家印象';
					$(data.Idata).each(function(k,v)
					{
						yx+='<dd><span>'+v.imp_name+'</span><em>('+v.imp_count+')</em></dd>';

					});
					yx+='</dt>';
					$('#yingxiang').html(yx);
			}

			$(data.Rdata).each(function(k,v)
			{
				var img='';
				//取出图片
				if(v.pic !=null)
				{    
					var _img=	v.pic.split(','); //根据逗号整成数组
					$(_img).each(function(k1,v1){
						img+=' <img src="'+v1+'"> ';
					});
				}
			pl +='<div class="comment_items mt10 " ><div class="user_pic" > <dl> <dt><a href=""><img src="/Public/Front/images/user1.gif" alt="" /></a></dt> <dd><a href="">'+v.account+'</a></dd> </dl> </div> <div class="item"> <div class="title"> <span>'+v.addtime+'</span> <strong class="star star'+v.star+'"></strong></div> <div class="comment_content"> <dl>'+v.content+'</dl>  </dl> '+img+' </div> <div class="btns"> <a href="#" class="reply">回复('+v.zan_num+')</a> <a href="#" class="useful">有用('+v.zan_num+')</a> </div> </div> <div class="cornor"></div></div>';
			});
			//放到页面中并覆盖前面的
			$('#remark').html(pl);

			//形成翻页字符串
			var pStr='';
				 pStr+='<a href="javascript:getRemark('+ 1 +');">首页</a>';
				pStr+='<a href="javascript:getRemark('+(p-1)+');">上一页</a>';
			for(var i=1; i<=data.pageCount;i++)
			{
				if(p==i)
					var sel ='class="cur"';
				else
					var sel ='';
				pStr+='<a href="javascript:getRemark('+i+'); "'+sel+'>'+i+'</a>';
			}
			 pStr+='<a href="javascript:getRemark('+(p+1)+');">下一页</a>';
			 pStr+='<a href="javascript:getRemark('+data.pageCount+');">尾页</a>';
			$('#testPage').html(pStr);
		}
	});
}
//取评论
getRemark(1);



function add_remark(){
	//收集表单中的数据
	$('#form-img').attr("src","<?=U('captcha')?>?"+Math.random());
	var form_data=$('#addRemark').serialize(); //php中的序列化函数
	$.ajax({
		type:"POST",
		url:"<?=U('AJAXaction')?>",
		data:form_data,
		dataType:"json",
		success:function(data)
		{
			if(data)
			{
				if(data.ok==1)
				{
					$('#captchaDiv').css("display",'none');
					//清空表单,触发trigger时间中的reset 就是重置表单 
					$('#addRemark').trigger('reset');
					//在页面中显示最新的评论,div 里加一个none 隐藏，等会做效果
					var str='<div class="comment_items mt10 none" ><div class="user_pic" > <dl> <dt><a href=""><img src="/Public/Front/images/user1.gif" alt="" /></a></dt> <dd><a href="">'+data.name+'</a></dd> </dl> </div> <div class="item"> <div class="title"> <span>'+data.addtime+'</span> <strong class="star star'+data.star+'"></strong></div> <div class="comment_content"> <dl>'+data.content+'</dl>  </dl> '+data.img+'</div> <div class="btns"> <a href="#" class="reply">回复('+data.zan_num+')</a> <a href="#" class="useful">有用('+data.zan_num+')</a> </div> </div> <div class="cornor"></div></div>';
					//把字符串转换成一个JQ的对象
					pl =	$(str);	
					//追加进去
					$('#remark').append(pl);
					//淡入效果
					pl.slideDown("slow");
					//清空图片
					$('#img-AJAX').html('');
				}
				else if(data.ok==2)
				{
					//清空表单,触发trigger时间中的reset 就是重置表单 
					$('#addRemark').trigger('reset');
					//在页面中显示最新的评论,div 里加一个none 隐藏，等会做效果
					var str='<div class="comment_items mt10 none" ><div class="user_pic" > <dl> <dt><a href=""><img src="/Public/Front/images/user1.gif" alt="" /></a></dt> <dd><a href="">'+data.name+'</a></dd> </dl> </div> <div class="item"> <div class="title"> <span>'+data.addtime+'</span> <strong class="star star'+data.star+'"></strong></div> <div class="comment_content"> <dl>'+data.content+'</dl>  </dl> '+data.img+'</div> <div class="btns"> <a href="#" class="reply">回复('+data.zan_num+')</a> <a href="#" class="useful">有用('+data.zan_num+')</a> </div> </div> <div class="cornor"></div></div>';
					//把字符串转换成一个JQ的对象
					pl =	$(str);	
					//追加进去
					$('#remark').append(pl);
					//淡入效果
					pl.slideDown("slow");
					//清空图片
					$('#img-AJAX').html('');

				}
				else if(data.catch==1)
				{
					$('#captchaDiv').css("display",'');
					alert(data.error);	
				}
				else
					alert(data.error);				
			}
		}
	});
	
}


</script>