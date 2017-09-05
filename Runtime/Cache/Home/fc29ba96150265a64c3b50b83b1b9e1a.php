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
initShare(["wxd66e9589c9fecff6","1504168826","10s7cMmYQSKNt7uYDWYrCYdEIKKi1Hv2","3e7514a1b76542b85e62caf1d30bd86beb3c4c03"],"GycHKzoDYnpnVgwbHlkJOAJndnckHEcsHy5jRw==",2,"jy_extend","My小可哥","");
$(function(){
	new FastClick(document.body);
	$.post("/weixin/index.php/Home/Order/findonearea?id="+index,{"reqType":"getKeyset"},function(r){
		if(!r){
			$("#wholecountry").addClass("active");
			return;
		}
		var area=null
		$.each(r,function(idx,item){

				area=item.District;
		})
		
		for(var i=0;i<area.length;i++){
			$(".btn").each(function(){
				if($(this).text() == area[i]){
					$(this).addClass("active");
					if($(this).parent().children(".btn.active").length == $(this).parent().children(".btn").length){
						$(this).parent().children("div").addClass("active");
					}
					return false;
				}
			});	
		}
	});
	$(".btn").click(function(){
		if($(this).attr("id") == "wholecountry"){
			$(".active").removeClass("active");
			$("#wholecountry").addClass("active");
		}else{
			$(this).toggleClass("active");
			if($(this).parent().children(".btn.active").length == $(this).parent().children(".btn").length){
				$(this).parent().children("div").addClass("active");
			}else{
				$(this).parent().children("div").removeClass("active");
			}
			if($(".active").length > 0){
				$("#wholecountry").removeClass("active");
			}else{
				$("#wholecountry").addClass("active");
			}
		}
		saveData(0);
	});
	$("li>div").click(function(){
		$(this).toggleClass("active");
		if($(this).hasClass("active")){
			$(this).nextAll(".btn").addClass("active");
		}else{
			$(this).nextAll(".btn").removeClass("active");
		}
		if($(".active").length > 0){
			$("#wholecountry").removeClass("active");
		}else{
			$("#wholecountry").addClass("active");
		}
		saveData(0);
	});
	$(".complate").click(function(){
		saveData(1);
	});
});
function saveData(flag){
	
	var param = {
		"reqType": "saveArea",
		"index": index,
		"area": []
	};
	if(!$("#wholecountry").hasClass("active")){
		$(".btn.active").each(function(){
			param["area"].push($(this).text());
		});
	}
	if(flag){
		
$.ajax({
	type: "POST",
	url: "/weixin/index.php/Home/Order/updatearea",
	data: param,
	dataType: "json",
	

	success: function(r){
		if(flag){
			window.history.back();
		}
	},
	error: function(){
		if(flag){
			window.history.back();
		}
	}
})
};
}
</script>
</head>
<body class="areapage">
	<div class="header">
		<span class="header-title">订阅关键词：<script>document.write(getUrlParam("keyword"));</script></span>
		<span class="complate">完成</span>
	</div>
	<div class="content">
		<div>地区</div>
		<ul>
			<li>
				<button class="btn" id="wholecountry">全国</button>
			</li>
			<li>
				<div>华北地区</div>
				<button class="btn">北京</button>
				<button class="btn">天津</button>
				<button class="btn">河北</button>
				<button class="btn">山西</button>
				<button class="btn">内蒙古</button>
			</li>
			<li>
				<div>东北地区</div>
				<button class="btn">辽宁</button>
				<button class="btn">吉林</button>
				<button class="btn">黑龙江</button>
			</li>
			<li>
				<div>华东地区</div>
				<button class="btn">上海</button>
				<button class="btn">江苏</button>
				<button class="btn">浙江</button>
				<button class="btn">安徽</button>
				<button class="btn">福建</button>
				<button class="btn">江西</button>
				<button class="btn">山东</button>
			</li>
			<li>
				<div>华南地区</div>
				<button class="btn">广东</button>
				<button class="btn">广西</button>
				<button class="btn">海南</button>
			</li>
			<li>
				<div>华中地区</div>
				<button class="btn">河南</button>
				<button class="btn">湖北</button>
				<button class="btn">湖南</button>
			</li>
			<li>
				<div>西南地区</div>
				<button class="btn">重庆</button>
				<button class="btn">四川</button>
				<button class="btn">贵州</button>
				<button class="btn">云南</button>
				<button class="btn">西藏</button>
			</li>
			<li>
				<div>西北地区</div>
				<button class="btn">陕西</button>
				<button class="btn">甘肃</button>
				<button class="btn">青海</button>
				<button class="btn">宁夏</button>
				<button class="btn">新疆</button>
			</li>
		</ul>
	</div>

</body>
</html>