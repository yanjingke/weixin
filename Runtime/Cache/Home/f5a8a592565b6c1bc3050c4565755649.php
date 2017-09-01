<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
<title>招标订阅</title>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<meta charset="utf-8">
<link href="/weixin/Public/static/datetimepicker/css/common.css" rel="stylesheet">
<link href="/weixin/Public/static/datetimepicker/css/wxkeyset.css" rel="stylesheet">
<script src="https://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script src="/weixin/Public/static/datetimepicker/js/jquery.js"></script>
<script src="/weixin/Public/static/datetimepicker/js/share.js"></script>
<script>
initShare(["wxd66e9589c9fecff6","1504168691","ipUjAueas4LNcHalWaAfXaAVkq9FjZzv","42ff13965641ca37e87142ebf612e4c25d761cf3"],"GycHKzoDYnpnVgwbHlkJOAJndnckHEcsHy5jRw==",2,"jy_extend","My小可哥","");
var isIOS = !!navigator.userAgent.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/); 
var isfocusing = true;
var focusinputindex = -1;
var istiped = false;
var keywordReg = /([\s\u3000\u2003\u00a0+，,])+/g;
var timeout = 200;
var disflag = false;
var disflagtwo = false;
var surpst = "";
var surpriseflag = "A"
var suphtml = '<span id="sp1"></span><span id="sp2"></span><div id="surprise"><img src="/weixin/Public/static/datetimepicker/img/spg.gif"/>点此有惊喜!</div>';
$(function(){
	if(!isIOS){
		$(".relRecom").addClass("isnotios");
	}
	$(".keyword").val("");
	$(window).bind("pageshow", function(event){
		if(event.originalEvent.persisted){
			window.location.reload(true);
		}
    });
	$("body,#easyAlert").on("touchstart",function(){
		$("#easyAlert").hide();
	});
	  var url='<?php echo U('order');?>';
	 // alert(url+"sdadas");
	$.post(url,{"reqType":"getKeyset"},function(r){
		//alert(url);
		//saveSeniorset(r);
		
		
		//r=jQuery.parseJSON(r);
		alert(r.Wechat_code+"sddass");
		if(r&&r["s_surprise"]){
			surpriseflag=r["s_surprise"]
		}
		if(!r || !r["id"]){
			return;
		}
		for(var i=0;i<r["a_key"].length;i++){
			var a_key = r["a_key"][i];
			var key = a_key["key"];
			if(!key){
				continue;
			}
			if(i==0&&surpriseflag==""){
				$(".keyWordContent .keyWordGroup").eq(0).append(suphtml);
				dissurp();
			}
			var kwgObj = $(".keyWordGroup:eq("+i+")");
			kwgObj.find(".keyword").val($.trim(key.join(" ")));
			if((a_key["area"] && a_key["area"].length > 0) || (a_key["infotype"] && a_key["infotype"].length > 0) || (a_key["notkey"] && a_key["notkey"].length > 0)){
				kwgObj.addClass("hasset");
			}else{
				kwgObj.addClass("hasinput");
			}
		}
	});
	
	$(".help").click(function(){
		window.open("http://mp.weixin.qq.com/mp/homepage?__biz=MzIyNTM1NDUyNw==&hid=3&sn=badf2d7da08654c58b58169e773f58f0#wechat_redirect");
	});
	$(".keyword").on("input propertychange",function(){
		saveData();
		if(istiped){
			$("#easyAlert").hide();
		}
		checkKeys($(this));
		var thisParent = $(this).parents(".keyWordGroup");
		if(filterKeyword($(this).val()).length > 0){
			if(!thisParent.hasClass("hasset")){
				thisParent.addClass("hasinput");
			}
			$(this).next("img").show();
			$(this).addClass("focus");
		}else{
			thisParent.removeClass("hasinput hasset");
			$(this).next("img").hide();
			$(this).removeClass("focus");
			getRecomKWs($(this));
		}
	}).on('compositionstart', function(){
	    $(this).prop('comStart', true);
	}).on('compositionend', function(){
	    $(this).prop('comStart', false);
	}).blur(function(){
		isfocusing = false;
		var thisClass = $(this);
		$(".keyword").attr("readonly",false);
		$("#easyAlert").removeClass("focus").hide();
		thisClass.removeClass("focus");
		thisClass.next("img").hide();
		setTimeout(function(){
			$(".relRecom").hide();
			if(thisClass.parents(".keyWordGroup").index() != focusinputindex){
				return;
			}
			$(".header,.keyWordContent").removeClass("absolute");
			thisClass.parents(".keyWordGroup").nextAll(".keyWordGroup").show();
			$(".brace").hide();
			$(".complate").addClass("hide");
			$(".seniorset").removeClass("hide");
			$(".keyWordContent").removeClass('adjustment');
			$(".keyWordGroup").show();
			var valueArray = getKeyWords();
			if(valueArray.length >= 1&&!disflag&&surpriseflag==""){
				surswitch();
			}
		},300);
	}).focus(function(){
		$(".header,.keyWordContent").addClass("absolute");
		if(focusinputindex != $(this).parents(".keyWordGroup").index()){
			istiped = false;
		}
		focusinputindex = $(this).parents(".keyWordGroup").index();
		isfocusing = true;
		var thisClass = $(this);
		$(".complate").removeClass("hide");
		$(".seniorset").addClass("hide");
		$("#easyAlert").addClass("focus");
		$(".keyword").next("img").hide();
		if(this.value.length > 0){
			$(this).next("img").show();
			$(this).addClass("focus");
		}
		$(".brace").show();
		$(".relRecom").hide();
		if($.trim(thisClass.val()).length == 0){
			if(!isfocusing){
				return;
			}
			afterFocus(thisClass);
			getRecomKWs(thisClass);
		}else{
			$(this).parents(".keyWordGroup").nextAll(".keyWordGroup").show();
			afterFocus(thisClass);
		}
		removesurp();
	});
	$(".keyword").next("img").on("touchstart",function(){
		$(this).prev("[type='text']").val("").focus();
		saveData();
		$(this).hide();
		$(this).parents(".keyWordGroup").removeClass("hasinput hasset");
	});
	$(".seniorset").click(function(){
		window.location.href = "/wxkeyset/keyset/seniorset";
	});
	$(".set2,.set3").click(function(){
		var parentObj = $(this).parents(".keyWordGroup");
		var value = parentObj.find(".keyword").val();
		var index = parentObj.index();
		var thisIndex = index;
		$(".keyword").each(function(i){
			if(i < thisIndex && filterKeyword($(this).val()) == ""){
				index--;
			}
		});
		$("#surprise").fadeOut("normal");
		$("#sp1").fadeOut("normal");
		$("#sp2").fadeOut("normal");
		window.location.href = "/wxkeyset/keyset/filterset?index="+index+"&keyword="+escape(value);
	});
	$(".complate").click(function(){});
	document.onkeydown = function () {
        if (window.event && window.event.keyCode == 13){
            window.event.returnValue = false;
			$(".keyWordGroup:eq("+focusinputindex+") .keyword").blur();
        }
    }
});

