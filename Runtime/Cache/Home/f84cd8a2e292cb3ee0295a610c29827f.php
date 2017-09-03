<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
<title>招标订阅</title>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<meta charset="utf-8">
<link href="/weixin/Public/static/datetimepicker/css/bootstrap.min.css" rel="stylesheet">
<link href="/weixin/Public/static/datetimepicker/css/common.css" rel="stylesheet">
<link href="/weixin/Public/static/datetimepicker/css/wxkeyset.css" rel="stylesheet">
<script src="https://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script src="/weixin/Public/static/datetimepicker/js/jquery.js"></script>
<script src="/weixin/Public/static/datetimepicker/js/share.js"></script>
<script src="/weixin/Public/static/datetimepicker/js/bootstrap.min.js"></script>
<script src="/weixin/Public/static/datetimepicker/js/fastclick.js"></script>
<script src="/weixin/Public/static/datetimepicker/js/common.js"></script>
<style>
#delkw{
	text-align: center;
    margin: 50 auto;
	padding:0 30px;
}
#delkw >div{
	border: 1px solid #fe7379;
    color: #fff;
    background: #fe7379;
    width: 100%;
	height: 45px;
    line-height: 45px;
    font-size: 18px;
    border-radius: 4px;
	-webkit-box-shadow: 0px 5px 5px #fe7379;
    box-shadow: 0px 5px 5px #fe7379;
}
.modal-dialog{
	margin:auto 20px;
}
#fdiv{
	width: 275px;
    position: absolute;
    z-index: 99;
    border-radius: 4px;
    left: 0px;
    top: 67px;
    box-shadow: 0 0 12px rgba(0, 0, 0, .2);
    text-align: center;
    line-height: 42px;
    background-color: #fff;
	padding: 0px 8px;
	font-size: 16px;
    color: #333;
}
#fspan2 {
    display: inline-block;
    width: 0px;
    height: 0px;
    border: 1px solid #fff;
    position: absolute;
    left: 11px;
    top: 54px;
    border-width: 9px;
    border-color: transparent transparent #fff transparent;
    z-index: 999;
}
#fspan1 {
    display: inline-block;
    width: 0px;
    height: 0px;
    border: 1px solid #ccc;
    position: absolute;
    left: 11px;
    top: 53px;
    border-width: 9px;
    border-color: transparent transparent rgba(0, 0, 0, .2) transparent;
}
</style>
<script>
var index = getUrlParam("id");
var keyword = getUrlParam("keyword");
var surpriseflag = "A"
initShare(["wxd66e9589c9fecff6","1504168823","Dsi7LuM9Lsk54pAvoUI6oopjcMXR0fPE","46fb0c0c0c6d67bde76115d93ae1d8647b25e92c"],"GycHKzoDYnpnVgwbHlkJOAJndnckHEcsHy5jRw==",2,"jy_extend","My小可哥","");
var autoset = false;
$(function(){
	 function trim(str){ //删除左右两端的空格
	　　     return str.replace(/(^\s*)|(\s*$)/g, "");
	　　 }
	
	if (window.screen.width < 310){
		$("#fdiv").css("width","90%")
	}
	if (surpriseflag==""){
		$("#fdiv").fadeIn("normal");
		$("#fspan1").fadeIn("normal");
		$("#fspan2").fadeIn("normal");
		$.post("/wxkeyset/ajaxReq?t="+new Date().getTime(),{"reqType":"setSurp"},function(r){
			surpriseflag="A"
		})
	}
	new FastClick(document.body);
	$(window).bind("pageshow", function(event){
		if(event.originalEvent.persisted){	
			window.location.reload(true);
		}
    });
	$.post("/weixin/index.php/Home/Order/orderone?id="+index,{"reqType":"getKeyset"},function(r){
		if(!r){
			return;
		}
		var isAutoset = true;
		$.each(r, function(i, content){
			if(content.District){
				isAutoset = false;
				
				//alert(content.District);
				$("#area").html("<span>"+content.District+"</span><span>"+"</span>");
				
			}
			if(content.Ex_subect){
				isAutoset = false;
				$("#notkey").html("<span>"+content.Ex_subect+"</span><span>"+"</span>");
			}
			if(content.type){
				isAutoset = false;
				$("#infotype").html("<span>"+content.type+"</span><span>"+"</span>");
			}
			})

		autoset = isAutoset;
	});
	$(".complate").click(function(){
		window.history.go(-1);
	});
	$(".content li").click(function(){
		var tpl = null;
		switch($(this).index()){
			case 0:
				tpl = "area";
				break;
			case 1:
				tpl = "infotype";
				break;
			case 2:
				tpl = "notkey";
				break;
		}
		window.location.href = "/weixin/index.php/Home/Order/"+tpl+"?index="+index+"&keyword="+escape(keyword);
	});
	$("#delkw").click(function(){
		$("#tck").click();
	})
	
	var wheight = document.body.clientHeight;
	$(".modal-content").css("margin-top",0.255*wheight);
	$(".modal-body span").html(keyword);
	$("#delSure").click(function(){
		//alert(index+"  "+keyword);
		$.ajax({
			type: "POST",
			url: "/weixin/index.php/Home/Order/removeone",
			data: {reqType:"delKeysWord",index:index,keyword:keyword},
			dataType: "json",
			
			success: function(r){
				window.history.back();
			}
		});
	})
});
</script>
</head>
<body class="filtersetpage">
	<div class="header">
		<span class="header-title">订阅关键词：<script>document.write(keyword);</script></span>
		<span class="complate">完成</span>
	</div>
	<div class="content">
		<ul>
			<li>
				地区<img src="/wxswordfish/images/right.png">
				<div id="area">全国</div>
				<span id="fspan1" style="display:none;"></span>
				<span id="fspan2" style="display:none;"></span>
				<div id="fdiv" style="display:none;">点这里可以只接受部分省份的信息哦</div>
			</li>
			<li>
				信息类型<img src="/wxswordfish/images/right.png">
				<div id="infotype">全部</div>
			</li>
			<li>
				排除关键词<img src="/wxswordfish/images/right.png">
				<div id="notkey">点击设置不希望接收的关键词</div>
			</li>
		</ul>
	</div>
	<div id="delkw"><div>删除关键词</div></div>
	<button class="hidden"  id="tck" data-toggle="modal" data-target="#myModal"></button>
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	    <div class="modal-dialog">
	        <div class="modal-content">
	            <div class="modal-header" style="text-align: center;">
	                <h4 class="modal-title" id="myModalLabel" style="color:#000;">提示信息</h4>
	            </div>
	            <div class="modal-body" style="text-align: center;font-size: 16px;color: #1d1d1d;">确定要删除关键词“<span>eeee</span>”?</div>
	            <div class="modal-footer" style="text-align:center;border-top:0px;">
	                <button type="button" id="delSure" class="btn btn-primary" style="margin-right: 60px;font-size: 16px;padding: 6px 20px;">确定</button>
	                <button type="button" class="btn btn-default" data-dismiss="modal" style="background-color: #ccc;font-size: 16px;padding: 6px 20px;">取消</button>
	            </div>
	        </div>
	    </div>
	</div>
	<script>
var _hmt = _hmt || [];
(function() {
	var hm = document.createElement("script");
	hm.src = "/baiducc";
	var s = document.getElementsByTagName("script")[0]; 
	s.parentNode.insertBefore(hm, s);
})();
</script>
</body>
</html>