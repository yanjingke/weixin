var EasyAlert = {
	timeout: null,
	show: function(text,css,waitTime){
		if(this.timeout != null){
			clearTimeout(this.timeout);
			this.hide();
			this.timeout = null;
		}
		var thisClass = this;
		this.timeout = setTimeout(function(){
			thisClass.hide();
			thisClass.timeout = null;
		},waitTime?waitTime:1000);
		$("body").append('<div class="easyalert-mask" id="easyalert-mask"><div class="easyalert" id="easyAlert">'+text+'</div></div>');
		if(typeof(css) != "undefined"){
			$("#easyAlert").css(css);
		}
		$("#easyAlert").css({"left":"50%","margin-top":-($("#easyAlert").outerHeight()/2),"margin-left":-($("#easyAlert").outerWidth()/2)});
	},
	hide: function(){
		$("#easyalert-mask").remove();
	}
}
var EasyPopup = function(id){
	this.id = id;
	var thisClass = this;
	document.getElementById(id).onclick = function(e){
		if(e.target.id == id){
			thisClass.hide();
		}
	}
	this.show = function(){
		$("#"+this.id).fadeIn();
		var mainObj = $("#"+id).find(".easypopup-main");
		mainObj.css({"margin-top":-(mainObj.outerHeight()/2)});
	},
	this.hide = function(){
		$("#"+this.id).fadeOut();
	}
}
//计算时差
function timeDiff(date){
	var date1 = date;//开始时间
	var date2 = new Date();//结束时间
	var date3 = date2.getTime()-date1.getTime();//时间差的毫秒数
	//计算出相差天数
	var days = Math.floor(date3/(24*3600*1000));
	//计算出小时数
	var leave1 = date3%(24*3600*1000);//计算天数后剩余的毫秒数
	var hours = Math.floor(leave1/(3600*1000));
	//计算相差分钟数
	var leave2 = leave1%(3600*1000);//计算小时数后剩余的毫秒数
	var minutes = Math.floor(leave2/(60*1000));
	//计算相差秒数
	var td = "30秒前";
	if(days > 0){
		if (days > 10) {
			var date1year = date1.getFullYear();
			var date2year = date2.getFullYear();
			var date1month = date1.getUTCMonth()+1;
			var date1day = date1.getDate();
			if(date1month < 10){
				date1month ="0"+date1month;
			}
			if(date1day < 10){
				date1day ="0"+date1day;
			}
			if (date1year<date2year){
				td = date1.getFullYear()+"-"+date1month+"-"+date1day;
			}else{
				td = date1month+"-"+date1day;
			}
		} else {
			td = days+"天前"
		}
	}else if(hours > 0){
		td = hours+"小时前";
	}else if(minutes > 0){
		td = minutes+"分钟前";
	}
	return td;
}
function redirect(zbadd,link,sid,sds){
	link = link.replace(/\n/g,"");
	if(!/^http/.test(link)){
		link="http://"+link
	}
	if(sds){
		window.location.href="/visit/redirect?id="+sid+"&url="+escape(link)+"&keywords="+encodeURIComponent(sds);
	}else{
		window.location.href="/visit/redirect?id="+sid+"&url="+escape(link);
	}
}
function newredirect(zbadd,link,sid,sds){
	link = link.replace(/\n/g,"");
	if(!/^http/.test(link)){
		link="http://"+link
	}
	if(sds){
		window.location.href=zbadd+"/article/content/"+sid+".html?url="+escape(link)+"&keywords="+encodeURIComponent(sds);
	}else{
		window.location.href=zbadd+"/article/content/"+sid+".html?url="+escape(link);
	}
}
function pcredirect(link,sid){
	window.open("/pcdetail/"+sid+".html");
}
function keyWordHighlight(value,oldChar,newChar){
	try{
		oldChar = oldChar.replace(/\$/g,"\\$");
		oldChar = oldChar.replace(/\(/g,"\\(");
		oldChar = oldChar.replace(/\)/g,"\\)");
		oldChar = oldChar.replace(/\*/g,"\\*");
		oldChar = oldChar.replace(/\+/g,"\\+");
		oldChar = oldChar.replace(/\./g,"\\.");
		oldChar = oldChar.replace(/\[/g,"\\[");
		oldChar = oldChar.replace(/\]/g,"\\]");
		oldChar = oldChar.replace(/\?/g,"\\?");
		oldChar = oldChar.replace(/\\/g,"\\");
		oldChar = oldChar.replace(/\//g,"\\/");
		oldChar = oldChar.replace(/\^/g,"\\^");
		oldChar = oldChar.replace(/\{/g,"\\{");
		oldChar = oldChar.replace(/\}/g,"\\}");
		if(typeof(oldChar) == "undefined" || oldChar == null || oldChar == "" || typeof(newChar) == "undefined" || newChar == null || newChar == ""){
			return value;
		}
		return value.replace(new RegExp("("+oldChar+")",'gmi'),newChar);
	}catch(e){
		return value;
	}
}
function getWxVersion(){
	var wechatInfo = navigator.userAgent.match(/MicroMessenger\/([\d\.]+)/i);
	if(!wechatInfo) {
	  	return null;
	}
	return wechatInfo[1];
}
/**
 * 设置光标在短连接输入框中的位置
 * @param inpObj 输入框
 * @param pos
 */
function setCursorPos(inpObj, pos){
    if(navigator.userAgent.indexOf("MSIE") > -1){
        var range = document.selection.createRange();
        var textRange = inpObj.createTextRange();
        textRange.moveStart('character',pos);
        textRange.collapse();
        textRange.select();
    }else{
        inpObj.setSelectionRange(pos,pos);
    }
}
/**
 * 获取光标在短连接输入框中的位置
 * @param inpObj 输入框
 */
function getCursorPos(inpObj){
     if(navigator.userAgent.indexOf("MSIE") > -1) { // IE
        var range = document.selection.createRange();
        range.text = '';
        range.setEndPoint('StartToStart',inpObj.createTextRange());
        return range.text.length;
    } else {
        return inpObj.selectionStart;
    }
}
//获取url中参数
function getUrlParam(name){
    var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
    var r = window.location.search.substr(1).match(reg);
    if(r != null)
		return unescape(r[2]); 
	return null;
}