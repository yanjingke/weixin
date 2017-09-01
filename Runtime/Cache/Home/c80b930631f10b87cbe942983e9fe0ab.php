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
    <title>订阅</title>
</head>
<body>
<script>
    $(function(){
        $(".cancel").css('background-image',"url(/weixin/Public/Home/images/cancel.png)");
    });
    function order(id,is_order)
    {
            if(is_order == 'cancel')
            {
                var action = 'cancel';
            }
            else
            {
                var action = 'add';
            }
        console.log(action);
            var tags = $(".tags").val();
            if(tags != '' ||　action == 'cancel') {
                var uid = <?php echo ($uid); ?>;
                $.ajax({
                    type: 'post',
                    url: "<?php echo U('add');?>",
                    data: 'action=' + action + '&id=' + id + '&uid=' + uid + '&tags=' + tags,
                    success: function (data) {
                        if(data == '0')
                        {
                            alert('重复订阅');
                        }
                        window.location.reload();
                    }
                });
            }
    }
</script>
<div class="weui-tab__bd-item">
    <div class="order-nav"><a href="<?php echo U('Index/lists?uid='.$uid);?>">查看分类</a>
        <a href="<?php echo U('Index/push?uid='.$uid);?>" class="fr">推送设置</a>
    </div>
    <div class="dy-content">
        <ul class="ts-input">
            <?php if(!empty($order)): if(is_array($order)): $i = 0; $__LIST__ = $order;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$o): $mod = ($i % 2 );++$i;?><li> <span><img src="/weixin/Public/Home/images/order.png" alt="" style="width:30px;height:30px;"></span><input type="text" id="tag<?php echo ($v["id"]); ?>" placeholder="请输入关键词查" u="<?php echo U('getType');?>" value="<?php echo ($o["tag_name"]); ?>"/> <a href="javascript:;" onclick="order('<?php echo ($o["id"]); ?>','cancel')" class="cancel"></a></li><?php endforeach; endif; else: echo "" ;endif; endif; ?>
            <li> <span><img src="/weixin/Public/Home/images/order.png" alt="" style="width:30px;height:30px;"></span><input type="text" class="tags" placeholder="请输入关键词" u="<?php echo U('getType');?>"/> <a href="javascript:;" onclick="order('<?php echo ($v["id"]); ?>','order')"></a></li>

		<li> <span><img src="/weixin/Public/Home/images/order.png" alt="" style="width:30px;height:30px;"></span><input type="text" class="tags weui-input" placeholder="请输入关键词" u="<?php echo U('getType');?>"/ id="home-city"> <a href="javascript:;" onclick="order('<?php echo ($v["id"]); ?>','order')"></a></li>

        </ul>

</div>
</div>
<script>
$("#home-city").cityPicker({
    title: "选择目的地",
    showDistrict: false,
    onChange: function (picker, values, displayValues) {
      console.log(values, displayValues);
    }
  });
</script>
</body>
</html>