<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo ($meta_title); ?>|后台管理</title>
    <link href="/weixin/Public/favicon.ico" type="image/x-icon" rel="shortcut icon">
    <link rel="stylesheet" type="text/css" href="/weixin/Public/Admin/css/base.css" media="all">
    <link rel="stylesheet" type="text/css" href="/weixin/Public/Admin/css/common.css" media="all">
    <link rel="stylesheet" type="text/css" href="/weixin/Public/Admin/css/module.css">
    <link rel="stylesheet" type="text/css" href="/weixin/Public/Admin/css/style.css" media="all">
	<link rel="stylesheet" type="text/css" href="/weixin/Public/Admin/css/<?php echo (C("COLOR_STYLE")); ?>.css" media="all">
     <!--[if lt IE 9]>
    <script type="text/javascript" src="/weixin/Public/static/jquery-1.10.2.min.js"></script>
    <![endif]--><!--[if gte IE 9]><!-->
    <script type="text/javascript" src="/weixin/Public/static/jquery-2.0.3.min.js"></script>
    <script type="text/javascript" src="/weixin/Public/Admin/js/jquery.mousewheel.js"></script>
    <!--<![endif]-->
    
</head>
<style>
	body{
		background-color: rgb(255,241,224);
	}
	.mylogo{
		float: left;
		width:200px;
		height: 49px;
		color: rgb(255,255,255);
		font-size: 18px;
		text-align: center;
		background-color: rgb(255,255,255);
		color: rgb(200,3,3);
	}
	.header{
		background-color: rgb(200,3,3);
	}
	.main-nav .current a{
		background-color:rgb(133,0,1)
	}
	.sidebar{
		background: none;
		background-color:rgb(216,76,41) ;
		border-top:rgb(133,0,1) 1px solid;
	}
	.main-nav a:hover{
		background-color: rgb(133,0,1);
		
	}
	.data-table thead th{
		background-color: rgb(216,76,41);
	}
	.btn{
		background-color: rgb(200,3,3);
		padding: 12px;
	}
	
	.btn:hover{
		background-color: rgb(133,0,1);
	}
	.main-nav li{
		width: 90PX;
	}
	.data-table tbody td,.data-table tbody th{
		border:solid 1px rgb(204,204,204);
	}
	
