<?php
namespace Home\Controller;
use OT\DataDictionary;
use Think\Page;
class OrderController extends WeixinController {
	 public function index()
    {
    	 $res = M('member1');
//		$where['Wechat_code'] = 1;
//		 $res->where($where)->select();
		// $res= ;
		$v=$_GET['code'];
	
        $this->display();
    }
	
 public function order()
    {
        //$uid = $_SESSION['uid'];
           $uid ="oVlAk1FERsBqUNcq7dMeUIqg-2xE";   
           $res = M('member1')->where(" Wechat_code = '{$uid}' ")->select(); 
          $this->ajaxReturn ($res,'JSON');
              
}
	public function update(){
	 $id = $_GET['id'];
	  $keyword== $_GET['keyword'];
	  $res = M('member1');
	  $res->where('id='.$id)->data('Subject='. $keyword)->save;
	$this->display();
	}
	public function addate(){
	  $uid ="oVlAk1FERsBqUNcq7dMeUIqg-2xE";
	   $res = M();
	 $subject= $_POST['keyWords1'];
		
	  $ids= $_POST['ids'];
	 // file_put_contents(APP_PATH.'Home/Controller/log.txt',$subject[1]." 我 " .$ids[1],FILE_APPEND );
	
		//file_put_contents(APP_PATH.'Home/Controller/log.txt',$token[1]."asd" .$ids[0],FILE_APPEND );
		foreach ($subject as $key => $value) { 
		if( $ids[$key]=='a'){
			$sql='INSERT INTO  wx_member1 (Wechat_code, SUBJECT) VALUES ("'. $uid.'","'.trim($value).'")';
		$res ->execute($sql);
		 
		
		 
		}else{
	$sql2='UPDATE wx_member1 set Subject="'.trim($value).'" where Wechat_code="'. $uid .'" and id='. $ids[$key];
//		 $where['Wechat_code'] = $uid;
//		  $where['id'] = $ids[$key];
 //file_put_contents(APP_PATH.'Home/Controller/log.txt', $sql."  " ,FILE_APPEND );
	
//		 $data['Subject'] = trim($value);
		$res ->execute($sql2);
		}
		
		}  

 	 $this->ajaxReturn (true,'JSON');
		
	
	}
	 public function details()
    {
    	// $res = M('member1');
//		$where['Wechat_code'] = 1;
//		 $res->where($where)->select();
		// $res= ;
		
        $this->display();
    }
 public function orderone()
    {
    	// $res = M('member1');
//		$where['Wechat_code'] = 1;
//		 $res->where($where)->select();
		// $res= ;
		     $uid ="oVlAk1FERsBqUNcq7dMeUIqg-2xE";
		     $id = $_GET['id'];
		     $where['Wechat_code'] = $uid; 
		     $where['id'] =$id ;   
		     	$arr=array();
           $res = M('member1')->where($where)->select(); 
             foreach ($res as $k => $v) {
             		$arr2=array();
             		
             	$v[District]=unserialize($v[District]);
               	$v[type]=unserialize($v[type]);
               	 $v[Ex_subect]=unserialize($v[Ex_subect]);
               	 $arr2[District]=	$v[District];
               		$arr2[type]=	$v[type];
               		$arr2[Ex_subect]=	$v[Ex_subect];
               		//$arr2[Ex_subect]=	$v[Ex_subect];
              // file_put_contents(APP_PATH.'Home/Controller/log.txt', 	 $v[Ex_subect],FILE_APPEND );
					array_push($arr,$arr2);	
           };
      
      
          $this->ajaxReturn ($arr,'JSON');
       // $this->display();
    }
 	public function removeone()
    {
    	// $res = M('member1');
//		$where['Wechat_code'] = 1;
//		 $res->where($where)->select();
		// $res= ;
		     $uid ="oVlAk1FERsBqUNcq7dMeUIqg-2xE";
		     $id = $_POST['index'];
		     $keyword=$_POST['keyword'];
		     $where['Wechat_code'] = $uid; 
		     $where['id'] =$id ; 
		     $where['Subject']=$keyword ;
		    
           $res = M('member1')->where($where)->delete(); 
         
            $this->ajaxReturn ('ok','JSON');
         // $this->ajaxReturn ($res,'JSON');
       // $this->display();
    }
 public function area()
    {
    	// $res = M('member1');
//		$where['Wechat_code'] = 1;
//		 $res->where($where)->select();
		// $res= ;
		
        $this->display();
    }
public function infotype()
    {
    	// $res = M('member1');
//		$where['Wechat_code'] = 1;
//		 $res->where($where)->select();
		// $res= ;
		
        $this->display();
    }
public function notkey()
    {
    	// $res = M('member1');
//		$where['Wechat_code'] = 1;
//		 $res->where($where)->select();
		// $res= ;
		
        $this->display();
    }
public function updatearea()

