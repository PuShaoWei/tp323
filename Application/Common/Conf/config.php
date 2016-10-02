<?php
//定义常量  显示图片时根目录路径
define('IMG', '/Public/Uploads/');
define('IMG_PATH', './Public/Uploads/');//php 的

return array(
/******************数据库配置*********************/
'DB_TYPE'               =>  'mysql',     // 数据库类型
'DB_HOST'               =>  '127.0.0.1', // 服务器地址
'DB_NAME'               =>  'tzlshop_2',   // 数据库名
'DB_USER'               =>  'root',      // 用户名
'DB_PWD'                =>  '',          // 密码
'DB_PORT'               =>  3306,        // 端口
'DB_PREFIX'             =>  'tzl_',    // 数据库表前缀
'DB_CHARSET'            =>  'utf8',      // 数据库编码默认采用utf8
'MD5_SALT'			    => 'dkei#@ifsioJFIE9.ewoe932Jp32@#4klpfs0ajpo23j;f98e;rew',
'DEFAULT_FILTER'        =>  'trim,htmlspecialchars', // 默认参数过滤方法 用于I函数...
'DEFAULT_MODULE'        =>  'Front',
'TMPL_PARSE_STRING'  =>array(
     '__GROUP__' => "javascript:location.reload()", // 更改默认的/Public 替换规则
),
'SHOW_PAGE_TRACE' =>true,  //开启trace 模式 ，调试模式\
/****************表单提交令牌*************/
/*'TOKEN_ON'      =>    true,  // 是否开启令牌验证 默认关闭
'TOKEN_NAME'    =>    '__hash__',    // 令牌验证的表单隐藏字段名称，默认为__hash__
'TOKEN_TYPE'    =>    'md5',  //令牌哈希验证规则 默认为MD5
'TOKEN_RESET'   =>    true,  //令牌验证出错后是否重置令牌 默认为true*/
// 开启路由

);