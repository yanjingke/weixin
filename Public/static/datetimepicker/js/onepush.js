$(function () {
  'use strict';


  //无限滚动
  $(document).on("pageInit", "#page-infinite-scroll-bottom", function(e, id, page) {
    var loading = false;
    // 每次加载添加多少条目
    var itemsPerLoad = 20;
    // 最多可加载的条目
    var maxItems = 100;
    var lastIndex = $('.list-container li').length;
    function addItems(number, lastIndex) {
      // 生成新条目的HTML
      var html = '';
      for (var i = lastIndex + 1; i <= lastIndex + number; i++) {
        html += '<li class="item-content"><div class="item-inner"><div class="item-title">新条目</div></div></li>';
      }
      // 添加新条目
      $('.infinite-scroll .list-container').append(html);
    }
    $(page).on('infinite', function() {
      // 如果正在加载，则退出
      if (loading) return;
      // 设置flag
      loading = true;
      // 模拟1s的加载过程
      setTimeout(function() {
        // 重置加载flag
        loading = false;
        if (lastIndex >= maxItems) {
          // 加载完毕，则注销无限加载事件，以防不必要的加载
          $.detachInfiniteScroll($('.infinite-scroll'));
          // 删除加载提示符
          $('.infinite-scroll-preloader').remove();
          return;
        }
        addItems(itemsPerLoad,lastIndex);
        // 更新最后加载的序号
        lastIndex = $('.list-container li').length;
        $.refreshScroller();
      }, 1000);
    });
  });

  //顶部无限滚动
  $(document).on("pageInit", "#page-infinite-scroll-top", function(e, id, page) {
    function addItems(number, lastIndex) {
      // 生成新条目的HTML
      var html = '';
      for (var i = lastIndex+ number; i > lastIndex ; i--) {
        html += '<li class="item-content"><div class="item-inner"><div class="item-title">条目'+i+'</div></div></li>';
      }
      // 添加新条目
      $('.infinite-scroll .list-container').prepend(html);

    }
    var timer = false;
    $(page).on('infinite', function() {
       var lastIndex = $('.list-block li').length;
       var lastLi = $(".list-container li")[0];
       var scroller = $('.infinite-scroll-top');
       var scrollHeight = scroller[0].scrollHeight; // 获取当前滚动元素的高度
      // 如果正在加载，则退出
      if (timer) {
        clearTimeout(timer);
      }

      // 模拟1s的加载过程
      timer = setTimeout(function() {

        addItems(20,lastIndex);

        $.refreshScroller();
        //  lastLi.scrollIntoView({
        //     behavior: "smooth",
        //     block:    "start"
        // });
        // 将滚动条的位置设置为最新滚动元素高度和之前的高度差
        scroller.scrollTop(scroller[0].scrollHeight - scrollHeight);
      }, 1000);
    });

  });
  //test demo js

  
 

  $.init();
});
