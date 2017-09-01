<?php
namespace Home\Controller;
use OT\DataDictionary;

class OrderController extends WeixinController {
	 public function index()
    {
      
        $this->display();
    }
	
 public function order()
    {
        //$uid = $_SESSION['uid'];
           $uid ="oVlAk1FERsBqUNcq7dMeUIqg-2xE";   
           $res = M('member1')->where(" Wechat_code = '{$uid}' ")->select(); 
          $this->ajaxReturn ($res,'JSON');
          
               
     
}
    }