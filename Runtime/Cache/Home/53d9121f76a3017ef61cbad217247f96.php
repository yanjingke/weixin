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
<script>
var index = getUrlParam("index");
initShare(["wxd66e9589c9fecff6","1504231645","qsw9AYWkT4batHBfui7fuVFWZBZTZGuW","cb3e63f88d6dafae7c1d65858b8e47a12035f0dd"],"GycHKzoDYnpnVgwbHlkJOAJndnckHEcsHy5jRw==",2,"jy_extend","My小可哥","");
$(function(){
	new FastClick(document.body);
	$.post("/weixin/index.php/Home/Order/findoneinfotype?id="+index,{"reqType":"getKeyset"},function(r){
		if(r==null&&r==''){
			$("#all").addClass("active");
			return;
		}
		var infotype=null;
		$.each(r,function(idx,item){

			infotype=item.type;
		})
		if(r!=null&&r!=''){
		for(var i=0;i<infotype.length;i++){
			$(".btn").each(function(){
				if($(this).attr("data-value") == infotype[i]){
					$(this).addClass("active");
					return false;
				}
			});
		}
		}
	});
	$(".btn").click(function(){
		if($(this).attr("id") == "all"){
			$(".btn").removeClass('active');
			$(this).addClass('active');
		}else{
			$(this).toggleClass('active');
			if($(".active").length > 0){
				$("#all").removeClass('active');
			}else{
				$("#all").addClass('active');
			}
		}
		saveData(0);
	});
	$(".complate").click(function(){
		saveData(1);
	});
});
function saveData(flag){
	var param = {
		"reqType": "saveInfotype",
		"index": index,
		"infotype": []
	};
	if(!$("#all").hasClass("active")){
		$(".btn.active").each(function(){
			param["infotype"].push($(this).attr("data-value"));
		});
	}
	if(flag){
		
$.ajax({
	type: "POST",
	url: "/weixin/index.php/Home/Order/updateinfotype",
	data: param,
	dataType: "json",
	
	success: function(r){
	if(flag){
		window.history.go(-1);
	}
},
error: function(){
	if(flag){
		window.history.go(-1);
	}
}

})
};
}
</script>
</head>
<body class="infotypepage">
	<div class="header">
		<span class="header-title">订阅关键词：<script>document.write(getUrlParam("keyword"));</script></span>
		<span class="complate">完成</span>
	</div>
	<div class="content">
		<div>信息类型</div>
		<ul>
			<li>
				<button class="btn" id="all">全部</button>
			</li>
			<li>
				<button class="btn" data-value="立法动态">立法动态</button>
				<div>采集建筑工程、信息化等类项目在招标前由发改委等部门审批的信息，并向用户提供“拟建项目预告”功能。</div>
			</li>
			<li>
				<button class="btn" data-value="立法计划">立法计划</button>
				<div>在正式招标之前发布的公告信息，主要有采购计划、项目预告、采购预告、招标文件预公示、招标方式公示等信息</div>
			</li>
			<li>
				<button class="btn" data-value="立法公示">立法公示</button>
				<div>包括公开招标、邀请招标、询价采购、竞争性谈判、单一来源、公开竞价、电子反拍、变更公告等公告信息</div>
			</li>
			<li>
				<button class="btn" data-value="立法新法">立法新法</button>
				<div>包括中标公示、成交公告、废标公告、流标公告等</div>
			</li>
			<li>
				<button class="btn" data-value="其它">其他信息</button>
				<div>包括合同公告、验收公告、违规处理等</div>
			</li>
		</ul>
	</div>

</body>
</html>