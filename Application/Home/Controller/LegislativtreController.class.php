<?php
namespace Home\Controller;
use Think\Page;
class LegislativtreController extends WeixinController {
	 public function index()
    {
        
        $this->display(); // 输出模板
    }
    //动态
    public function  dynamic(){
    	$Data =M("news"); // 实例化Data数据对象
        import('ORG.Util.Page');// 导入分页类
        //$count      = $Data->where($map)->count();// 查询满足要求的总记录数 $map表示查询条件
        $count      = $Data->where("tags = '动态'")->count();// 查询满足要求的总记录数
        $Page       = new Page($count,15);// 实例化分页类 传入总记录数
        // 进行分页数据查询 注意page方法的参数的前面部分是当前的页数使用 $_GET[p]获取
        $nowPage = isset($_GET['p'])?$_GET['p']:1;
        //$list = $Data->where($map)->order('create_time')->page($nowPage.','.$Page->listRows)->select();
        $list = $Data->where("tags = '动态'")->order('ptime desc')->page($nowPage.','.$Page->listRows)->Field('addtime','title','img_url','id','ptime','clean_content')->select();
      
        
        $show       = $Page->show();// 分页显示输出
        $tags = M('tags');
        foreach($list as &$v){
        	//
        	//$v['clean_content']=strpos($v['clean_content'],0,50);
        	if($v['img_url']!=null && trim($v['img_url'])!='[]'){
        		$pic = $v['img_url'];
        	$pic=str_replace('[','',$pic);
			$pic=str_replace(']','',$pic);
			$pic=str_replace('u','',$pic);
			$pic=str_replace('\'','',$pic);
			
			$pic=  substr($pic,0,strpos($pic, ','));
			
			$v['img_url']=$pic;
			
			
        	}
        	else{
      		$v['img_url']="http://gqianniu.alicdn.com/bao/uploaded/i4//tfscom/i3/TB10LfcHFXXXXXKXpXXXXXXXXXX_!!0-item_pic.jpg_250x250q60.jpg";
        	}
        	$date=date('Y年m月d',$v['ptime']);
        	$date2=date('Y年m月d',$v['addtime']);
        	if($date==false){
        		$v['ptime']='';
   			   // file_put_contents(APP_PATH.'Home/Controller/log.txt',$v['ptime'].'sadas',FILE_APPEND );
    		
        	}
        	if($date2==false){
        		$v['addtime']='adsda';
        		//file_put_contents(APP_PATH.'Admin/Controller/log.txt',$v['ptime'].'sadas',FILE_APPEND );
    		
        	}
        	else{
        	$v['ptime']=$date;
        	$v['addtime']=$date2;
        	}
        	
        	 
            if($v['type'])
            {
                $t = $tags->where('id = '.$v['type'])->find();
                $v['typename'] = $t['name'];
               
            }
        }
     
        $this->ajaxReturn ($list,'JSON');
    }
 public function  count(){
    	$Data =M(); // 实例化Data数据对象
    	
          //$count      = $Data->where($map)->count();// 查询满足要求的总记录数 $map表示查询条件
         $count =  $Data->query("SELECT COUNT(*) dynmicount FROM wx_news WHERE tags='动态'");
      	  $count1 =  $Data->query("SELECT COUNT(*)  plancount FROM wx_news WHERE tags='计划'");
      	  $count2 =  $Data->query("SELECT COUNT(*) standcount FROM wx_news WHERE tags='审立'");
      	$count3=  $Data->query("SELECT COUNT(*) noticecount FROM wx_news WHERE tags='公告'");
      	$count[0]['plancount']=$count1[0]['plancount'];
      	$count[0]['standcount']=$count2[0]['standcount'];
      	$count[0]['noticecount']=$count3[0]['	'];
        $this->ajaxReturn ($count ,'JSON');
    }
  //计划
    public function  planList(){
    	$Data =M("news"); // 实例化Data数据对象
        import('ORG.Util.Page');// 导入分页类
        //$count      = $Data->where($map)->count();// 查询满足要求的总记录数 $map表示查询条件
        $count      = $Data->where("tags = '计划'")->count();// 查询满足要求的总记录数
        $Page       = new Page($count,15);// 实例化分页类 传入总记录数
        // 进行分页数据查询 注意page方法的参数的前面部分是当前的页数使用 $_GET[p]获取
        $nowPage = isset($_GET['p'])?$_GET['p']:1;
        //$list = $Data->where($map)->order('create_time')->page($nowPage.','.$Page->listRows)->select();
        $list = $Data->where("tags = '计划'")->order('ptime desc')->page($nowPage.','.$Page->listRows)->Field('addtime','title','img_url','id','ptime','clean_content')->select();
      
        
        $show       = $Page->show();// 分页显示输出
        $tags = M('tags');
      foreach($list as &$v){
        	//
        	//$v['clean_content']=strpos($v['clean_content'],0,50);
        	if($v['img_url']!=null && trim($v['img_url'])!='[]'){
        		$pic = $v['img_url'];
        	$pic=str_replace('[','',$pic);
			$pic=str_replace(']','',$pic);
			$pic=str_replace('u','',$pic);
			$pic=str_replace('\'','',$pic);
			
			$pic=  substr($pic,0,strpos($pic, ','));
			
			$v['img_url']=$pic;
			
			
        	}
     		else{
      		$v['img_url']="http://gqianniu.alicdn.com/bao/uploaded/i4//tfscom/i3/TB10LfcHFXXXXXKXpXXXXXXXXXX_!!0-item_pic.jpg_250x250q60.jpg";
        	}
        	$date=date('Y年m月d',$v['ptime']);
        	$date2=date('Y年m月d',$v['addtime']);
        	if($date==false){
        		$v['ptime']='';
   			   // file_put_contents(APP_PATH.'Home/Controller/log.txt',$v['ptime'].'sadas',FILE_APPEND );
    		
        	}
        	if($date2==false){
        		$v['addtime']='adsda';
        		//file_put_contents(APP_PATH.'Admin/Controller/log.txt',$v['ptime'].'sadas',FILE_APPEND );
    		
        	}
        	else{
        	$v['ptime']=$date;
        	$v['addtime']=$date2;
        	}
        	
        	 
            if($v['type'])
            {
                $t = $tags->where('id = '.$v['type'])->find();
                $v['typename'] = $t['name'];
               
            }
        }
     
        $this->ajaxReturn ($list,'JSON');
    }	
    //公示
    public function  publicityList(){
    	$Data =M("news"); // 实例化Data数据对象
        import('ORG.Util.Page');// 导入分页类
        //$count      = $Data->where($map)->count();// 查询满足要求的总记录数 $map表示查询条件
        $count      = $Data->where("tags = '公示'")->count();// 查询满足要求的总记录数
        $Page       = new Page($count,15);// 实例化分页类 传入总记录数
        // 进行分页数据查询 注意page方法的参数的前面部分是当前的页数使用 $_GET[p]获取
        $nowPage = isset($_GET['p'])?$_GET['p']:1;
        //$list = $Data->where($map)->order('create_time')->page($nowPage.','.$Page->listRows)->select();
        $list = $Data->where("tags = '公示'")->order('ptime desc')->page($nowPage.','.$Page->listRows)->Field('addtime','title','img_url','id','ptime','clean_content')->select();
      
        
        $show       = $Page->show();// 分页显示输出
        $tags = M('tags');
      foreach($list as &$v){
        	//
        	//$v['clean_content']=strpos($v['clean_content'],0,50);
        	if($v['img_url']!=null && trim($v['img_url'])!='[]'){
        		$pic = $v['img_url'];
        	$pic=str_replace('[','',$pic);
			$pic=str_replace(']','',$pic);
			$pic=str_replace('u','',$pic);
			$pic=str_replace('\'','',$pic);
			
			$pic=  substr($pic,0,strpos($pic, ','));
			
			$v['img_url']=$pic;
			
			
        	}
     		 else{
      		$v['img_url']="http://gqianniu.alicdn.com/bao/uploaded/i4//tfscom/i3/TB10LfcHFXXXXXKXpXXXXXXXXXX_!!0-item_pic.jpg_250x250q60.jpg";
        	}
        	$date=date('Y年m月d',$v['ptime']);
        	$date2=date('Y年m月d',$v['addtime']);
        	if($date==false){
        		$v['ptime']='';
   			   // file_put_contents(APP_PATH.'Home/Controller/log.txt',$v['ptime'].'sadas',FILE_APPEND );
    		
        	}
        	if($date2==false){
        		$v['addtime']='adsda';
        		//file_put_contents(APP_PATH.'Admin/Controller/log.txt',$v['ptime'].'sadas',FILE_APPEND );
    		
        	}
        	else{
        	$v['ptime']=$date;
        	$v['addtime']=$date2;
        	}
        	
        	 
            if($v['type'])
            {
                $t = $tags->where('id = '.$v['type'])->find();
                $v['typename'] = $t['name'];
               
            }
        }
        $this->ajaxReturn ($list,'JSON');
    }	
	//新法
    public function  newlawList(){
    	$Data =M("news"); // 实例化Data数据对象
        import('ORG.Util.Page');// 导入分页类
        //$count      = $Data->where($map)->count();// 查询满足要求的总记录数 $map表示查询条件
        $count      = $Data->where("tags = '新法'")->count();// 查询满足要求的总记录数
        $Page       = new Page($count,15);// 实例化分页类 传入总记录数
        // 进行分页数据查询 注意page方法的参数的前面部分是当前的页数使用 $_GET[p]获取
        $nowPage = isset($_GET['p'])?$_GET['p']:1;
        //$list = $Data->where($map)->order('create_time')->page($nowPage.','.$Page->listRows)->select();
        $list = $Data->where("tags = '新法'")->order('ptime desc')->page($nowPage.','.$Page->listRows)->Field('addtime','title','img_url','id','ptime','clean_content')->select();
      
        
        $show       = $Page->show();// 分页显示输出
        $tags = M('tags');
      foreach($list as &$v){
        	//
        	//$v['clean_content']=strpos($v['clean_content'],0,50);
        	if($v['img_url']!=null && trim($v['img_url'])!='[]'){
        		$pic = $v['img_url'];
        	$pic=str_replace('[','',$pic);
			$pic=str_replace(']','',$pic);
			$pic=str_replace('u','',$pic);
			$pic=str_replace('\'','',$pic);
			
			$pic=  substr($pic,0,strpos($pic, ','));
			
			$v['img_url']=$pic;
			
			
        	}
      else{
      		$v['img_url']="http://gqianniu.alicdn.com/bao/uploaded/i4//tfscom/i3/TB10LfcHFXXXXXKXpXXXXXXXXXX_!!0-item_pic.jpg_250x250q60.jpg";
        	}
        	$date=date('Y年m月d',$v['ptime']);
        	$date2=date('Y年m月d',$v['addtime']);
        	if($date==false){
        		$v['ptime']='';
   			   // file_put_contents(APP_PATH.'Home/Controller/log.txt',$v['ptime'].'sadas',FILE_APPEND );
    		
        	}
        	if($date2==false){
        		$v['addtime']='adsda';
        		
        	}
        	else{
        	$v['ptime']=$date;
        	$v['addtime']=$date2;
        	}
        	file_put_contents(APP_PATH.'Home/Controller/log.txt',$v['ptime'].'sadas',FILE_APPEND );
    		
        	 
            if($v['type'])
            {
                $t = $tags->where('id = '.$v['type'])->find();
                $v['typename'] = $t['name'];
               
            }
        }
     
        $this->ajaxReturn ($list,'JSON');
    }	

}