function dissurp(){
	clearTimeout(surpst);
	surpst = setTimeout(function(){
		$("#surprise").fadeOut("normal");
		$("#sp1").fadeOut("normal");
		$("#sp2").fadeOut("normal");
		disflag = true;
	},100000);
}

function removesurp(){
	$("#surprise").fadeOut("normal");
	$("#sp1").fadeOut("normal");
	$("#sp2").fadeOut("normal");
	$("#surprise").remove();
	$("#sp1").remove();
	$("#sp2").remove();
	if(!disflag){
		disflagtwo = false;
	}
}

function surswitch(){
	$("#surprise").fadeOut("normal");
	$("#sp1").fadeOut("normal");
	$("#sp2").fadeOut("normal");
	$(".keyWordGroup").each(function(i){
		var keyval = $(this).find(".keyword").val();
		if(keyval!=""&&!disflagtwo){
			removesurp();
			$(this).append(suphtml);
			dissurp();
			disflagtwo = true;
		}
	})
	
}

function filterKeyword(value){
	return value.replace(keywordReg,"");
}
function saveData(){
	var param = {
		"reqType": "saveKeyWords",
		"keyWords": [],
		"indexs": []
	};
	$(".keyword").each(function(i){
		var thisValue = $.trim($(this).val());
		if(thisValue == ""){
			return true;
		}
		param["indexs"].push(i);
		param["keyWords"].push(thisValue);
	});
	$.ajax({
		type: "POST",
		url: "/wxkeyset/ajaxReq",
		data: param,
		dataType: "json",
		traditional: true,
		success: function(r){
			
		}
	});
}

