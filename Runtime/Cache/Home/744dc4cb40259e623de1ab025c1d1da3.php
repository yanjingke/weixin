<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="referrer" content="no-referrer" />
    <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />
    <title>详情</title>
</head>
<body>
<style type="text/css">
    .content{
        margin:1rem;
    }
    .content-content{
        font-size: 0.6rem;
    }
    .content-content img{
        width:100%;
        height:200px;
    }
</style>
<div class="content">
        <div style="text-align: center">
                <p><?php echo ($res["title"]); ?></p>
        </div>
        <div>
            <span style="font-size: 0.8rem;margin-left: 5%;color:darkred"><?php echo ($res["source"]); ?></span>
            <span style="margin-left: 40%;font-size: 0.8rem;color:darkred" ><?=date('Y-m-d',$res['ptime'])?></span>
        </div>
    <hr>
    <div class="content-content">
        <?php echo ($res["content"]); ?>
    </div>
    <div>
        <span style="font-size: 0.8rem">标签：
            <?php if(($tags) != "null"): echo ($res["tags"]); endif; ?>
        </span>
        <hr>
        <a href="<?php echo ($res["url"]); ?>" style="margin-left: 1%;text-decoration: none;font-size: 0.8rem;color:black;font-weight: bold;">查看原文</a>
        <hr>
    </div>
    <div>
        <a href="<?php echo U('Index/detail?id='.$res['pre']);?>" style="margin-left:5%;text-decoration: none;color:black;">上一页</a>
        <a href="<?php echo U('Index/detail?id='.$res['next']);?>" style="margin-left:40%;text-decoration: none;color:black;">下一页</a>
    </div>
</div>
</body>
</html>