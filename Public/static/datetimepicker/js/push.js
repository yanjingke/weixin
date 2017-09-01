	$(function () {
  'use strict';

 function addItems(number, lastIndex) {
			// alert(lastIndex+"  "+number);
      // 生成新条目的HTML
      var html = '';
      for (var i = lastIndex + 1; i <= lastIndex + number; i++) {
        html += '<li class="item-content"">'+i+'</li>';
      }
      // 添加新条目
      $('.infinite-scroll.active .list-container').append(html);
    }
 var a=null;
 
 function addItemstab1(number, lastIndex) {
		// alert(lastIndex+"  "+number);
// 生成新条目的HTML
	 var url= "http://yanjingke.w3.luyouxia.net/weixin/index.php/Home/Legislativtre/dynamic";
	  var b=lastIndex;
	  if(b!=a){
	    $.ajax({
			url:url,
			type: "get",
			data:{p:lastIndex},
			success: function(data){
				var html = '';
				$.each(data, function(index, content)
						  { 
//					/alert(content.ptime+" sada1");
					if(content.ptime==false){
						content.ptime="";
					}
				 	html +=  '<li class="item-content"> <div class="item-media"><img src="'+content.img_url+'" width="44"></div> <div class="item-inner"><div class="item-title-row"><div class="item-title"><a href="http://yanjingke.w3.luyouxia.net/weixin/index.php/Home/Index/detail/id/'+content.id +'.html">'+content.title+'</a></div></div><div class="item-subtitle"><font color="#BEBEBE">'+content.clean_content+'</font></div></div> </li><div class="card-footer"><span></span><span >'+ content.ptime+'</span></div>  ';
				 	
						  // alert( "the man's no. is: " + index + ",and " + content.name + " is learning " + content.lang ); 
						  });
				   $('.infinite-scroll.active .list-container').append(html);
	    }
	  })
	  a=b;
	  }



}
 var c=null;
 function addItemstab2(number, lastIndex) {
		// alert(lastIndex+"  "+number);
//生成新条目的HTML
	 var url= "http://yanjingke.w3.luyouxia.net/weixin/index.php/Home/Legislativtre/planList";
	  var b=lastIndex;
	  if(b!=c){
	    $.ajax({
			url:url,
			type: "get",
			data:{p:lastIndex},
			success: function(data){
				var html = '';
				$.each(data, function(index, content)
						  { 
					if(content.ptime==false){
						content.ptime="";
					}
					html +=  '<li class="item-content"> <div class="item-media"><img src="'+content.img_url+'" width="44"></div> <div class="item-inner"><div class="item-title-row"><div class="item-title"><a href="http://yanjingke.w3.luyouxia.net/weixin/index.php/Home/Index/detail/id/'+content.id +'.html">'+content.title+'</a></div></div><div class="item-subtitle"><font color="#BEBEBE">'+content.clean_content+'</font></div></div> </li><div class="card-footer"><span></span><span >'+ content.ptime+'</span></div>  ';
				 	
						  // alert( "the man's no. is: " + index + ",and " + content.name + " is learning " + content.lang ); 
						  });
				   $('.infinite-scroll.active .list-container').append(html);
	    }
	  })
	  c=b;
	  }



}
 var d=null;
 function addItemstab3(number, lastIndex) {
		// alert(lastIndex+"  "+number);
//生成新条目的HTML
	 var url= "http://yanjingke.w3.luyouxia.net/weixin/index.php/Home/Legislativtre/publicityList";
	  var b=lastIndex;
	  if(b!=d){
	    $.ajax({
			url:url,
			type: "get",
			data:{p:lastIndex},
			success: function(data){
				var html = '';
				$.each(data, function(index, content)
						  { 
					if(content.ptime==false){
						content.ptime="";
					}
					html +=  '<li class="item-content"> <div class="item-media"><img src="'+content.img_url+'" width="44"></div> <div class="item-inner"><div class="item-title-row"><div class="item-title"><a href="http://yanjingke.w3.luyouxia.net/weixin/index.php/Home/Index/detail/id/'+content.id +'.html">'+content.title+'</a></div></div><div class="item-subtitle"><font color="#BEBEBE">'+content.clean_content+'</font></div></div> </li><div class="card-footer"><span></span><span >'+ content.ptime+'</span></div>  ';
				 	
						  // alert( "the man's no. is: " + index + ",and " + content.name + " is learning " + content.lang ); 
						  });
				   $('.infinite-scroll.active .list-container').append(html);
	    }
	  })
	  d=b;
	  }



}
 var e=null;
 function addItemstab4(number, lastIndex) {
		// alert(lastIndex+"  "+number);
//生成新条目的HTML
	 var url= "http://yanjingke.w3.luyouxia.net/weixin/index.php/Home/Legislativtre/newlawList";
	  var b=lastIndex;
	  if(b!=e){
	    $.ajax({
			url:url,
			type: "get",
			data:{p:lastIndex},
			success: function(data){
				var html = '';
				$.each(data, function(index, content)
						  { 
					if(content.ptime==false){
						content.ptime="";
					}
				 	html +=  '<li class="item-content"> <div class="item-media"><img src="'+content.img_url+'" width="44"></div> <div class="item-inner"><div class="item-title-row"><div class="item-title"><a href="http://yanjingke.w3.luyouxia.net/weixin/index.php/Home/Index/detail/id/'+content.id +'.html">'+content.title+'</a></div></div><div class="item-subtitle"><font color="#BEBEBE">'+content.clean_content+'</font></div></div> </li><div class="card-footer"><span></span><span >'+ content.ptime+'</span></div>  ';
				 	
						  // alert( "the man's no. is: " + index + ",and " + content.name + " is learning " + content.lang ); 
						  });
				   $('.infinite-scroll.active .list-container').append(html);
	    }
	  })
	  e=b;
	  }



}
 function addItems(number, lastIndex) {
		// alert(lastIndex+"  "+number);
// 生成新条目的HTML
var html = '';
for (var i = lastIndex + 1; i <= lastIndex + number; i++) {
 html += '<li class="item-content"">'+i+'</li>';
}
// 添加新条目
$('.infinite-scroll.active .list-container').append(html);
}
 function initaddItemstabtabe1(data) {
			// alert(lastIndex+"  "+number);
      // 生成新条目的HTML
	 var html = '';
	 $.each(data, function(index, content)
	 		  { 
		 if(content.ptime==false){
				content.ptime="";
			}
		 //alert(content.img_url);
	 	html +=  '<li class="item-content"> <div class="item-media"><img src="'+content.img_url+'" width="44"></div> <div class="item-inner"><div class="item-title-row"><div class="item-title"><a href="http://yanjingke.w3.luyouxia.net/weixin/index.php/Home/Index/detail/id/'+content.id +'.html">'+content.title+'</a></div></div><div class="item-subtitle"><font color="#BEBEBE">'+content.clean_content+'</font></div></div> </li><div class="card-footer"><span></span><span >'+ content.ptime+'</span></div>  ';
	 		  // alert( "the man's no. is: " + index + ",and " + content.name + " is learning " + content.lang ); 
	 		  });

	 // 添加新条目
	 $('#tab1 .list-container').append(html);
    }

  //多个标签页下的无限滚动
  $(document).on("pageInit", "#page-fixed-tab-infinite-scroll", function(e, id, page) {
    var loading = false;
    // 每次加载添加多少条目
   // alert(e+"  ");
    var itemsPerLoad = 15;
    // 最多可加载的条目
    var maxItems = 500;
    var url= "http://yanjingke.w3.luyouxia.net/weixin/index.php/Home/Legislativtre/dynamic";
    $.ajax({
		url:url,
		type: "get",
		
		success: function(data){
    	initaddItemstabtabe1(data);
    }
    })
    var count=null;
     var url= "http://yanjingke.w3.luyouxia.net/weixin/index.php/Home/Legislativtre/count.html";
    $.ajax({
		url:url,
		type: "get",
		
		success: function(data){
    	count=data;
        //alert(count);
    }
    })

    var lastIndex = 50;
   var plancount=0;
   var dynmicount=0;
   var standcount=0;
   var noticecount=0;
 
    $(page).on('infinite', function() {
      // 如果正在加载，则退出
    	   $.each(count, function(index, content){
    		   plancount=content.plancount;
    		   dynmicount=content.dynmicount;
    		   standcount=content.standcount;
    		   noticecount=content.noticecount;
    		   
    		 }
    		 )
    		// alert(plancount+""+dynmicount+" "+ standcount+""+noticecount)
      if (loading) return;
      // 设置flag
      loading = true;
      var tabIndex = 0;
      if($(this).find('.infinite-scroll.active').attr('id') == "tab1"){
          //var lastIndex1= $('#tab2 .list-container li')[0].length;
           var lastInde2=0;
          tabIndex = 0;
        var lastInde3= $('#tab1 li').length;
      
        if(lastInde3%15==0){
        	lastInde2=lastInde3/15;
        	
        }
        if(lastInde3%15!=0){
        	//alert( lastInde2);
        	lastInde2=parseInt(lastInde3/15)+1;
        	 
        }
       
        lastInde2=lastInde2+1;
        var  dynmicountone=0;
        if( dynmicount%15==0){
        	dynmicountone=dynmicount/15;
        }
        if( dynmicount%15!=0){
        	dynmicountone= dynmicount/15+1;
        }
        if(lastInde2>=dynmicountone ){
       	   $('#tab1 .infinite-scroll-preloader').eq(tabIndex).hide();
            //  return
        }
        //alert(lastInde2);
       // alert(lastInde2+"   "+itemsPerLoad);
    	addItemstab1(itemsPerLoad, lastInde2);
        }
      if($(this).find('.infinite-scroll.active').attr('id') == "tab2"){
    	 
        //var lastIndex1= $('#tab2 .list-container li')[0].length;
    	  var lastInde2=0;
          tabIndex = 0;
        var lastInde3= $('#tab2 li').length;
      if(lastInde3==null){
    	  lastInde3=0;
      }
      if(itemsPerLoad==null){
    	  itemsPerLoad=0;
      }
        if(lastInde3%15==0){
        	lastInde2=lastInde3/15;
        	
        }
        if(lastInde3%15!=0){
        	//alert( lastInde2);
        	lastInde2=parseInt(lastInde3/15)+1;
        	 
        }
       
        lastInde2=lastInde2+1;
        var  plancountone=0;
        if( plancount%15==0){
        	plancountone=plancount/15;
        }
        if( plancount%15!=0){
        	plancountone= parseInt(plancount/15)+1;
        }
        //alert(lastInde2+"　"+plancountone);
        if(lastInde2>=plancountone ){
      	   $('#tab2 .infinite-scroll-preloader').eq(tabIndex).hide();
               //return
        }
        
       // alert(lastInde2+"   "+itemsPerLoad);
      
    	addItemstab2(itemsPerLoad, lastInde2);
      }
      if($(this).find('.infinite-scroll.active').attr('id') == "tab3"){
       
    	  //var lastIndex1= $('#tab2 .list-container li')[0].length;
    	  var lastInde2=0;
          tabIndex = 0;
        var lastInde3= $('#tab3 li').length;
      if(lastInde3==null){
    	  lastInde3=0;
      }
      if(itemsPerLoad==null){
    	  itemsPerLoad=0;
      }
        if(lastInde3%15==0){
        	lastInde2=lastInde3/15;
        	
        }
        if(lastInde3%15!=0){
        	//alert( lastInde2);
        	lastInde2=parseInt(lastInde3/15)+1;
        	 
        }
       
        lastInde2=lastInde2+1;
        var  standcountone=0;
        if( standcount%15==0){
        	standcountone=standcount/15;
        }
        if( standcount%15!=0){
        	standcountone= parseInt(standcount/15)+1;
        }
        //alert(lastInde2+"　"+plancountone);
        if(lastInde2>=standcountone ){
      	   $('#tab3 .infinite-scroll-preloader').eq(tabIndex).hide();
               //return
        }
        
       // alert(lastInde2+"   "+itemsPerLoad);
      
    	addItemstab3(itemsPerLoad, lastInde2);
      }
      if($(this).find('.infinite-scroll.active').attr('id') == "tab4"){
          
    	  //var lastIndex1= $('#tab2 .list-container li')[0].length;
    	  var lastInde2=0;
          tabIndex = 0;
        var lastInde3= $('#tab4 li').length;
      if(lastInde3==null){
    	  lastInde3=0;
      }
      if(itemsPerLoad==null){
    	  itemsPerLoad=0;
      }
        if(lastInde3%15==0){
        	lastInde2=lastInde3/15;
        	
        }
        if(lastInde3%15!=0){
        	//alert( lastInde2);
        	lastInde2=parseInt(lastInde3/15)+1;
        	 
        }
       
        lastInde2=lastInde2+1;
        var  noticecountone=0;
        if( noticecount%15==0){
        	noticecountone=noticecount/15;
        }
        if( noticecount%15!=0){
        	plancountone= parseInt(noticecount/15)+1;
        }
        //alert(lastInde2+"　"+plancountone);
        if(lastInde2>=noticecountone ){
      	   $('#tab4 .infinite-scroll-preloader').eq(tabIndex).hide();
               //return
        }
        
       // alert(lastInde2+"   "+itemsPerLoad);
      
    	addItemstab4(itemsPerLoad, lastInde2);
        }
      lastIndex = $('.list-container').eq(tabIndex).find('li').length;
      // 模拟1s的加载过程
      setTimeout(function() {
        // 重置加载flag
        loading = false;
        if (lastIndex >= maxItems) {
          // 加载完毕，则注销无限加载事件，以防不必要的加载
          //$.detachInfiniteScroll($('.infinite-scroll').eq(tabIndex));
          // 删除加载提示符
          $('.infinite-scroll-preloader').eq(tabIndex).hide();
          return;
        }
      //  addItems(itemsPerLoad,lastIndex);
        // 更新最后加载的序号
        lastIndex =  $('.list-container').eq(tabIndex).find('li').length;
        $.refreshScroller();
      }, 1000);
    });
  });





  

  //加载提示符
  $(document).on("pageInit", "#page-preloader", function(e, id, page) {
    $(page).on('click','.open-preloader-title', function () {
      $.showPreloader('加载中...')
      setTimeout(function () {
        $.hidePreloader();
      }, 2000);
    });
    $(page).on('click','.open-indicator', function () {
      $.showIndicator();
      setTimeout(function () {
        $.hideIndicator();
      }, 2000);
    });
  });


 
 
  
 

  $.init();
});