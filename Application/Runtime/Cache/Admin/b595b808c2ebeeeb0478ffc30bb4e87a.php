<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>管理中心</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="Text/Javascript" language="JavaScript">

if (window.top != window) {
    window.top.location.href = document.location.href;
}
</script>

<!-- frameset框架集 把页面内分成上下两个部分 上面76像素（*）上面是top.html 剩下的就是下面的了-->
<frameset rows="76,*" framespacing="0" border="0">

    <frame src="top.html" id="header-frame" name="header-frame" frameborder="no" scrolling="no">
	<!-- 然后下面又分成左右两个部分 -->
    <frameset cols="180,*" framespacing="0" border="0" id="frame-body">
    <!-- 然后上面又分成左右两部分左边是menu右边是main -->
        <frame src="menu.html" id="menu-frame" name="menu-frame" frameborder="no">
        <frame src="main.html" id="main-frame" name="main-frame" frameborder="no">
    </frameset>
</frameset>



</head>
<body>
</body>
</html>