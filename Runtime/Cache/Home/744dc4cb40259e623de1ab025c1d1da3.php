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
    body {
   
    font-size: 11px;
    font-family: 'Open Sans', sans-serif;
    color: #4A4A4A ;
    text-align: center; 
}

.box1{
    width: 300px;
    margin: 20px;
    padding: 10px;
    min-height: 200px;
    position:relative;
    display: inline-block;
    background: -webkit-gradient(linear, 0% 20%, 0% 1000%, from(#fff), to(#fff), color-stop(.1,#f3f3f3));
    border: 1px solid #ccc;
    -webkit-box-shadow: 0px 3px 30px rgba(0, 0, 0, 0.1) inset;
    -webkit-border-bottom-right-radius: 6px 50px;    
}

.box1:before{
    content: '';
    width: 50px;
    height: 100px;
    position:absolute;
    bottom:0; right:0;
    -webkit-box-shadow: 20px 20px 10px rgba(0, 0, 0, 0.1);
    z-index:-1;
    -webkit-transform: translate(-35px,-40px)
                        skew(0deg,30deg)
                        rotate(-25deg);
}

.box1:after{
    content: '';
    width: 100px;
    height: 100px;
    top:0; left:0;
    position:absolute;
    display: inline-block;
    z-index:-1;
    -webkit-box-shadow: -10px -10px 10px rgba(0, 0, 0, 0.2);
    -webkit-transform: rotate(2deg)
                        translate(20px,25px)
                        skew(20deg);
}

.box1 img {
    width: 100%;
    margin-top: 15px;
}

p{ 
    margin-top: 15px;
    text-align: justify;
}

h1{
    font-size: 20px;
    font-weight: bold;
    margin-top: 5px; 
    text-shadow: 1px 1px 3px rgba(0,0,0,0.3);
}

a{
    text-decoration: none;
    color: #4A4A4A !important;
}

a:hover{
    text-decoration: underline;
    color: #6B6B6B !important ;
}

a:hover{
    text-decoration: underline;
    color: #6B6B6B !important ;
}
.content{
        margin:1rem;
    }
    .content-content{
        font-size: 0.7rem;
    }
    .content-content img{
        width:100%;
        height:200px;
        margin-left:-2em ;
    }
  
    .content{
    	text-indent:0em;
    }
</style>
 <script src="js/bootstrap.min.js"></script>
    <script src="http://code.jquery.com/jquery-latest.js"></script>
     <script type="text/javascript">
     $(function () {
    	 var parr = $("p")
    		for(var i = 0;i<parr.length;i++){
    			var str="";
    			if(parr[i].children($("img"))){
    				str = "<div class="+"'content-content'"+">"
    				parr.prepend(str);
    				parr.append("</div>")
    			}         
    		}
    	         
    	 var id=<?php echo ($_GET['id']); ?>;
    	 var html="";
    	 var url= "<?php echo U('Admin/Relation/selectrelation','','');?>/relationid/"+id+".html";
    	 $.ajax({
			 url:url,
			 type: "get", 
			
			 success: function(data){
			 
    		 var arr = JSON.parse(data);
    		 for(var i=0;i<arr.length;i++){
    	    		var url="<?php echo U('Home/Index/detail','','');?>/id/"+arr[i].id+".html";;
    	    		html+="<li><a href="+"'"+url+"'"+" style="+"'"+"margin-left: 1%;text-decoration: none;font-size: 0.8rem;color:black;font-weight: bold;"+"'"+">"+arr[i].title+"</a>"
    	    	}
    		 $("ul").append(html);
    		// alert(html);
    	    }
 		    	

    		 

    	 	
    	 })
     })
	</script>
<div id="div1" class="box1">
	<div class="content">
	        <div style="text-align: center">
	        	<div style="text-align: center;background-color: rgb(190,62,24);color: rgb(255,255,255);">
                	<h3 style="padding: 10px;"><?php echo ($res["title"]); ?></h3>
        		</div>
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
	    	<div>
	    		<span style="font-size: 0.8rem">标签：
	            	<?php if(($tags) != "null"): echo ($res["tags"]); endif; ?>
	        	</span>
	    	</div>
	        <div>
	        	<span style="font-size: 0.8rem">相关新闻：</span>
	        	<hr>
		        	<ul>
	       			
	       		</ul>
	       		<hr>
	        </div>
	       <div>
	       	 	<a href="<?php echo ($res["url"]); ?>" style="margin-left: 1%;text-decoration: none;font-size: 0.8rem;color:black;font-weight: bold;">查看原文</a>
	        	<hr>
	       </div>
	       
	    </div>
	    <div>
	        <a href="<?php echo U('Index/detail?id='.$res['pre']);?>" style="margin-left:5%;text-decoration: none;color:black;">上一页</a>
	        <a href="<?php echo U('Index/detail?id='.$res['next']);?>" style="margin-left:40%;text-decoration: none;color:black;">下一页</a>
	    </div>
	</div>
	
</div>
</body>
</html>