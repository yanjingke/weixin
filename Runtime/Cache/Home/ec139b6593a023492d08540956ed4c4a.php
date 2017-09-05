<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
    <link rel="stylesheet" type="text/css" href="/weixin/Public/Home/css/base.css" />
    <link rel="stylesheet" type="text/css" href="/weixin/Public/Home/css/index.css" />
    <link rel="stylesheet" type="text/css" href="/weixin/Public/Home/css/demo.css" />
    <link rel="stylesheet" href="/weixin/Public/Home/css/weui.min.css"/>
    <link rel="stylesheet" href="/weixin/Public/Home/css/jquery-weui.min.css"/>
    <link rel="stylesheet" href="/weixin/Public/Home/css/style.css"/>
    <script type="text/javascript" src="/weixin/Public/Home/js/jquery.min.js"></script>
    <script type="text/javascript" src="/weixin/Public/Home/js/jquery-weui.min.js"></script>
    <script src="/weixin/Public/Home/js/picker.min.js"></script>
    <script src="/weixin/Public/Home/js/city.js"></script>
    <script src="https://cdn.bootcss.com/jquery-weui/1.0.1/js/city-picker.min.js"></script>
</head>
<script>
$(function(){
	
	if(<?php echo ($info[0][start]); ?>){
		$(".infopush").html("<?php echo ($info[0][start]); ?>点-<?php echo ($info[0][end]); ?>点实时推送信息");

		}
	else{
		$(".infopush").html("全天24小时实时推送信息");

		}
		
	   
	
})
    function condition()
    {
        var time = $("#times").val();
        var url = "<?php echo U('setTime');?>";
        var u = '<?php echo ($uid); ?>';
        $.post(url,{type:time,u:u},function(data){
            if(data=='1'){
                alert('设置成功');
            }else{
                alert('设置失败');
            }
            window.location.href = "<?php echo U('Order/index');?>";
        });
    }
    function turn()
    {
        window.location.href = "<?php echo U('Order/lists');?>";
    }


</script>
<body style="background-color: #fafafa">
<div class="order-nav">推送选项
    <a href="javascript:;" class="fr" onclick="condition()">完成</a>
</div>

<div class="weui-cells weui-cells_radio">
    <div class="weui-cell">
        <div class="weui-cell__hd"><img class="pus-ico" src="/weixin/Public/Home/images/pushcheck.png"></div>
        <div class="weui-cell__bd pus-title">
            <p>推送时间</p>
        </div>
    </div>
    <label class="weui-cell weui-check__label pus-pad" for="x11">
        <div class="weui-cell__bd">
            <p>实时推送</p>
            <p>6点-23点实时推送信息</p>
        </div>
        <div class="weui-cell__ft">
            <input type="radio" class="weui-check" value="1" name="radio1" id="x11">
            <span class="weui-icon-checked"></span>
        </div>
    </label>

    <label class="weui-cell weui-check__label pus-pad" for="x12">

        <div class="weui-cell__bd">
            <p>每日推送</p>
            <p>上午9点推送一次信息</p>
        </div>
        <div class="weui-cell__ft">
            <input type="radio" name="radio1" value="2" class="weui-check" id="x12" >
            <span class="weui-icon-checked"  ></span>
        </div>
    </label>

    <label class="weui-cell weui-check__label pus-pad" for="x13">

        <div class="weui-cell__bd">
            <p>自定义时间</p>
            <p class="push-time">
                <p name="info.push" class="infopush"  value="3">
                
                
                 </p>
                </p>
        </div>
        <div class="weui-cell__ft">
            <input type="radio" name="radio1" value=""class="weui-check open-popup" data-target="#time" id="x13">
            <span class="weui-icon-checked" ></span>
        </div>
    </label>

</div>

<div class="weui-cells weui-cells_form">

    <div class="weui-cell">
        <div class="weui-cell__hd"><img class="pus-ico" src="/weixin/Public/Home/images/msg.png"></div>
        <div class="weui-cell__bd pus-title">
            <p>推送方式</p>
        </div>
    </div>
    <div class="weui-cell weui-cell_switch pus-pad">
        <div class="weui-cell__bd">微信提醒</div>
        <div class="weui-cell__ft">
            <input class="weui-switch" type="checkbox" checked="checked">
        </div>
    </div>
    <div class="weui-cell weui-cell_switch pus-pad">
        <div class="weui-cell__bd">邮件提醒</div>
        <div class="weui-cell__ft">
            <label for="switchCP" class="weui-switch-cp">
                <input id="switchCP" class="weui-switch-cp__input" type="checkbox">
                <div class="weui-switch-cp__box"></div>
            </label>
        </div>
    </div>
</div>


<div class="weui-cells">
    <a class="weui-cell weui-cell_access" href="javascript:;">
        <div class="weui-cell__hd"><img class="pus-ico" src="/weixin/Public/Home/images/preview.png"></div>
        <div class="weui-cell__bd pus-title">
            <p onclick="turn()">推送结果预览</p>
        </div>
        <div class="weui-cell__ft">
        </div>
    </a>
    <a class="weui-cell weui-cell_access" href="javascript:;">
        <div class="weui-cell__hd"><img class="pus-ico"src="/weixin/Public/Home/images/preview.png"></div>
        <div class="weui-cell__bd pus-title">
            <p onclick="turn()">历史推送记录</p>
        </div>
        <div class="weui-cell__ft">
        </div>
    </a>
</div>
<input type="hidden" name="times" id="times" value="">
<div id="time" class="weui-popup__container popup-bottom">
    <div class="weui-popup__overlay"></div>
    <div class="weui-popup__modal" style="height: 150px">
        <div class="time-input">
            <select  name="" id="mySelect"></select>
            <span id="select" style="left: 0"></span>
            <select  name="" id="mySelect1"></select>
            <span style="left: 46%" id="select1"></span>
        </div>

        <div class="confirmBtn" >
            <a href="javascript:;" id="subBtn" class="close-popup weui-btn" >确定</a>
            <a href="javascript:;" class="close-popup weui-btn" >取消</a>
        </div>
    </div>
</div>

<script type="text/javascript">

    for(var i =0;i<24;i++){
        var option = "<option value=" + i + ">"+i+"</option>" ;
        $("#mySelect").append(option);
        $("#mySelect1").append(option);
    }
    $(".weui-cell__ft input").click(function(){
        var time = $(this).val();
        $("#times").val(time);
        $("#subBtn").click(function(){
            var time = $("#mySelect").val();
            var time1 = $("#mySelect1").val();
            $(".infopush").text("");
           $(".push-time").text(time+"点-"+time1+"点实时推送信息");
           $("#x13").attr("value",time+","+time1) ;
           $("#times").val($("#x13").val());
           console.log($("#x13").val()) ;
        });
//        alert(time);
    });
    $(".time-input select").change(function(){
        var selectval = $("#mySelect").val();
        var selectval1 = $("#mySelect1").val();
           $("#select").text(selectval);
            $("#select1").text(selectval1)
    })
</script>
</body>
</html>