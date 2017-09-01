<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="stylesheet" type="text/css" href="/weixin/Public/Home/css/base.css" />
    <link rel="stylesheet" type="text/css" href="/weixin/Public/Home/css/index.css" />
    <link rel="stylesheet" href="/weixin/Public/Home/css/weui.min.css"/>
    <link rel="stylesheet" href="/weixin/Public/Home/css/jquery-weui.min.css"/>
    <link rel="stylesheet" href="/weixin/Public/Home/css/style.css"/>
    <script type="text/javascript" src="/weixin/Public/Home/js/jquery.min.js"></script>
    <script type="text/javascript" src="/weixin/Public/Home/js/jquery-weui.min.js"></script>
    <!--<script type="text/javascript" src="js/city-picker.js" charset="utf-8" ></script>-->
    <script src="https://cdn.bootcss.com/jquery-weui/1.0.1/js/city-picker.min.js"></script>
    <title>列表</title>
</head>
<body>

<script>
    function getlist(obj,i)
    {
        $(".list-label button").css("background-color",'gray');
        $(obj).addClass('listBtn');
        $(obj).css("background-color",'');
        var u = "<?php echo U('getTypeList');?>";
        $.post(u,{i:i},function(data){
            if(data)
            {
                $(".idx-content").html(data);
            }
        });
    }
</script>
<div id="tab4" class="weui-tab__bd-item">
    <div class="dy-nav">
        <p>所有分类</p>

        </div>

    <div class="list-label">
        <?php if(!empty($tags)): if(is_array($tags)): $k = 0; $__LIST__ = $tags;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$l): $mod = ($k % 2 );++$k; if($k == 1): ?><button class="listBtn weui-btn weui-btn_warn weui-btn_mini" onclick="getlist(this,'<?php echo ($l["id"]); ?>')" ><a href="javascript:;" id="b<?php echo ($l["id"]); ?>"><?php echo ($l["name"]); ?></a></button>
                    <?php else: ?>
                    <button class="weui-btn weui-btn_warn weui-btn_mini" onclick="getlist(this,'<?php echo ($l["id"]); ?>')" ><a href="javascript:;" onclick="getlist('<?php echo ($l["id"]); ?>')"><?php echo ($l["name"]); ?></a></button><?php endif; endforeach; endif; else: echo "" ;endif; endif; ?>
    </div>

    <div class="weui-tab idx-content">
        <ul class="index-text list-ul" >
            <?php if(is_array($list)): $k = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$n): $mod = ($k % 2 );++$k;?><a href="<?php echo U('Index/detail?id='.$n['id']);?>">
                    <!--<li class="clearfix" >-->
                        <!--[<span style="color:red;"><?php echo ($k); ?></span>]-->
                            <!--<span class="yb-ul-inf clearfix">-->
                                <!--<?php echo ($n["title"]); ?><span class="yb-time"><?=date('Y-m-d',$n['ptime'])?></span>-->
                            <!--</span>-->
                    <!--</li>-->
                    <li class="clearfix" >
                        <div class="yb-ul-title clearfix">
                            <h2 class="zq-name fL"><img src="/weixin/Public/Home/images/gf.png"><?php echo ($n['source']); ?></h2>
                            <span class="pro-name fL"><?php echo ($n['tags']); ?><img src="/weixin/Public/Home/images/important.png" class="d-v"></span>
                        </div>
                        <div class="yb-ul-inf clearfix" >
                            <a href=""><?php echo ($n["title"]); ?></a><span class="yb-time fr" style="border-top:1px solid #f0f0f0;text-align: right;font-size: 0.48rem;margin-top: 0.32rem;"><?=date('Y-m-d',$n['ptime'])?></span>
                    </div>
                    </li>

                </a><?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
    </div>

</div>

</body>
</html>