function checkKeys(obj){
	
	if(obj.prop('comStart')){
		return
	}
	
	if(obj.val().match(/[^0-9a-zA-Z\u4E00-\u9FFF\s]/g)){
		JYAlert(2);
		return true;
	}
	
	var keys = obj.val().split(" ");
	for(var k=0;k<keys.length;k++){
		if(k > 1){
			JYAlert(0);
			return true;
		}else if(keys[k].length>19){
			JYAlert(1);
			return true;
		}
	}
	istiped = false;
	return false;
}
function JYAlert(T){
	if(istiped){
		return;
	}
	istiped = true;
	$("#easyAlert").removeClass("easyalert-0 easyalert-1 easyalert-2");
	$("#easyAlert").addClass("easyalert-"+T);
	$("#easyAlert>span").hide();
	$("#easyAlert>span:eq("+T+")").show();
	$("#easyAlert").show();
}

var lineRecoms = 0;
function loadRecoms(inputObj,datas){
	this.getSeizeLi = function(num,max){
		var html = '';
		if(num > 0 && num < max){
			for(var i=0;i<max-num;i++){
				html += '<li class="seize"></li>';
			}
		}
		return html;
	}
	lineRecoms = ($(window).width() - 10) / (79 + 10);
	lineRecoms = parseInt(lineRecoms);
	var html = '<ul>';
	var tmpNum = 0;
	for(var i=0;i<datas.length;i++){
		var thisWord = datas[i].word;
		var thisStyle = "";
		if(thisWord.length == 5){
			thisStyle = "style='font-size: 13px;'";
		}else if(thisWord.length > 5){
			thisStyle = "style='font-size: 12px;'";
		}
		html += '<li '+thisStyle+'>'+thisWord+'</li>';
		tmpNum++;
		if(tmpNum >= lineRecoms){
			tmpNum = 0;
		}
	}
	html += this.getSeizeLi(tmpNum,lineRecoms);
	html += '</ul>';
	$(".relRecom ul").remove();
	if(isfocusing){
		$(".brace").hide();
		inputObj.parents(".keyWordGroup").nextAll(".keyWordGroup").hide();
		$(".relRecom").append(html).show();
	}
	$(".loading").hide();
	$(".relrecomtip").show();
	
	var thisClass = this;
	$(".relRecom li").click("touchstart",function(){
		if($(this).text() == ""){
			return;
		}
		inputObj.val($(this).text());
		inputObj.parents(".keyWordGroup").addClass("hasinput");
		saveData();
		
		$.post("/member/behaviorRecord",{"source":"mobile","value":$(this).text(),"type":"subscribe_tj"});
		
		$(".relRecom").hide();
	});
}
function getRecomKWs(inputObj){
	var count = 20;
	var valueArray = getKeyWords();
	if(valueArray.length == 0){
		clearTimeout(surpst);
		$("#surprise").fadeOut("normal");
		$("#sp1").fadeOut("normal");
		$("#sp2").fadeOut("normal");
		$(".relRecom").hide();
		inputObj.parents(".keyWordGroup").nextAll(".keyWordGroup").show();
		return;
	}
	
	var valueArrayTemp = [];
	for(var i in valueArray){
		var isExists = false;
		for(var k in valueArray){
			if(i == k){
				break;
			}
			if(valueArray[i] == valueArray[k]){
				isExists = true;
				break;
			}
		}
		if(!isExists){
			valueArrayTemp.push(valueArray[i]);
		}
	}
	$.post("/member/getRecomKWs",{count:count,value:valueArrayTemp.join(" ").toUpperCase()},function(data){
		if(typeof(data) == "undefined" || data == null || data.length == 0){
			$(".relRecom").hide();
			inputObj.parents(".keyWordGroup").nextAll(".keyWordGroup").show();
			return;
		}
		var newData = filterRecomDatas(data,valueArrayTemp,count);
		if(newData.length == 0){
			$(".relRecom").hide();
			inputObj.parents(".keyWordGroup").nextAll(".keyWordGroup").show();
			return;
		}
		loadRecoms(inputObj,newData);
	});
}
function getKeyWords(){
	var hasKeyWords = [];
	$(".keyword").each(function(){
		var keyWord = $(this).val();
		keyWord = $.trim(keyWord);
		keyWord = keyWord.replace(keywordReg," ");
		keyWord = keyWord.replace(/\s+/g,"+");
		if(keyWord != ""){
			hasKeyWords.push(keyWord);
		}
	});
	return hasKeyWords;
}

