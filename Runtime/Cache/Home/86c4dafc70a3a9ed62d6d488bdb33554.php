<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
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
    <script type="text/javascript" src="js/city-picker.js" charset="utf-8" ></script>
    <script src="https://cdn.bootcss.com/jquery-weui/1.0.1/js/city-picker.min.js"></script>
    <title>搜素</title>
</head>
<body>
<script>
    function test(id)
    {
        $.ajax({
            type:'post',
            url:"<?php echo U('getTypeList');?>",
            data:'i='+id,
            success:function(data){
                if(data!='0')
                {
                    $(".dy-intro").html(data);
                }
            }
        });
    }
</script>

<div></div>
<div class="search-nav">
    <a href="javascript:;" data-target="#mytime" class="open-popup ">
        发布时间
    </a>
    <a href="javascript:;" data-target="#address" class="open-popup ">
        地区
    </a>
    <a href="javascript:;" data-target="#type" class="open-popup">
        自定义
    </a>
</div>

<div class="src-fel">
    <?php if(is_array($type)): $i = 0; $__LIST__ = $type;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$t): $mod = ($i % 2 );++$i;?><a class="weui-btn  weui-btn_mini" style="background-color: #65dde6"  onclick="test('<?php echo ($t["id"]); ?>')"><?php echo ($t["name"]); ?></a><?php endforeach; endif; else: echo "" ;endif; ?>
</div>

<div class="dy-intro">
    <p style="font-size: 1rem;width:95%;text-align: center;margin: 40% auto">暂无数据！</p>
</div>

<!--选择时间-->
<div id="mytime" class="weui-popup__container popup-bottom">
    <div class="weui-popup__overlay"></div>
    <div class="weui-popup__modal popBg " style="height: 150px;">

        <div class="near-days">
            <a href="javascript:;" class="weui-btn weui-btn_mini weui-btn_plain-default" onclick="selecttime(3)">最近3天</a>
            <a href="javascript:;" class="weui-btn weui-btn_mini weui-btn_plain-default" onclick="selecttime(7)">最近7天</a>
            <a href="javascript:;" class="weui-btn weui-btn_mini weui-btn_plain-default" onclick="selecttime(30)">最近30天</a>
        </div>

        <div class="time-input" >
            <input id="my-input" type="text"  /> -
            <input id="my-input1" type="text" data-toggle='date' />
        </div>
        <div class="confirmBtn" >
            <a href="javascript:;" id="subBtn" class="close-popup weui-btn" >确定</a>
            <a href="javascript:;" class="close-popup weui-btn" >取消</a>
        </div>

        <script>
;
            $("#my-input").calendar();
            $("#my-input1").calendar();

            $("#my-input").change(function(){
                var year =  $(".picker-calendar-day-selected").attr("data-year")
                var month = $(".picker-calendar-day-selected").attr("data-month");
                var day = $(".picker-calendar-day-selected").attr("data-day");
                month  =parseInt(month)+1;
                $(this).attr("value",year+"-"+month+"-"+day)
            })
            $("#my-input1").change(function(){
                var year =  $(".picker-calendar-day-selected").attr("data-year")
                var month = $(".picker-calendar-day-selected").attr("data-month");
                var day = $(".picker-calendar-day-selected").attr("data-day");
                month  =parseInt(month)+1;
                $(this).attr("value",year+"-"+month+"-"+day)
            })

            $("#subBtn").click(function(){
                var timeS = $("#my-input").val();
                var timeE = $("#my-input1").val();
                $.ajax({
                    type: "post",
                    url: "<?php echo U('choose');?>",
                    data: 'type=time&s='+timeS+'&e='+timeE,
                    success: function (data) {
                        if(data != '0') {
                            $(".dy-intro").html(data);
                        }else {
                            $(".dy-intro").html('<p style="font-size: 1rem;width:95%;text-align: center;margin: 40% auto;color: red">暂无内容！</p>');

                        }
//                            $(".time1").css('display','none');
                    },
                    error: function (msg) {
                        alert('暂无相关内容');
//                            $(".time1").css('display','none');
                    }
                });
            });
            function selecttime(t)
            {
                var time = t;
                $.ajax({
                    type: "post",
                    url: "<?php echo U('choose');?>",
                    data: 'type=day&s='+time,
                    success: function (data) {
                        if(data!='0') {
                            $(".dy-intro").html(data);
                        }else {
                            $(".dy-intro").html('<p style="font-size: 1rem;width:95%;text-align: center;margin: 40% auto;color:red">暂无内容！</p>');

                        }
//                            $(".time1").css('display','none');
                    },
                    error: function (msg) {
                        alert('暂无相关内容');

                    }
                });
            }
        </script>
    </div>