    {
    	 	$User= M('member1');
    		 $uid ="oVlAk1FERsBqUNcq7dMeUIqg-2xE";
			 $id = $_POST['index'];
		     $area=$_POST['area'];
		      $str=serialize($area);  
		     $data['District'] =$str; 
		     $where['id'] =$id ;
		     $where['Wechat_code'] = $uid; 
		// file_put_contents(APP_PATH.'Home/Controller/log.txt',  $str,FILE_APPEND );
	
		     $User->where($where)->data($data)->save();  
	$this->ajaxReturn ("ok",'JSON');	
        //$this->display();
    }
public function findonearea()
    {
    	 	
    		 $uid ="oVlAk1FERsBqUNcq7dMeUIqg-2xE";
			 $id = $_GET['id'];
		   
				
		     $where['id'] =$id ;
		     $where['Wechat_code'] = $uid; 
			$arr=array();
		    $res= M('member1')->where($where)->Field('District')->select(); 
		        foreach ($res as $k => $v) {
             		$arr2=array();
             		
             	$v[District]=unserialize($v[District]);
             
               	 $arr2[District]=$v[District];
               	array_push($arr,$arr2);	
           };
		  
		    $this->ajaxReturn ($arr,'JSON');
		
      
    }
public function updateinfotype()
    {
    	 	 $User= M('member1');
    		 $uid ="oVlAk1FERsBqUNcq7dMeUIqg-2xE";
			 $id = $_POST['index'];
		     $infotype=$_POST['infotype'];
		      $str=serialize($infotype);  
		     $data['type'] =$str; 
		     $where['id'] =$id ;
		     $where['Wechat_code'] = $uid; 
		// file_put_contents(APP_PATH.'Home/Controller/log.txt',  $str,FILE_APPEND );
	
		     $User->where($where)->data($data)->save();  
		$this->ajaxReturn ("ok",'JSON');
        //$this->display();
    }
public function updatenotkey()
    {
    	 	 $User= M('member1');
    		 $uid ="oVlAk1FERsBqUNcq7dMeUIqg-2xE";
			 $id = $_POST['index'];
		     $notkey=$_POST['notkey'];
		      $str=serialize($notkey);  
		     $data['Ex_subect'] =$str; 
		     $where['id'] =$id ;
		     $where['Wechat_code'] = $uid; 
		// file_put_contents(APP_PATH.'Home/Controller/log.txt',  $str,FILE_APPEND );
	
		     $User->where($where)->data($data)->save();  
		$this->ajaxReturn ("ok",'JSON');
       // $this->display();
    }
public function findoneinfotype()
    {
    	 	
    		 $uid ="oVlAk1FERsBqUNcq7dMeUIqg-2xE";
			 $id = $_GET['id'];
		   
				
		     $where['id'] =$id ;
		     $where['Wechat_code'] = $uid; 
			$arr=array();
		    $res= M('member1')->where($where)->Field('type')->select(); 
		        foreach ($res as $k => $v) {
             		$arr2=array();
             		
             	$v[type]=unserialize($v[type]);
             
               	 $arr2[type]=$v[type];
               	array_push($arr,$arr2);	
           };
		  
		    $this->ajaxReturn ($arr,'JSON');
		
      
    }
public function findonenotkey()
    {
    	 	
    		 $uid ="oVlAk1FERsBqUNcq7dMeUIqg-2xE";
			 $id = $_GET['id'];
		   
				
		     $where['id'] =$id ;
		     $where['Wechat_code'] = $uid; 
			$arr=array();
		    $res= M('member1')->where($where)->Field('Ex_subect')->select(); 
		        foreach ($res as $k => $v) {
             		$arr2=array();
             		
             	$v[Ex_subect]=unserialize($v[Ex_subect]);
             
               	 $arr2[Ex_subect]=$v[Ex_subect];
               	array_push($arr,$arr2);	
           };
		  
		    $this->ajaxReturn ($arr,'JSON');
		
      
    }
 
