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
<script src="/weixin/Public/static/datetimepicker/js/common.js"></script>
<script>
var index = getUrlParam("index");
initShare(["wxd66e9589c9fecff6","1504232073","A6q2VqMtr913UHLkzku8yMyjEFEMqqs4","49b120f5ca78b274a43cdff8ca91cbb981ae8fb2"],"GycHKzoDYnpnVgwbHlkJOAJndnckHEcsHy5jRw==",2,"jy_extend","My小可哥","");
$(function(){
	$(window).bind("pageshow", function(event){
		if(event.originalEvent.persisted){
			window.location.reload(true);
		}
    });
	$.post("/weixin/index.php/Home/Order/findonenotkey?id="+index,{"reqType":"getKeyset"},function(r){
		if(r!=null&&r!=''){
			
			var notkey=null;
			$.each(r,function(idx,item){

				notkey=item.Ex_subect;
		})
			
			for(var i=0;i<notkey.length;i++){
				var thisValue =$.trim(notkey[i]);
				if(thisValue){
					appendHtml(thisValue);
				}
			}
		}
		if($(".keyWordGroup").length == 0){
			appendHtml("");
		}
		if($(".keyWordGroup").length == 10){
			$(".add").addClass("hide");
		}else{
			$(".add").removeClass("hide");
		}
	});
	$(".complate").click(function(){
		saveData(1);
	});
	$(".add").click(function(){
		appendHtml("");
		if($(".keyWordGroup").length == 10){
			$(".add").addClass("hide");
		}
	});
});
function appendHtml(value){
	var html = '<div class="keyWordGroup">'
					+'<lable>排除词<span>'+($(".keyWordGroup").length+1)+'</span></lable>'
					+'<input type="text" maxlength="100" class="keyword" placeholder="" value="'+value+'">'
					+'<div class="delete">'
						+'<img src="/weixin/Public/static/datetimepicker/img/delete.png">'
					+'</div>'
				+'</div>';
	var htmlObj = $(html);
	htmlObj.children(".keyword").on("input propertychange",function(){
		var thisValue = $(this).val();
		if(thisValue.indexOf(" ") > -1){
			var pos = 0;
			try{
				pos = getCursorPos(this);
			}catch(e){}
			$(this).val(thisValue.replace(/\s/g,""));
			try{
				if(pos > 0){
					setCursorPos(this,pos-1);
				}
			}catch(e){}
		}
		saveData(0);
	});
	htmlObj.children(".delete").click(function(){
		$(this).parent().remove();
		if($(".keyWordGroup").length < 10){
			$(".add").removeClass("hide");
		}
		$(".keyWordGroup").each(function(i){
			$(this).children("lable").children("span").text(i+1);
		});
		saveData(0);
	});
	$("#keyWordGroups").append(htmlObj);
	htmlObj.children(".keyword").focus();
	if($(".keyWordGroup").length > 1){
		$(".delete").removeClass("hide");
	}
}
function saveData(flag){
	var param = {
		"reqType": "saveNotkey",
		"index": index,
		"notkey": []
	};
	$(".keyword").each(function(){
		var thisValue = $.trim($(this).val());
		if(thisValue != ""){
			param["notkey"].push(thisValue);
		}
	});
	if(flag){
	//alert(param[notkey][0]);
	$.ajax({
		type: "POST",
		url: "/weixin/index.php/Home/Order/updatenotkey",
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
	});
	}
}
</script>
</head>
<body class="notkeypage">
	<div class="header">
		<span class="header-title">订阅关键词：<script>document.write(getUrlParam("keyword"));</script></span>
		<span class="complate">完成</span>
	</div>
	<div class="content">
		<div>
			排除关键词
			<span>如果设置排除关键词，包含这些关键词的信息都不会推送给您。请谨慎设置。注：只判断文章标题是否包含，不判断正文。不能输入空格。</span>
		</div>
		<div id="keyWordGroups"></div>
		<div class="add hide">
			<span>+</span>
			<span>添加</span>
			<img src="/weixin/Public/static/datetimepicker/img/addbg.png">
		</div>
	</div>

</body>
</html>