</div>

<!--选择地址-->

<div id="address" class="weui-popup__container popup-bottom">
    <div class="weui-popup__overlay"></div>
    <div class="weui-popup__modal" style="height: 200px">
        <div class="address-input">
            <input type="text" id='sel_city'  placeholder="请选择地址"/>
            <!--<a href="#" class="btn btn-info btn-lg active" role="button" id="sel_city">点击选取省市区县</a>-->
            <a href="javascript:;" class="areaBtn weui-btn weui-btn_warn close-popup">确认</a>
        </div>

        <script>

            $("#sel_city").cityPicker({
                title: "请选择地址"
            });

            $(".areaBtn").click(function(){
                var area = $("#sel_city").val();
                $.ajax({
                    type: "post",
                    url: "<?php echo U('choose');?>",
                    data: 'type=area&area='+area,
                    success: function (data) {
                        if(data!='0') {
                            $(".dy-intro").html(data);
                            $("#address").css('display', 'none');
                        }
                    },
                    error: function (msg) {
                        alert('暂无相关内容');
                    }
                });
            });
        </script>
    </div>
</div>

<!--选择类型-->
<div id="type" class="weui-popup__container">
    <div class="weui-popup__overlay"></div>
    <div class="weui-popup__modal typeBox popBg" style="height: 115px" id="searcharea">
        <div class="srcBtn">
            <input id="search" class="fl" type="text"/>
            <a href="javascript:;" class="srcBtn1 weui-btn close-popup"style="background-color: #65dde6" id="ssearch">搜索</a>
        </div>

    </div>
</div>

<script type="text/javascript">
    $(".srcBtn1").click(function(){
        var words =  $("#search").val();
        $.ajax({
            type: "post",
            url: "<?php echo U('choose');?>",
            data: 'type=words&words='+words,
            success: function (data) {
                if(data!='0') {
                    $(".dy-intro").html(data);
                }
                else {
                    $(".dy-intro").html('<p style="font-size: 1rem;width:95%;text-align: center;margin: 40% auto;color:red;">暂无内容！</p>');
                }
            },
            error: function (msg) {
                alert('暂无相关内容');
            }

        });
    });
</script>