    public function  push()
    {
        $uid ="oVlAk1FERsBqUNcq7dMeUIqg-2xE";
      //  $uid=1;
         $where['openid'] = $uid; 
        $info = M('user')->where($where)->select();
        file_put_contents(APP_PATH.'Home/Controller/log.txt', $info[0][end].$info[0][strat],FILE_APPEND);
        $this->assign('uid',$uid);
        $this->assign('info',$info);
       // 
        $this -> display();
    }

    /**
     * 推送时间设置
     */
    public function setTime()
    {
        $uid = I('post.u');
           $where['openid'] = $uid; 
        
        if (I('post.type') == '1'){//6-23点以后
            $update = M('user')->where( $where )->save(array('push'=>1,'start'=>9,'end'=>23));

	
        }elseif(I('post.type')=='2'){//9点一次
            $update = M('user')->where( $where)->save(array('push'=>2,'start'=>9,'end'=>9));
        }else{//自定义
            $push = explode(',',I('post.type'));
            $update = M('user')->where( $where )->save(array('push'=>3,'start'=>$push[0],'end'=>$push[1]));
          
        }
        echo '1';
    }
     /**
     * 列表
     */
    public  function lists()
    {
  	  $uid ="oVlAk1FERsBqUNcq7dMeUIqg-2xE";
       $where['Wechat_code'] = $uid; 
        import('ORG.Util.Page');// 导入分页类
        $tags = M('member1')->where($where)->Field('Subject,id')->select();//所有栏目
          
      
        $first = $tags[0]['Subject'];
        //   $first = "";
         // 
        $arr['title']=array('like',"%$first%");
      
     // file_put_contents(APP_PATH.'Home/Controller/log.txt',$list,FILE_APPEND );
	  	 $count=M('news')->where($arr)->count();// 查
	     $Page       = new Page($count,15);
	      $nowPage = isset($_GET['p'])?$_GET['p']:1;
	      $list=  M('news')->where($arr)->order('ptime desc')->page($nowPage.','.$Page->listRows)->Field('content',true)->select(); 
//        $Model = M();
//        $sql="SELECT * FROM  wx_news  WHERE title LIKE '%". $first."%'" ;
//        $list = $Model->query($sql);
       // $list = M('news') -> where($arr['title'])->field('id,title,url,ptime,tags,source')->select();//第一个栏目新闻
      //  file_put_contents(APP_PATH.'Home/Controller/log.txt',$list."dsdsdsa",FILE_APPEND );
	
        $this->assign('type',$tags[0]['Subject']);
        $this->assign('tags',$tags);
        $this->assign('list',$list);
//      / file_put_contents(APP_PATH.'Home/Controller/log.txt',$count,FILE_APPEND );
	  
        $this->assign('count',$count);
        $this->display();
    }
   /**
     * @return bool
     * 获取分类新闻
     */
    public function  getTypeList()
    {
      
        import('ORG.Util.Page');// 导入分页类
      	$first=$_POST['first'];
          // $first = "";
         // 
        $arr['title']=array('like',"%$first%");
      
     // file_put_contents(APP_PATH.'Home/Controller/log.txt',$list,FILE_APPEND );
	  	 $count=M('news')->where($arr)->count();// 查
	     $Page  = new Page($count,15);
	      $nowPage = isset($_GET['p'])?$_GET['p']:1;
	      $list= M('news')->where($arr)->order('ptime desc')->page($nowPage.','.$Page->listRows)->Field('content',true)->select(); 
	     
     //  $all = $Model->query($sql);
         if($list)
        {
        
            $str = ' <ul class="index-text list-ul tabslider yb-ul" >';
            foreach($list as $n)
            {	$n['ptime']=date("Y-m-d",$n['ptime']); ;
                $str .= '
				 <li class="clearfix" >
                        <div class="yb-ul-title clearfix" a="'.$n[id].'">
                            <h2 class="zq-name fL"><img src="__IMG__/gf.png">'.$n['source'].'</h2>
                            <span class="pro-name fL">'.$n['tags'].'<img src="__IMG__/important.png" class="d-v"></span></div>
                        <div class="yb-ul-inf clearfix" >
                            <a href="">'.$n[title].'</a><span class="yb-time fr" style="border-top:1px solid #f0f0f0;text-align: right;font-size: 0.48rem;margin-top: 0.32rem;">'.$n['ptime'].'</span>
                    </div>
                    </li>';
            }
            $str .= '</ul>';
         //   file_put_contents(APP_PATH.'Home/Controller/log.txt',   $str ,FILE_APPEND );
            echo $str;
        }
        else
        {
            echo '0';
        }
    }
  public function more()
    {
    	 $first=$_POST['first'];
    	 // $first="";
    	 $arr['title']=array('like',"%$first%");
    	  import('ORG.Util.Page');// 导入分页类
    	   $count=M('news')->where($arr)->count();
    	  $Page = new Page($count,15);
	      $nowPage = isset($_POST['p'])?$_POST['p']:1;
	    $list=  M('news')->where($arr)->order('ptime desc')->page($nowPage.','.$Page->listRows)->Field('content',true)->select(); 
    	
//        $model = M('news');
//        $id = I('post.id');
//        $time = $model -> where('id = '.$id )->find();
//        $list = $model ->where('ptime < '.$time['ptime'] )->order('ptime desc')->limit(20)->select();
        if($list){
            $str = '';
            foreach($list as $n)
            {
            	$n['ptime']=date("Y-m-d",$n['ptime']); ;
                $str .= '
				 <li class="clearfix" >
                        <div class="yb-ul-title clearfix" a="'.$n[id].'">
                            <h2 class="zq-name fL"><img src="__IMG__/gf.png">'.$n['source'].'</h2>
                            <span class="pro-name fL">'.$n['tags'].'<img src="__IMG__/important.png" class="d-v"></span></div>
                        <div class="yb-ul-inf clearfix" >
                            <a href="">'.$n[title].'</a><span class="yb-time fr" style="border-top:1px solid #f0f0f0;text-align: right;font-size: 0.48rem;margin-top: 0.32rem;">'.$n['ptime'].'</span>
                    </div>
                    </li>';
            }
           echo $str;
        }
         //$this->ajaxReturn ( $list,'JSON');
    }
 public function  getTypeListCount()
    {
      
        import('ORG.Util.Page');// 导入分页类
      	$first=$_POST['first'];
          // $first = "";
         // 
        $arr['title']=array('like',"%$first%");
      
      file_put_contents(APP_PATH.'Home/Controller/log.txt',$arr['title'],FILE_APPEND );
	  	 $count=M('news')->where($arr)->count();// 查
	      $this->ajaxReturn ( $count,'JSON');
        
       
    }
    

    }