<?php
namespace Admin\Controller;
use Think\Page;


class PushHistoryController extends AdminController{
	//单图文
	   public function queryall(){
	 	
//	   	$Model = new \Think\Model();
//	  	$res=$Model->query("SELECT b.content,a.id,b.uid,b.time,b.juimage FROM wx_history AS b,wx_sehistory AS a WHERE a.uid=b.uid ");
//	  	 	
     	//$res=  json_encode($res,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
      // $res1=json_decode($res,JSON_UNESCAPED_UNICODE);
      // var_export($res);
      
		$res = M('historyj')->select();
		  // $res =unserialize($res);
		  $res=str_replace("\\", "",  urldecode(json_encode($res,JSON_UNESCAPED_UNICODE)));
	      $res=str_replace("\";\"", "",$res);
		  $res=preg_replace("/\"s:([0-9]+):\"/", "",$res);
	     // $res=preg_replace("\s","",$res);
		 //  $arr = urldecode(json_decode($res,true));
		    //$res=  json_encode($res,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
     	 $this->ajaxReturn ($res,'JSON');
     	// echo  $res ;
     	//echo($res);
	   }
 
	   
	  public function index()
    {
         $this->display(); // 输出模板
    }
	   
}