<!--<div class="weui-tabbar">-->
<!--<a href="<?php echo U('Index/index');?>" class="weui-tabbar__item n">-->
<!--&lt;!&ndash;<span class="weui-badge" style="position: absolute;top: -.4em;right: 1em;">8</span>&ndash;&gt;-->
<!--<div class="weui-tabbar__icon">-->
<!--&lt;!&ndash;<img src="./images/icon_nav_button.png" alt="">&ndash;&gt;-->
<!--</div>-->
<!--<p class="weui-tabbar__label">首页</p>-->
<!--</a>-->
<!--<a href="<?php echo U('Index/search');?>" class="weui-tabbar__item weui-bar__item&#45;&#45;on">-->
<!--<div class="weui-tabbar__icon">-->
<!--&lt;!&ndash;<img src="./images/clock.png" alt="">&ndash;&gt;-->
<!--</div>-->
<!--<p class="weui-tabbar__label">搜索</p>-->
<!--</a>-->
<!--<a href="<?php echo U('Index/order');?>" class="weui-tabbar__item">-->
<!--<div class="weui-tabbar__icon">-->
<!--&lt;!&ndash;<img src="./images/icon_nav_article.png" alt="">&ndash;&gt;-->
<!--</div>-->
<!--<p class="weui-tabbar__label">订阅</p>-->
<!--</a>-->
<!--<a href="<?php echo U('Index/lists');?>" class="weui-tabbar__item">-->
<!--<div class="weui-tabbar__icon">-->
<!--&lt;!&ndash;<img src="./images/icon_nav_cell.png" alt="">&ndash;&gt;-->
<!--</div>-->
<!--<p class="weui-tabbar__label">列表</p>-->
<!--</a>-->
<!--</div>-->
<script>
    var nameEl = document.getElementById('sel_city');

    var first = []; /* 省，直辖市 */
    var second = []; /* 市 */
    var third = []; /* 镇 */

    var selectedIndex = [0, 0, 0]; /* 默认选中的地区 */

    var checked = [0, 0, 0]; /* 已选选项 */

    function creatList(obj, list){
        obj.forEach(function(item, index, arr){
            var temp = new Object();
            temp.text = item.name;
            temp.value = index;
            list.push(temp);
        })
    }

    creatList(city, first);

    if (city[selectedIndex[0]].hasOwnProperty('sub')) {
        creatList(city[selectedIndex[0]].sub, second);
    } else {
        second = [{text: '', value: 0}];
    }

    if (city[selectedIndex[0]].sub[selectedIndex[1]].hasOwnProperty('sub')) {
        creatList(city[selectedIndex[0]].sub[selectedIndex[1]].sub, third);
    } else {
        third = [{text: '', value: 0}];
    }

    var picker = new Picker({
        data: [first, second, third],
        selectedIndex: selectedIndex,
        title: '地址选择'
    });

    picker.on('picker.select', function (selectedVal, selectedIndex) {
        var text1 = first[selectedIndex[0]].text;
        var text2 = second[selectedIndex[1]].text;
        var text3 = third[selectedIndex[2]] ? third[selectedIndex[2]].text : '';

        nameEl.text = text1 + ' ' + text2 + ' ' + text3;
    });

    picker.on('picker.change', function (index, selectedIndex) {
        if (index === 0){
            firstChange();
        } else if (index === 1) {
            secondChange();
        }

        function firstChange() {
            second = [];
            third = [];
            checked[0] = selectedIndex;
            var firstCity = city[selectedIndex];
            if (firstCity.hasOwnProperty('sub')) {
                creatList(firstCity.sub, second);

                var secondCity = city[selectedIndex].sub[0]
                if (secondCity.hasOwnProperty('sub')) {
                    creatList(secondCity.sub, third);
                } else {
                    third = [{text: '', value: 0}];
                    checked[2] = 0;
                }
            } else {
                second = [{text: '', value: 0}];
                third = [{text: '', value: 0}];
                checked[1] = 0;
                checked[2] = 0;
            }

            picker.refillColumn(1, second);
            picker.refillColumn(2, third);
            picker.scrollColumn(1, 0);
            picker.scrollColumn(2, 0);
        }

        function secondChange() {
            third = [];
            checked[1] = selectedIndex;
            var first_index = checked[0];
            if (city[first_index].sub[selectedIndex].hasOwnProperty('sub')) {
                var secondCity = city[first_index].sub[selectedIndex];
                creatList(secondCity.sub, third);
                picker.refillColumn(2, third);
                picker.scrollColumn(2, 0)
            } else {
                third = [{text: '', value: 0}];
                checked[2] = 0;
                picker.refillColumn(2, third);
                picker.scrollColumn(2, 0)
            }
        }

    });

    picker.on('picker.valuechange', function (selectedVal, selectedIndex) {
        console.log(selectedVal);
        console.log(selectedIndex);
    });

    //        nameEl.addEventListener('click', function () {
    //            picker.show();
    //        });


    $(".weui-popup__overlay").click(function(){
        $.closePopup();
    });
</script>
</body>
</html>