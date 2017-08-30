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
    <script type="text/javascript">
        function check() {
            if (document.frm.title.value == "") {
                alert('标题不能为空！');
                document.getElementById('title').focus();
                return false;
            }  else if (document.frm.content.value == "") {
                alert('内容不能为空！');
                document.getElementById('content').focus();
                return false;
            } else {
                return true;
            }
        }

    </script>
    <div class="main-title cf">
        <h2>
            发布新闻
        </h2>
    </div>
    <ul class="tab-nav nav">
        <!--<li data-tab="tab1" class="current"><a href="javascript:void(0);">基础</a></li><li data-tab="tab2"><a href="javascript:void(0);">扩展</a>-->
        <!--</li>   -->
    </ul>
    <!-- 标签页导航 -->
    <div class="tab-content">
        <!-- 表单 -->
        <form id="form" action="<?php echo U('save');?>" name="frm" method="post" onsubmit="return check()" onreset="cancle()">
            <!-- 基础文档模型 -->
            <input type="hidden" name="id" value="<?php echo ($_GET['id']); ?>">
            <div class="form-item cf">
                <label class="item-label">标题<span class="check-tips">（新闻标题）*</span></label>
                <div class="controls">
                    <input type="text" class="text input-large" name="title" value="" id="title">
                </div>
            </div>
            <div class="form-item cf">
                <label class="item-label">标签<span class="check-tips"></span></label>
                <div class="controls">
                    <input type="text" class="text input-large" name="tags" id="tags" value="">                    </div>
                <div class="form-item cf">
                    <label class="item-label">来源<span class="check-tips"></span></label>
                    <div class="controls">
                        <input type="text" class="text input-large" name="url" id="url" value="" >                    </div>
                </div>
            </div>
            <div class="form-item cf">
                <label class="item-label">分类<span class="check-tips"></span></label>
                <div class="controls">
                    <select name="type" id="">
                        <?php if(is_array($tags)): $i = 0; $__LIST__ = $tags;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$tag): $mod = ($i % 2 );++$i;?><option value="<?php echo ($tag["id"]); ?>" ><?php echo ($tag["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </div>
            </div>
            <!--文章内容-->
            <br>
            <label class="item-label checkbox">新闻详情*</label>
            <hr>
            <textarea name="content" id="content" cols="30" rows="10">

            </textarea>
            <?php echo hook('adminArticleEdit', array('name'=>$field['name'],'value'=>$field['value']));?>
            <!--封面图片上传-->
            <script type="text/javascript">
                //上传图片
                /* 初始化上传插件 */
                $("#upload_picture_<?php echo ($field["name"]); ?>").uploadify({
                    "height"          : 30,
                    "swf"             : "/weixin/Public/static/uploadify/uploadify.swf",
                    "fileObjName"     : "download",
                    "buttonText"      : "上传图片",
                    "uploader"        : "<?php echo U('File/uploadPicture',array('session_id'=>session_id()));?>",
                    "width"           : 120,
                    'removeTimeout'   : 1,
                    'fileTypeExts'    : '*.jpg; *.png; *.gif;*.mp4',
                    "onUploadSuccess" : uploadPicture<?php echo ($field["name"]); ?>,
                'onFallback' : function() {
                    alert('未检测到兼容版本的Flash.');
                }
                });
                function uploadPicture<?php echo ($field["name"]); ?>(file, data){
                    var data = $.parseJSON(data);
                    var src = '';
                    if(data.status){
                        $("#cover_id_<?php echo ($field["name"]); ?>").val(data.id);
                        src = data.url || '/weixin' + data.path
                        $("#cover_id_<?php echo ($field["name"]); ?>").parent().find('.upload-img-box').html(
                                '<div class="upload-pre-item"><img src="' + src + '"/></div>'
                        );
                    } else {
                        updateAlert(data.info);
                        setTimeout(function(){
                            $('#top-alert').find('button').click();
                            $(that).removeClass('disabled').prop('disabled',false);
                        },1500);
                    }
                }
            </script>
            </label>

            <div class="form-item ">
                <input type="submit" value="修改" class="btn submit-btn">
                <input type="reset" value="取消" class="btn btn-return">
            </div>
        </form>
    </div>

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