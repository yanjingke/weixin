<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />
        <link rel="stylesheet" type="text/css" href="/weixin/Public/Home/css/base.css" />
        <link rel="stylesheet" type="text/css" href="/weixin/Public/Home/css/index.css" />
        <link rel="stylesheet" href="/weixin/Public/Home/css/weui.min.css"/>
        <link rel="stylesheet" href="/weixin/Public/Home/css/jquery-weui.min.css"/>
        <link rel="stylesheet" href="/weixin/Public/Home/css/style.css"/>
        <link rel="stylesheet" href="/weixin/Public/Home/css/banner.css"/>
        <script type="text/javascript" src="/weixin/Public/Home/js/jquery.min.js"></script>
        <script type="text/javascript" src="/weixin/Public/Home/js/jquery-weui.min.js"></script>
        <script type="text/javascript" src="/weixin/Public/Home/js/jquery.js"></script>
        <script type="text/javascript" src="/weixin/Public/Home/js/jquery.flexslider-min.js"></script>
        <script src="https://cdn.bootcss.com/jquery-weui/1.0.1/js/city-picker.min.js"></script>
        <script type="text/javascript" src="/weixin/Public/Home/js/base.js"></script>
        <title>微新闻</title>
    </head>
    <body>
    <div class="block_home_slider">
        <div id="home_slider" class="flexslider">
            <ul class="slides">
                <li>
                    <div class="slide">
                        <img src="/weixin/Public/Home/images/pic_home_slider_1.jpg" alt="" />
                        <div class="caption">
                            <p class="title">国内金准营销服务中心</p>
                            <p>90天让您的网站升级100倍。国内金准营销服务中心.国内金准营销服务中心国内金准营销服务中心国内金准营销服务中心国内金准营销服务中心</p>
                        </div>
                    </div>
                </li>

                <li>
                    <div class="slide">
                        <img src="/weixin/Public/Home/images/pic_home_slider_2.jpg" alt="" />
                        <div class="caption">
                            <p class="title">国内金准营销服务中心</p>
                            <p>90天让您的网站升级100倍。国内金准营销服务中心.国内金准营销服务中心国内金准营销服务中心国内金准营销服务中心国内金准营销服务中心</p>
                        </div>
                    </div>
                </li>

                <li>
                    <div class="slide">
                        <img src="/weixin/Public/Home/images/pic_home_slider_3.jpg" alt="" />
                        <div class="caption">
                            <p class="title">国内金准营销服务中心</p>
                            <p>90天让您的网站升级100倍。国内金准营销服务中心.国内金准营销服务中心国内金准营销服务中心国内金准营销服务中心国内金准营销服务中心</p>
                        </div>
                    </div>
                </li>

                <li>
                    <div class="slide">
                        <img src="/weixin/Public/Home/images/pic_home_slider_4.jpg" alt="" />
                        <div class="caption">
                            <p class="title">国内金准营销服务中心</p>
                            <p>90天让您的网站升级100倍。国内金准营销服务中心.国内金准营销服务中心国内金准营销服务中心国内金准营销服务中心国内金准营销服务中心</p>
                        </div>
                    </div>
                </li>


            </ul>
        </div>

        <script type="text/javascript">
            $(function () {
                $('#home_slider').flexslider({
                    animation : 'slide',
                    controlNav : true,
                    directionNav : true,
                    animationLoop : true,
                    slideshow : false,
                    useCSS : false
                });
            });

        </script>
    </div>
    <div class="weui-tab" style="position:absolute;height: 100%;width:100%;">
        <!--新闻-->
        <div class="content">
        <?php if(!empty($news)): ?><ul class="tabslider yb-ul" style="padding:0 0.5rem;">
            <?php if(is_array($news)): $i = 0; $__LIST__ = $news;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$n): $mod = ($i % 2 );++$i;?><a href="<?php echo ($n["url"]); ?>">
                <li class="clearfix" >
                    <div class="yb-ul-title clearfix" a="<?php echo ($n["id"]); ?>">
                        <input type="hidden" name="id" value="<?php echo ($n["id"]); ?>">
                        <h2 class="zq-name fL"><img src="/weixin/Public/Home/images/gf.png"><?php echo ($n["source"]); ?></h2>
                        <span class="pro-name fL"><?php echo ($n["tags"]); ?><img src="/weixin/Public/Home/images/important.png" class="d-v"></span>
                        <span class="hy-b fR"><?php echo ($n["area"]); ?></span>
                    </div>
                    <div class="yb-ul-inf clearfix" style="border-top:1px solid #f0f0f0;" a="<?php echo ($n["id"]); ?>">
                        <a href="<?php echo U('Index/detail?id='.$n['id']);?>"><?php echo ($n["title"]); ?></a><span class="yb-time"><?=date('Y-m-d',$n['ptime'])?></span>
                    </div>
                    </li>
                </a><?php endforeach; endif; else: echo "" ;endif; ?>
        </ul><?php endif; ?>
        </div>
        <!--查看更多-->
        <div class="view-more tC"><a href="javascript:;" onclick="loadmore()">查看更多新闻</a></div>
    </div>
    </body>
    <script>
        function loadmore() {

            var id = $(".tabslider li:last-child .yb-ul-title").attr('a');
            var html = $(".tabslider").html();
            var url = "<?php echo U('more');?>";
            $.post(url,{id:id},function(data){
                if(data)
                {
                    $(".tabslider").html(html+data);
                }
            });
        }

    </script>
</html>