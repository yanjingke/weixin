function initShare(signature,openid,isentry,activecode,nickname,avatar,id){
	var myloc = window.location.host;
	myloc="https://"+myloc;
	activecode=activecode||""
	if(typeof(openid) == "undefined" || openid == null || openid == ""){
		openid = "-1";
	}
	if(typeof(signature) != "undefined" && signature != null && signature.length == 4){
		wx.config({
		    debug: false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
		    appId: signature[0], // 必填，公众号的唯一标识
		    timestamp:signature[1], // 必填，生成签名的时间戳
		    nonceStr: signature[2], // 必填，生成签名的随机串
		    signature: signature[3],// 必填，签名，见附录1
		    jsApiList: ['onMenuShareTimeline', 'onMenuShareAppMessage'] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
		});
		var title="第一时间精准推送招标信息，就在剑鱼招标订阅";
		var title1="第一时间精准推送招标信息，就在剑鱼招标订阅";
		var link=myloc+"/swordfish/shareabout/"+openid+"__"+activecode;
		var desc="关注微信并设置剑鱼关键词，全国招标信息统统推送给您！";
		var url = "/wxswordfish/images/small_log.jpg";
		var encryptid = "";
		var subhref = window.location.href;
		if(id !=undefined){
			$.ajax({
		        type:'post',
		        url:'/share/encrypt',
		        data:{id:id},
		        cache:false,
		        dataType:'json', 
		        success:function(data){
					if(data.flag == "T"){
						encryptid = data.sid_openid;
						var add1 = subhref.substring(0,subhref.indexOf("/content/"));
						var add2 = subhref.substring(subhref.indexOf(".html"));
						subhref = add1 +"/content/"+ encryptid + add2;
					}
		        }
		    });
		}
		wx.ready(function () {
			if (isentry==1){
				desc=$(".info .title").text();
				if(encryptid == ""){
					link = window.location.href+"&openid="+encodeURIComponent(openid);
				}else{
					link = subhref;
				}
				
				if (desc == "" && pcname!=""){
					desc = pcname;
				}
				title1=desc;
			}else if (isentry==2){
				if(nickname!=""){
					desc = '您的朋友'+nickname+'向您推荐了剑鱼招标订阅！';
				}
				if(avatar!=""){
					url = avatar;
				}
			}else if (isentry == 3){
				var id = nickname;
				if (pcname!=""){
					desc = pcname;
					link=myloc+"/follow/shareFW/"+id+"__"+pcname+"__"+openid;
				}
				title1=desc;
			}
	        wx.onMenuShareTimeline({
			    title: title1, // 分享标题
			    link: link, // 分享链接
			    imgUrl: myloc+'/wxswordfish/images/small_log.jpg', // 分享图标
			    success: function () { 
			       //alert('分享成功');
			    },
			    cancel: function () {
			       //alert('分享失败，或用户取消了');
			    }
			});
			wx.onMenuShareAppMessage({
			    title: title, // 分享标题
			    desc: desc, // 分享描述
			    link: link, // 分享链接
			    imgUrl: myloc+url, // 分享图标
			    type: 'link', // 分享类型,music、video或link，不填默认为link'
			    dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
			    success: function () {
			        //alert('分享成功');
			    },
			    cancel: function () {
					//alert('分享失败，或用户取消了');
			    }
			});
	    });
		wx.error(function(res){
		    // config信息验证失败会执行error函数，如签名过期导致验证失败，具体错误信息可以打开config的debug模式查看，也可以在返回的res参数中查看，对于SPA可以在这里更新签名。
			//alert("error auth");
		});
	}
}