</style>
<body>
    <!-- 头部 -->
    
    <div class="header">
        <!-- Logo -->
        <div class="mylogo">
        <b>地方性立法大数据中心</b>
    	</div>
        <!-- /Logo -->

        <!-- 主导航 -->
        <ul class="main-nav">
            <?php if(is_array($__MENU__["main"])): $i = 0; $__LIST__ = $__MENU__["main"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$menu): $mod = ($i % 2 );++$i;?><li class="<?php echo ((isset($menu["class"]) && ($menu["class"] !== ""))?($menu["class"]):''); ?>"><a href="<?php echo (u($menu["url"])); ?>"><?php echo ($menu["title"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
        <!-- /主导航 -->

        <!-- 用户栏 -->
        <div class="user-bar">
            <a href="javascript:;" class="user-entrance"><i class="icon-user"></i></a>
            <ul class="nav-list user-menu hidden">
                <li class="manager">你好，<em title="<?php echo session('user_auth.username');?>"><?php echo session('user_auth.username');?></em></li>
                <li><a href="<?php echo U('User/updatePassword');?>">修改密码</a></li>
                <li><a href="<?php echo U('User/updateNickname');?>">修改昵称</a></li>
                <li><a href="<?php echo U('Public/logout');?>">退出</a></li>
            </ul>
        </div>
    </div>
    <!-- /头部 -->

    <!-- 边栏 -->
    <div class="sidebar">
        <!-- 子导航 -->
        
            <div id="subnav" class="subnav">
                <?php if(!empty($_extra_menu)): ?>
                    <?php echo extra_menu($_extra_menu,$__MENU__); endif; ?>
                <?php if(is_array($__MENU__["child"])): $i = 0; $__LIST__ = $__MENU__["child"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$sub_menu): $mod = ($i % 2 );++$i;?><!-- 子导航 -->
                    <?php if(!empty($sub_menu)): if(!empty($key)): ?><h3><i class="icon icon-unfold"></i><?php echo ($key); ?></h3><?php endif; ?>
                        <ul class="side-sub-menu">
                            <?php if(is_array($sub_menu)): $i = 0; $__LIST__ = $sub_menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$menu): $mod = ($i % 2 );++$i;?><li>
                                    <a class="item" href="<?php echo (u($menu["url"])); ?>"><?php echo ($menu["title"]); ?></a>
                                </li><?php endforeach; endif; else: echo "" ;endif; ?>
                        </ul><?php endif; ?>
                    <!-- /子导航 --><?php endforeach; endif; else: echo "" ;endif; ?>
            </div>
        
        <!-- /子导航 -->
    </div>
    <!-- /边栏 -->

    <!-- 内容区 -->
    <div id="main-content">
        <div id="top-alert" class="fixed alert alert-error" style="display: none;">
            <button class="close fixed" style="margin-top: 4px;">&times;</button>
            <div class="alert-content">这是内容</div>
        </div>
        <div id="main" class="main">
            
            <!-- nav -->
            <?php if(!empty($_show_nav)): ?><div class="breadcrumb">
                <span>您的位置:</span>
                <?php $i = '1'; ?>
                <?php if(is_array($_nav)): foreach($_nav as $k=>$v): if($i == count($_nav)): ?><span><?php echo ($v); ?></span>
                    <?php else: ?>
                    <span><a href="<?php echo ($k); ?>"><?php echo ($v); ?></a>&gt;</span><?php endif; ?>
                    <?php $i = $i+1; endforeach; endif; ?>
            </div><?php endif; ?>
            <!-- nav -->
            

            
    <script type="text/javascript" src="/weixin/Public/static/uploadify/jquery.uploadify.min.js"></script>
    <script src="/weixin/Public/static/jquery-1.11.3.min.js"></script>
    <script src="/weixin/Public/static/Popt.js"></script>
    <script src="/weixin/Public/static/cityJson.js"></script>
    <script src="/weixin/Public/static/citySet.js"></script>
    <style type="text/css">
        /** { -ms-word-wrap: break-word; word-wrap: break-word; }
        html { -webkit-text-size-adjust: none; text-size-adjust: none; }
        html, body {height:100%;width:100%; }
        html, body, h1, h2, h3, h4, h5, h6, div, ul, ol, li, dl, dt, dd, iframe, textarea, input, button, p, strong, b, i, a, span, del, pre, table, tr, th, td, form, fieldset, .pr, .pc { margin: 0; padding: 0; word-wrap: break-word; font-family: verdana,Microsoft YaHei,Tahoma,sans-serif; *font-family: Microsoft YaHei,verdana,Tahoma,sans-serif; }
        body, ul, ol, li, dl, dd, p, h1, h2, h3, h4, h5, h6, form, fieldset, .pr, .pc, em, del { font-style: normal; font-size: 100%; }
        ul, ol, dl { list-style: none; }*/
        ._citys { width: 450px; display: inline-block; border: 2px solid #eee; padding: 5px; position: relative; background-color:rgb(218,218,218) ;}
        ._citys span { color: #56b4f8; height: 15px; width: 15px; line-height: 15px; text-align: center; border-radius: 3px; position: absolute; right: 10px; top: 10px; border: 1px solid #56b4f8; cursor: pointer; }
        ._citys0 { width: 100%; height: 34px; display: inline-block; border-bottom: 2px solid #56b4f8; padding: 0; margin: 0; }
        ._citys0 li { display: inline-block; line-height: 34px; font-size: 15px; color: #888; width: 80px; text-align: center; cursor: pointer; }
        .citySel { background-color: #56b4f8; color: #fff !important; }
        ._citys1 { width: 100%; display: inline-block; padding: 10px 0; }
        ._citys1 a { width: 83px; height: 35px; display: inline-block; background-color: #f5f5f5; color: #666; margin-left: 6px; margin-top: 3px; line-height: 35px; text-align: center; cursor: pointer; font-size: 13px; overflow: hidden; }
        ._citys1 a:hover { color: #fff; background-color: #56b4f8; }
        .AreaS { background-color: #56b4f8 !important; color: #fff !important; }
    </style>

    <div class="main-title cf">
        <h2>
            添加网址
        </h2>
    </div>

    <!-- 标签页导航 -->
    <div class="tab-content">
        <!-- 表单 -->
        <input type="hidden" name="" id="url" value="<?php echo U('get_lng_lat');?>">
        <!--<form id="form" action="<?php echo U('save');?>" name="frm" method="post" onsubmit="return check()" onreset="cancle()">
            <div class="form-item cf">
                <label class="item-label">标题<span class="check-tips">（必填）</span></label>
                <div class="controls">
                    <input type="text" class="text input-large" name="title" value="" id="title"><span style="color:red;"></span>
                </div>
            </div>
            <div class="form-item cf">
                <label class="item-label">网址<span class="check-tips">（必填）</span></label>
                <div class="controls">
                    <input type="text" class="text input-large" name="sub_title" id="sub_title" value=""><span style="color:red;"></span>                    </div>
            </div>
            <div class="form-item cf">
                <label class="item-label">路由<span class="check-tips"></span></label>
                <div class="controls">
                    <input type="text" class="text input-large" name="routes" id="routes" value=""><span style="color:red;"></span>                    </div>
            </div>
      <br>

        <div class="form-item ">
            <input type="submit" value="确定" class="btn submit-btn">
            <input type="reset" value="取消" class="btn submit-btn">
        </div>
        </form>-->
        <form id="form" action="<?php echo U('save');?>" name="frm" method="post" onsubmit="return check()" onreset="cancle()">
            <!-- 基础文档模型 -->
          <!--  <div class="form-item cf">
                <label class="item-label">地区<span class="check-tips">（必填）</span></label>
                <div class="controls">
                    <input type="text" class="text input-large" name="Crawl_Distric" value="" id="Crawl_Distric"><span style="color:red;"></span>
                </div>
            </div>-->
            <div class="form-item cf">
                <label class="item-label">地区<span class="check-tips">（必填）</span></label>
                <div class="controls">
                    <input type="text" class="text input-large" name="Crawl_Distric" value="" id="Crawl_Distric" /><span style="color:red;"></span>
                </div>
            </div>
            <div class="form-item cf">
                <label class="item-label">组织/机构<span class="check-tips">（如：成都市人大网）（必填）</span></label>
                <div class="controls">
                    <input type="text" class="text input-large" name="Crawl_Org" id="Crawl_Org" value=""><span style="color:red;"></span>                    </div>
            </div>
            <div class="form-item cf">
                <label class="item-label">网址<span class="check-tips">（必填）</span></label>
                <div class="controls">
                    <input type="text" class="text input-large" name="Crawl_Url" id="Crawl_Url" value=""><span style="color:red;"></span>                    </div>
            </div>
            <div class="form-item cf">
                <label class="item-label">网页类型<span class="check-tips">（必填）</span></label>
                <div class="controls">
                    <!--<input type="" class="text input-large" name="Web_Type" id="Web_Type" value=""><span style="color:red;"></span>-->
                    <select name="Web_Type" id="Web_Type" class="text input-large" style="height: auto"><span style="color:red;"></span>
                        <option value="a">立法动态</option>
                        <option value="b">立法公示</option>
                        <option value="c">新法速递</option>
                        <option value="d">立法计划</option>
                        <option value="e">其他</option>
                    </select>
                </div>
            </div>
            <div class="form-item cf">
                <label class="item-label">能否爬取<span class="check-tips">（必选）</span></label>
                <div class="controls">
                    <input type="radio" name="Crawl_Yes" value="1" checked="checked" />能爬取
                    <input type="radio" name="Crawl_Yes" value="0" />不能爬取
                </div>
            </div>
            <div class="form-item cf">
                <label class="item-label">题目标签格式（必填）<span class="check-tips"><br />例如：&lt;h1 class="a" id="b" &gt;</span></label>
                <div class="controls">
                    <input type="text" class="text input-large" name="Crawl_Title" id="Crawl_Title" value=""><span style="color:red;"></span>                    </div>
            </div>
            <br>

            <div class="form-item ">
                <input type="submit" value="确定" class="btn submit-btn">
                <input type="reset" value="取消" class="btn submit-btn">
            </div>
        </form>
    </div>
    <script type="text/javascript">
        $("#Crawl_Distric").click(function (e) {
            SelCity(this,e);
        });
        function check(){
            if(document.frm.Crawl_Distric.value == ""){
                $("#Crawl_Distric").siblings("span").text('*地区不能为空');
                document.getElementById('Crawl_Distric').focus();
                return false;
            }else if(document.frm.Crawl_Org.value == ""){
                $("#Crawl_Org").siblings("span").text('*组织/机构不能为空');
                document.getElementById('Crawl_Org').focus();
                return false;
            }else if(document.frm.Crawl_Url.value == ""){
                $("#Crawl_Url").siblings("span").text('*网址不能为空');
                document.getElementById('Crawl_Url').focus();
                return false;
            }else if(document.frm.Crawl_Title.value == ""){
                $("#Crawl_Title").siblings("span").text('*标签个格式不能为空');
                document.getElementById('Crawl_Title').focus();
                return false;
            }else if(document.frm.Crawl_Title.value == ""){
                $("#Web_Type").siblings("span").text('*标签个格式不能为空');
                document.getElementById('Web_Type').focus();
                return false;
            }
            else{
                return true;
            }
        }
    </script>

        </div>
        <div class="cont-ft">
            <div class="copyright">

            </div>
        </div>
    </div>
    <!-- /内容区 -->
    <script type="text/javascript">
    (function(){
        var ThinkPHP = window.Think = {
            "ROOT"   : "/weixin", //当前网站地址
            "APP"    : "/weixin/index.php", //当前项目地址
            "PUBLIC" : "/weixin/Public", //项目公共目录地址
            "DEEP"   : "<?php echo C('URL_PATHINFO_DEPR');?>", //PATHINFO分割符
            "MODEL"  : ["<?php echo C('URL_MODEL');?>", "<?php echo C('URL_CASE_INSENSITIVE');?>", "<?php echo C('URL_HTML_SUFFIX');?>"],
            "VAR"    : ["<?php echo C('VAR_MODULE');?>", "<?php echo C('VAR_CONTROLLER');?>", "<?php echo C('VAR_ACTION');?>"]
        }
    })();
    </script>
    <script type="text/javascript" src="/weixin/Public/static/think.js"></script>
    <script type="text/javascript" src="/weixin/Public/Admin/js/common.js"></script>
    <script type="text/javascript">
        +function(){
            var $window = $(window), $subnav = $("#subnav"), url;
            $window.resize(function(){
                $("#main").css("min-height", $window.height() - 130);
            }).resize();

            /* 左边菜单高亮 */
            url = window.location.pathname + window.location.search;
            url = url.replace(/(\/(p)\/\d+)|(&p=\d+)|(\/(id)\/\d+)|(&id=\d+)|(\/(group)\/\d+)|(&group=\d+)/, "");
            $subnav.find("a[href='" + url + "']").parent().addClass("current");

            /* 左边菜单显示收起 */
            $("#subnav").on("click", "h3", function(){
                var $this = $(this);
                $this.find(".icon").toggleClass("icon-fold");
                $this.next().slideToggle("fast").siblings(".side-sub-menu:visible").
                      prev("h3").find("i").addClass("icon-fold").end().end().hide();
            });

            $("#subnav h3 a").click(function(e){e.stopPropagation()});

            /* 头部管理员菜单 */
            $(".user-bar").mouseenter(function(){
                var userMenu = $(this).children(".user-menu ");
                userMenu.removeClass("hidden");
                clearTimeout(userMenu.data("timeout"));
            }).mouseleave(function(){
                var userMenu = $(this).children(".user-menu");
                userMenu.data("timeout") && clearTimeout(userMenu.data("timeout"));
                userMenu.data("timeout", setTimeout(function(){userMenu.addClass("hidden")}, 100));
            });

	        /* 表单获取焦点变色 */
	        $("form").on("focus", "input", function(){
		        $(this).addClass('focus');
	        }).on("blur","input",function(){
				        $(this).removeClass('focus');
			        });
		    $("form").on("focus", "textarea", function(){
			    $(this).closest('label').addClass('focus');
		    }).on("blur","textarea",function(){
			    $(this).closest('label').removeClass('focus');
		    });

            // 导航栏超出窗口高度后的模拟滚动条
            var sHeight = $(".sidebar").height();
            var subHeight  = $(".subnav").height();
            var diff = subHeight - sHeight; //250
            var sub = $(".subnav");
            if(diff > 0){
                $(window).mousewheel(function(event, delta){
                    if(delta>0){
                        if(parseInt(sub.css('marginTop'))>-10){
                            sub.css('marginTop','0px');
                        }else{
                            sub.css('marginTop','+='+10);
                        }
                    }else{
                        if(parseInt(sub.css('marginTop'))<'-'+(diff-10)){
                            sub.css('marginTop','-'+(diff-10));
                        }else{
                            sub.css('marginTop','-='+10);
                        }
                    }
                });
            }
        }();
    </script>
    
</body>
</html>