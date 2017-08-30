<?php

namespace Home\Controller;
use OT\DataDictionary;
use Think\Page;
class SearchController extends WeixinController{
	public function searchContext(){
		$Data =M("news");
		$Data1 =M(); // 实例化Data数据对象
    	import('ORG.Util.Page');
       $count =  $Data1->query("SELECT COUNT(*) count FROM wx_news WHERE  title like '%成都市%'");
      //  file_put_contents(APP_PATH.'Home/Controller/log.txt', $count."fddddg",FILE_APPEND );
    	
      	 $count=$count[0][count];	
		//file_put_contents(APP_PATH.'Home/Controller/log.txt', $count ,FILE_APPEND );
    		
	
		
		$where['title'] = array('like','%成都市%');
		
        $Page = new Page($count,15);// 实例化分页类 传入总记录数
         // 进行分页数据查询 注意page方法的参数的前面部分是当前的页数使用 $_GET[p]获取
        $nowPage = isset($_GET['p'])?$_GET['p']:1;
       $titleall = $Data->where($where)->order('ptime desc')->page($nowPage.','.$Page->listRows)->Field('title')->select();
	 	$this->ajaxReturn ($titleall,'JSON');
	}
}