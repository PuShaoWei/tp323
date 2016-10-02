<?php
return[
// 开启路由
'URL_ROUTER_ON'   => true, 
'URL_ROUTE_RULES'=>[
    'regist.html' =>'index/regist',
    'index.html' =>'index/index',
    'login.html' =>'index/login',
    'log_out.html'=>'index/log_out',
],

'HTML_CACHE_ON'     =>    false, // 开启静态缓存
'HTML_FILE_SUFFIX'  =>    '.shtml', // 设置静态缓存文件后缀
'HTML_CACHE_RULES'  =>     array(  // 定义静态缓存规则
     // 定义格式1 数组方式
     'index'    =>     ['index', 3600], 
     'goods'    =>     ['goods-{id}', 3600], 

)

];