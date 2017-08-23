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
<body>
    <!-- 头部 -->
    <div class="header">
        <!-- Logo -->
        <span class="logo">
             <img src="/weixin/Public/Admin/images/logo.jpg"/>
        </span>
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
            

            
    <script >
        function delnews(id){
            if(confirm('要删除吗?')){
                $.ajax({
                    type:'post',
                    url:"<?php echo U('del');?>",
                    data:'id='+id,
                    success:function(data){
                        if(data == '1')
                        {
                            alert('已删除至回收站');
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
        function sendone(id,relationid)
        {
          // alert(relationid);
            var url = "<?php echo U('Admin/Relation/sendrelation');?>";
            $("#sendone"+id).html('请稍后...').css('color','red');
            $.get(url,{id:id,relationid:relationid},function(data){
            	//alert("dasda");
                if(data == 'ok') {
                	 
                    $("#sendone"+id).hide();
                   
                    $(".sendone"+id).show();
                }
                else{
                    alert("已经关联");
                }
            });
        }
        function cleanone(id,relationid)
        {
          // alert(relationid);
            var url = "<?php echo U('Admin/Relation/cleanrelation');?>";
           // $(".sendone"+id).html('请稍后...').css('color','red');
            $.get(url,{id:id,relationid:relationid},function(data){
            	//
                if(data == 'ok') {
                	//alert("dasda");
                    $("#sendone"+id).show();
                    $(".sendone"+id).hide();
                    $("#sendone"+id).html('关联');
                }
            });
        }
        function return_show(id){
        	  var url = "<?php echo U('Admin/News/edit','','');?>/id/"+id+".html";
        	 
        	 
        	 // alert(url);
        	  window.location.href=url;
        	  //return url;
        }
        function checkall(){ //jquery获取复选框值
            var chk_value =[];
            $('input[name="ids[]"]:checked').each(function(){
                chk_value.push($(this).val());
            });
            if(chk_value.length==0){
                alert('你还没有选择任何内容！');
            }else{
                if(confirm('现在开始关联吗?')){
                	var relationid=<?php echo ($relationid); ?>;
                	//alert(relationid);
                    $("#pushall").html('请稍后！');
                    var url = "<?php echo U('Admin/Relation/sendMorerelation');?>";
                    $.post(url,{data:chk_value,relationid:relationid},function(data){
//                        console.log(data);
                        if(data == 'ok') {
                            window.location.reload();
                        }
                    },'text');
                }
            }
        }
      
    </script>
    <!-- 标题 -->
    <div class="main-title">
        <h2>
            全部新闻
        </h2>
    </div>
    <!-- 按钮工具栏 -->
    <div class="cf">
        <div class="fl">
          
            <a class="btn " href="javascript:void(0);" onclick="checkall()" id="pushall">批量关联</a>
        </div>

        <!-- 高级搜索 -->
    </div>


    <!-- 数据表格 -->
    <div class="data-table">
        <table class="">
            <thead>
            <tr>
                <th class="row-selected row-selected"><input class="check-all" type="checkbox"/></th>
                <th class="text-center">编号</th>
                <th class="" width="20%">标题</th>
                <th class="" width="5%">原文</th>
                <th class="" width="10%">发布时间</th>
                <th class="" width="10%">采集时间</th>
                <th class="" width="10%">标签</th>
                <th class="" width="10%">主题词</th>
                <th class="" width="5%">来源</th>
                <th class="" width="5%">关联</th>
               
                
            </tr>
            </thead>
            <tbody>
            <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                    <th class="text-center"><input class="ids" type="checkbox" name="ids[]" value="<?php echo ($vo["id"]); ?>" /></th>
                    <th><?php echo ($vo["id"]); ?> </th>
                    <td><a href="<?php echo U('News/edit?id='.$vo['id']);?>"><?php echo ($vo["title"]); ?></a></td>
                    <td><a href="<?php echo ($vo["url"]); ?>" style="color:blue" target="_blank">原文</a></td>
                    <td><?=date('Y-m-d',$vo['ptime'])?></td>
                    <td><span><?=date('Y-m-d',$vo['addtime'])?></span></td>
                    <td><span><?php echo ($vo["tags"]); ?></span></td>
                    <td>
                        <span>
                        <?php if(($vo["typename"]) != ""): echo ($vo["typename"]); ?>
                            <?php else: endif; ?>
                        </span>
                    </td>
                    <th class="" width="10%"><?php echo ($vo["source"]); ?></th>
                    <th class="" width="5%"><a href="javascript:;" onclick="sendone('<?php echo ($vo["id"]); ?>','<?php echo ($relationid); ?>')" id="sendone<?php echo ($vo["id"]); ?>">关联</a> <a href="javascript:;"  onclick="cleanone('<?php echo ($vo["id"]); ?>','<?php echo ($relationid); ?>')" style="display:none"  class="sendone<?php echo ($vo["id"]); ?>">已关联</a></th>
                  
                   
                   
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
            </tbody>
        </table>

    </div>

    <!-- 分页 -->
    <div class="page">
        <?php echo ($page); ?>
        <span class="rows">共 <?php echo ($counts); ?> 条记录</span>
    </div>
   
   <div class="cf"style="margin-left: 500px;">
       
		<div class="form-item ">
                    <input type="submit" value="确定" class="btn" onclick="return_show(<?php echo ($_GET['relationid']); ?>)">
              
                </div>
        <!-- 高级搜索 -->
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