function filterRecomDatas(words,valueArrayTemp,count){
	var newWords = [];
	for(var i in words){
		var isDel = false;
		var currentWord = $.trim(words[i]["word"]).toUpperCase();
		
		if(!isDel){
			for(var n=0;n<valueArrayTemp.length;n++){
				if(isDel){
					break;
				}
				var vat = valueArrayTemp[n].split("+");
				for(var m=0;m<vat.length;m++){
					if(currentWord == vat[m].toUpperCase()){
						isDel = true;
						break;
					}
				}
			}
		}
		
		if(!isDel){
			if(/^(-?\d+)(\.\d+)?$/.test(currentWord) || /^[0-9]*$/.test(currentWord) || currentWord.length == 1 || currentWord == "" || currentWord.indexOf("�") > -1){
				isDel = true;
			}
		}
		if(!isDel){
			
			for(var k in words){
				if(isDel){
					break;
				}
				if(i == k){
					continue;
				}
				if(currentWord == words[k]["word"].toUpperCase()){
					isDel = true;
					break;
				}
			}
		}
		if(!isDel){
			newWords.push(words[i]);
		}
	}
	newWords.sort(function(a,b){
		if(a.sim < b.sim){
	        return 1;
	    }else if(a.sim > b.sim){
	        return -1;
	    }else{
	        return 0;
	    }
	});
	return newWords.slice(0,count);
}
function afterFocus(obj){
	var scrollTop = obj.parents(".keyWordGroup").index() * (40 + 15);
	$(".keyWordContent").addClass('adjustment');
	$(".keyWordContent").scrollTop(scrollTop);
	setTimeout(function(){
		timeout = 150;
		$(window).scrollTop(0);
	},timeout);
}
function saveSeniorset(r){
	if(r && typeof(r["id"]) != "undefined" && typeof(r["Wechat_code"]) != "undefined" && typeof(r["Subject"]) != "undefined"&& typeof(r["District"]) != "undefined"&& typeof(r["Ex_subject"]) != "undefined"){
		return;
	}
	var param = {
		"reqType": "saveSeniorset",
		"ratemode": 1,
		"mode": 1,
		"email": ""
	};
	if(r){
		if(typeof(r["i_ratemode"]) != "undefined"){
			param["ratemode"] = r["i_ratemode"];
		}
		if(typeof(r["i_mode"]) != "undefined"){
			param["mode"] = r["i_mode"];
		}
		if(typeof(r["s_email"]) != "undefined"){
			param["email"] = r["s_email"];
		}
	}
	$.post("/wxkeyset/ajaxReq",param,function(r){
		
	});
} 
</script>
</head>
<body class="keysetpage">
	<div class="header">
		<span class="header-title">订阅关键词<img class="help" src="/weixin/Public/static/datetimepicker/img/help-b.png"></span>
		<span class="complate hide">完成</span>
		<span class="seniorset" style="float: right;font-size: 15px;color: #686868;"><img src="/weixin/Public/static/datetimepicker/img/set.png" style="width: 17px;margin-right: 4px;margin-top: -3px;">推送选项</span>
	</div>
	<div class="keyWordContent">
		<div class="keyWordGroup">
			<lable>1</lable>
			<div>
				<input type="text" maxlength="100" class="keyword" placeholder="示例：税务局 软件">
				<img src="/weixin/Public/static/datetimepicker/img/jyqingchu.png">
			</div>
			<span>
				<img src="/weixin/Public/static/datetimepicker/img/set1.png" class="set1">
				<img src="/weixin/Public/static/datetimepicker/img/set2.png" class="set2">
				<img src="/weixin/Public/static/datetimepicker/img/set3.png" class="set3">
			</span>
		</div>
		<div class="keyWordGroup">
			<lable>2</lable>
			<div>
				<input type="text" maxlength="100" class="keyword" placeholder="请输入关键词">
				<img src="/weixin/Public/static/datetimepicker/img/jyqingchu.png">
			</div>
			<span>
				<img src="/weixin/Public/static/datetimepicker/img/set1.png" class="set1">
				<img src="/weixin/Public/static/datetimepicker/img/set2.png" class="set2">
				<img src="/weixin/Public/static/datetimepicker/img/set3.png" class="set3">
			</span>
		</div>
		<div class="keyWordGroup">
			<lable>3</lable>
			<div>
				<input type="text" maxlength="100" class="keyword" placeholder="请输入关键词">
				<img src="/weixin/Public/static/datetimepicker/img/wx/jyqingchu.png">
			</div>
			<span>
				<img src="/weixin/Public/static/datetimepicker/img/set1.png" class="set1">
				<img src="/weixin/Public/static/datetimepicker/img/set2.png" class="set2">
				<img src="/weixin/Public/static/datetimepicker/img/set3.png" class="set3">
			</span>
		</div>
		<div class="keyWordGroup">
			<lable>4</lable>
			<div>
				<input type="text" maxlength="100" class="keyword" placeholder="请输入关键词">
				<img src="/weixin/Public/static/datetimepicker/img/wx/jyqingchu.png">
			</div>
			<span>
				<img src="/weixin/Public/static/datetimepicker/img/set1.png" class="set1">
				<img src="/weixin/Public/static/datetimepicker/img/set2.png" class="set2">
				<img src="/weixin/Public/static/datetimepicker/img/set3.png" class="set3">
			</span>
		</div>
		<div class="keyWordGroup">
			<lable>5</lable>
			<div>
				<input type="text" maxlength="100" class="keyword" placeholder="请输入关键词">
				<img src="/weixin/Public/static/datetimepicker/img/wx/jyqingchu.png">
			</div>
			<span>
				<img src="/weixin/Public/static/datetimepicker/img/set1.png" class="set1">
				<img src="/weixin/Public/static/datetimepicker/img/set2.png" class="set2">
				<img src="/weixin/Public/static/datetimepicker/img/set3.png" class="set3">
			</span>
		</div>
		<div class="keyWordGroup">
			<lable>6</lable>
			<div>
				<input type="text" maxlength="100" class="keyword" placeholder="请输入关键词">
				<img src="/weixin/Public/static/datetimepicker/img/wx/jyqingchu.png">
			</div>
			<span>
				<img src="/weixin/Public/static/datetimepicker/img/set1.png" class="set1">
				<img src="/weixin/Public/static/datetimepicker/img/set2.png" class="set2">
				<img src="/weixin/Public/static/datetimepicker/img/set3.png" class="set3">
			</span>
		</div>
		<div class="keyWordGroup">
			<lable>7</lable>
			<div>
				<input type="text" maxlength="100" class="keyword" placeholder="请输入关键词">
				<img src="/weixin/Public/static/datetimepicker/img/wx/jyqingchu.png">
			</div>
			<span>
				<img src="/weixin/Public/static/datetimepicker/img/set1.png" class="set1">
				<img src="/weixin/Public/static/datetimepicker/img/set2.png" class="set2">
				<img src="/weixin/Public/static/datetimepicker/img/set3.png" class="set3">
			</span>
		</div>
		<div class="keyWordGroup">
			<lable>8</lable>
			<div>
				<input type="text" maxlength="100" class="keyword" placeholder="请输入关键词">
				<img src="/weixin/Public/static/datetimepicker//img/wx/jyqingchu.png">
			</div>
			<span>
				<img src="/weixin/Public/static/datetimepicker/img/set1.png" class="set1">
				<img src="/weixin/Public/static/datetimepicker/img/set2.png" class="set2">
				<img src="/weixin/Public/static/datetimepicker/img/set3.png" class="set3">
			</span>
		</div>
		<div class="keyWordGroup">
			<lable>9</lable>
			<div>
				<input type="text" maxlength="100" class="keyword" placeholder="请输入关键词">
				<img src="/weixin/Public/static/datetimepicker/img/wx/jyqingchu.png">
			</div>
			<span>
				<img src="/weixin/Public/static/datetimepicker/img/set1.png" class="set1">
				<img src="/weixin/Public/static/datetimepicker/img/set2.png" class="set2">
				<img src="/weixin/Public/static/datetimepicker/img/set3.png" class="set3">
			</span>
		</div>
		<div class="keyWordGroup">
			<lable>10</lable>
			<div>
				<input type="text" maxlength="100" class="keyword" placeholder="请输入关键词">
				<img src="/weixin/Public/static/datetimepicker/img/wx/jyqingchu.png">
			</div>
			<span>
				<img src="/weixin/Public/static/datetimepicker/img/set1.png" class="set1">
				<img src="/weixin/Public/static/datetimepicker/img/set2.png" class="set2">
				<img src="/weixin/Public/static/datetimepicker/img/set3.png" class="set3">
			</span>
		</div>
		<div class="brace"></div>
		<div class="relRecom">
			<center class="loading">
				<img src="/weixin/Public/static/datetimepicker/img/loading.gif"/>加载中...
			</center>
			<center class="relrecomtip">
				<img src="/weixin/Public/static/datetimepicker/img/icon-like.png">您可能还需要以下关键词，点击即可加入订阅
			</center>
		</div>
	</div>
	<div class="easyalert" id="easyAlert">
		<span>您订阅的关键词较多，可能会收不到推送信息。点击 “？” 图标查看订阅技巧帮助页面。</span>
		<span>您订阅的关键词字数过多，可能会收不到推送信息。点击 “？”图标查看订阅技巧帮助页面。</span>
		<span>您订阅的关键词包含特殊符号，可能会收不到推送信息。点击 “？”图标查看订阅技巧帮助页面。</span>
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