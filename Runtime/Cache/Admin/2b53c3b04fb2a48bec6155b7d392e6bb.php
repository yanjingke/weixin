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
        ._citys { width: 450px; display: inline-block; border: 2px solid #eee; padding: 5px; position: relative; background-color:rgb(251,251,251);}
        ._citys span { color: #56b4f8; height: 15px; width: 15px; line-height: 15px; text-align: center; border-radius: 3px; position: absolute; right: 10px; top: 10px; border: 1px solid #56b4f8; cursor: pointer; }
        ._citys0 { width: 100%; height: 34px; display: inline-block; border-bottom: 2px solid #56b4f8; padding: 0; margin: 0; }
        ._citys0 li { display: inline-block; line-height: 34px; font-size: 15px; color: #888; width: 80px; text-align: center; cursor: pointer; }
        .citySel { background-color: #56b4f8; color: #fff !important; }
        ._citys1 { width: 100%; display: inline-block; padding: 10px 0; }
        ._citys1 a { width: 83px; height: 35px; display: inline-block; background-color: #f5f5f5; color: #666; margin-left: 6px; margin-top: 3px; line-height: 35px; text-align: center; cursor: pointer; font-size: 13px; overflow: hidden; }
        ._citys1 a:hover { color: #fff; background-color: #56b4f8; }
        .AreaS { background-color: #56b4f8 !important; color: #fff !important; }
    </style>
    <!-- 标题 -->
    <div class="main-title">
        <h2>
            所有站点
        </h2>
    </div>
    <script>



        function clickbutton(id)
        {
            $("#button"+id).html('<span style="color:red">采集中,请稍后...</span>');
            var url = $("#button"+id).attr('url');
            var routes = $("#button"+id).attr('routes');
            $.post(routes,{url:url},function(data){
                if(data){
                    $("#button"+id).html('<td id="button' +id+
                            '" onclick="clickbutton(' +id+
                            ')" route="' +routes+
                            '" url="' +url+
                            '"><button>开始</button></td>');
                }
            });
        }
        function delnets(Crawl_Id){
            if(confirm('确定要删除吗?')){
                $.ajax({
                    type:'post',
                    url:"<?php echo U('delete');?>",
                    data:'Crawl_Id='+Crawl_Id,
                    success:function(data){
                        if(data == '1')
                        {
                            alert('已删除');
                            window.location.reload();
                        }
                        else
                        {
                            alert('删除失败');
                            window.location.reload();
                        }
                    }
                });
            }
        }
        function start(Crawl_Id){
            $(".start").click(function(){
                $(this).html("<b style='color: #ab2412'>正在爬取</b>");

                $(this).removeAttr('onclick');//去掉a标签中的onclick事件
            });

            $.ajax({
                type:'post',
                url:"<?php echo U('start');?>",
                data:'Crawl_Id='+Crawl_Id,
                success:function(data){

                     /*   alert(data[0]);
                        window.location.reload();*/


                }
            });

        }

        function getall() {
            $("#getall").click(function () {
                $(this).html("<b style='color: #ab2412'>正在爬取</b>");
                $(this).removeAttr('onclick');//去掉a标签中的onclick事件
            })
            $.ajax({
                type: 'post',
                url: "<?php echo U('start');?>",
                data: 'Crawl_Id=' + "ALL",
                success: function (data) {

                    /*   alert(data[0]);
                     window.location.reload();*/


                }
            });
        }

            function getsome(){
                $("#getsome").click(function(){
                    $(this).html("<b style='color: #ab2412'>正在爬取</b>");
                    $(this).removeAttr('onclick');//去掉a标签中的onclick事件
                });
                $.ajax({
                    type:'post',
                    url:"<?php echo U('start');?>",
                    data:'Crawl_Id='+"ALL",
                    success:function(data){

                        /*   alert(data[0]);
                         window.location.reload();*/


                    }
                });

        }


    </script>
    <!-- 按钮工具栏 -->
    <div class="cf">
        <div class="fl">
            <a class="btn " href="<?php echo U('add');?>">快速添加</a>
            <a id="getall" class="btn " href="javascript:void(0);" onclick="getall()">全部采集</a>
            <a id="getsome" class="btn " href="javascript:void(0);" onclick="getsome()">采集选中</a>

            <form id="form" action="<?php echo U('index');?>" name="frm" method="post" onsubmit="return check()" onreset="cancle()">
            <div class="form-item cf">
                <label class="item-label">地区<span class="check-tips"></span></label>
                <div class="controls">
                    <input type="text" class="text input-large" name="Crawl_Distric" value="<?php echo ($res["Crawl_Distric"]); ?>" id="Crawl_Distric"><span style="color:red;"></span>
                </div>
                <div class="form-item ">
                    <input type="submit" value="确定" class="btn submit-btn">
                    <input type="reset" value="取消" class="btn submit-btn">
                </div>
            </div>
            </form>
        </div>

        <!-- 高级搜索 -->
    </div>


    <!-- 数据表格 -->
    <div class="data-table">
        <table class="">
            <thead>
           <!-- <tr>
                <th class="row-selected row-selected"><input class="check-all" type="checkbox"/></th>
                <th class="text-center">编号</th>
                <th class="" width="10%">标题</th>
                <th class="" width="40%">链接地址</th>
                <th class="" width="15%">采集</th>
                <th class="" width="10%">路由</th>
                <th class="" width="10%">添加时间</th>
                <th class="" width="10%">操作</th>
            </tr>-->
           <tr>
               <th class="row-selected row-selected"><input class="check-all" type="checkbox"/></th>
               <th class="text-center">编号</th>
               <th class="" width="10%">地区组织/机构</th>
               <th class="" width="20%">链接地址</th>
               <th class="" width="10%">网页类型</th>
               <th class="" width="15%">采集</th>
               <th class="" width="10%">可爬取</th>
               <th class="" width="10%">地区</th>
               <th class="" width="10%">爬取时间</th>
               <th class="" width="10%">操作</th>
           </tr>
            </thead>
            <tbody>
            <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                    <th class="text-center"><input class="ids" type="checkbox" name="ids[]" value="<?php echo ($vo["Crawl_Id"]); ?>" /></th>
                    <th><?php echo ($vo["Crawl_Id"]); ?> </th>
                    <td><?php echo ($vo["Crawl_Org"]); ?></td>
                    <td><?php echo ($vo["Crawl_Url"]); ?></td>

                    <td>
                        <?php if($vo["Web_Type"] == a ): ?>立法动态
                            <?php elseif($vo["Web_Type"] == b): ?> 立法公示
                            <?php elseif($vo["Web_Type"] == c): ?>新法速递
                            <?php elseif($vo["Web_Type"] == d): ?>立法计划
                            <?php else: ?> 其他<?php endif; ?>
                    </td>

                    <td><a class="start" href="javascript:void(0);"  onclick="start('<?php echo ($vo["Crawl_Id"]); ?>')">开始</a> </td>



                    <td>
                        <?php if($vo["Crawl_Yes"] == 0 ): ?>不能爬取
                            <?php else: ?> 能爬取<?php endif; ?>
                    </td>

                    <td><?php echo ($vo["Crawl_Distric"]); ?></td>
                    <td><span><?=date('Y-m-d',$vo['Crawl_DateTime'])?></span></td>
                    <td>
                        <a href="<?php echo U('Nets/edit?Crawl_Id='.$vo['Crawl_Id']);?>" >编辑</a>
                        <a href="javascript:void(0);" class="confirm " onclick="delnets('<?php echo ($vo["Crawl_Id"]); ?>')">删除</a>
                    </td>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
            </tbody>
        </table>

    </div>

    <!-- 分页 -->
    <div class="page">
        <?php echo ($page); ?>
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
    
    <link href="/weixin/Public/static/datetimepicker/css/datetimepicker.css" rel="stylesheet" type="text/css">
    <?php if(C('COLOR_STYLE')=='blue_color') echo '<link href="/weixin/Public/static/datetimepicker/css/datetimepicker_blue.css" rel="stylesheet" type="text/css">'; ?>
    <link href="/weixin/Public/static/datetimepicker/css/dropdown.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="/weixin/Public/static/datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
    <script type="text/javascript" src="/weixin/Public/static/datetimepicker/js/locales/bootstrap-datetimepicker.zh-CN.js" charset="UTF-8"></script>
    <script type="text/javascript">
        $("#Crawl_Distric").click(function (e) {
            SelCity(this,e);
        });
        function recommend(obj,a){
            var url = $(obj).attr('u');

            $.post(url,{id:a},function(data){
                if(data=='1'){
                    alert('推荐成功');
                }else{
                    alert('推荐失败');
                }
                window.location.reload();
            });
        }


        $(function(){
            //搜索功能
            $("#search").click(function(){
                var url = $(this).attr('url');
                var status = $("#sch-sort-txt").attr("data");
                var query  = $('.search-form').find('input').serialize();
                query = query.replace(/(&|^)(\w*?\d*?\-*?_*?)*?=?((?=&)|(?=$))/g,'');
                query = query.replace(/^&/g,'');
                if(status != ''){
                    query += '&status=' + status + "&" + query;
                }
                if( url.indexOf('?')>0 ){
                    url += '&' + query;
                }else{
                    url += '?' + query;
                }
                window.location.href = url;
            });

            /* 状态搜索子菜单 */
            $(".search-form").find(".drop-down").hover(function(){
                $("#sub-sch-menu").removeClass("hidden");
            },function(){
                $("#sub-sch-menu").addClass("hidden");
            });
            $("#sub-sch-menu li").find("a").each(function(){
                $(this).click(function(){
                    var text = $(this).text();
                    $("#sch-sort-txt").text(text).attr("data",$(this).attr("value"));
                    $("#sub-sch-menu").addClass("hidden");
                })
            });

            //回车自动提交
            $('.search-form').find('input').keyup(function(event){
                if(event.keyCode===13){
                    $("#search").click();
                }
            });

            $('#time-start').datetimepicker({
                format: 'yyyy-mm-dd',
                language:"zh-CN",
                minView:2,
                autoclose:true
            });

            $('#datetimepicker').datetimepicker({
                format: 'yyyy-mm-dd',
                language:"zh-CN",
                minView:2,
                autoclose:true,
                pickerPosition:'bottom-left'
            })

        })
    </script>

</body>
</html>