<?php
namespace Admin\Controller;
use Think\Page;


class RelationController  extends AdminController
{
	var $rid=null;
 public function index()
    {
    	$relationid=$_GET['relationid'];
    	if($relationid!=null){
    		$rid=$relationid;
    	}

		$re=M();
		$sqlr="SELECT beRelationid FROM wx_relation WHERE relationid=".$rid;
		$beRelationids = $re->query($sqlr);
    	$Dao = M("news");
    
    	$sqlc=null;
    	$val="id!=".$relationid;

    	for($i=0;$i<=count($beRelationids )-1;$i++){
    		if($i!=count($beRelationids )-1){
    			$val.=" and id!=".$beRelationids[$i][beRelationid];
    		}
    		else{
    			
    			$val.=" and id!=".$beRelationids[$i][beRelationid];
    		}
    	}
//    	 foreach ($beRelationids as $k => $v) {
//    	 if($k == count($beRelationids)-1){
//   			$val.="id!=".$v[beRelationid]." and "."id!=".$relationid;
//   			
//    		 file_put_contents(APP_PATH.'Admin/Controller/log.txt',$v[beRelationid]."dsadas",FILE_APPEND );
//    	 
//    	 }else{
//    	 	$val.="id!=".$v[beRelationid]." and ";
//    	 	 file_put_contents(APP_PATH.'Admin/Controller/log.txt',$v[beRelationid]."dsadas",FILE_APPEND );
//    
//    	 }
//    	 
//    	 } 
 	
    	 	$sqlc=$sqlc.$val;
    	 	//file_put_contents(APP_PATH.'Admin/Controller/log.txt',$sqlc,FILE_APPEND );
    	
    	 	$count= $Dao->where($sqlc)->count();// 查询满足要求的总记录数
    	
   			
       import('ORG.Util.Page');// 导入分页类

        $Page       = new Page($count,15);// 实例化分页类 传入总记录数
        // 进行分页数据查询 注意page方法的参数的前面部分是当前的页数使用 $_GET[p]获取
        $nowPage = isset($_GET['p'])?$_GET['p']:1;
        //$list = $Data->where($map)->order('create_time')->page($nowPage.','.$Page->listRows)->select();
        $list = $Dao->where($val)->order('ptime desc')->page($nowPage.','.$Page->listRows)->select();
        $show       = $Page->show();// 分页显示输出
        $tags = M('tags');
        foreach($list as &$v){
            if($v['type'])
            {
                $t = $tags->where('id = '.$v['type'])->find();
                $v['typename'] = $t['name'];
            }
        }
        $this->assign('relationid',$relationid);
        $this->assign('page',$show);// 赋值分页输出
        $this->assign('counts',$count);// 赋值分页输出
        $this->assign('list',$list);// 赋值数据集
        $this -> meta_title = '所有网站';
//        $res=  urldecode(json_encode($list,JSON_UNESCAPED_UNICODE));
//        $this->ajaxReturn ($res,'JSON');
       $this->display(); // 输出模板
    }
    public function sendrelation()
    {
    	  $id = I('get.id');
    	  $relationid= I('get.relationid');
    	// file_put_contents(APP_PATH.'Admin/Controller/log.txt', $id. $relationid,FILE_APPEND );
    	  $data[relationid]=$relationid;
    	  $data[beRelationid]=$id;
    	  
    	   $Dao = M("relation");
    	  $val=$Dao->where($data)->select();
    	  if($val==null){
    	   $Dao->add($data);
    	  $data[relationid]=$id;
    	  $data[beRelationid]=$relationid;
    	  $Dao->add($data);
    	  
    	 echo 'ok';
    	  }
    	  else{
    	 echo 'error';
    	  }
    	  
    }
 public function selectrelation()
    {
    	$id = I('get.relationid');
    	//file_put_contents(APP_PATH.'Admin/Controller/log.txt',$id,FILE_APPEND );
    	
    	$sql="SELECT  beRelationid FROM wx_relation   WHERE relationid=".$id;
    	//file_put_contents(APP_PATH.'Admin/Controller/log.txt',$sql,FILE_APPEND );
    	$Dao = M();
    	$list=$Dao->query($sql);
    	for($i=0;$i<=count($list)-1;$i++){
    		if($i!=count($list )-1){
    			$val.=" id=".$list[$i][beRelationid]." or ";
    		}
    		else{
    			
    			$val.=" id=".$list[$i][beRelationid];
    		}
    	}
	//file_put_contents(APP_PATH.'Admin/Controller/log.txt',$val."asddas",FILE_APPEND );
	$list=null;
	if($val!=null){
    	 $Dao = M("news");
    	  $list=$Dao->where($val)->Field('title,id')->select();
	}
	
    	  $list= json_encode($list,JSON_UNESCAPED_UNICODE);
    	  // echo $list;
    	$this->ajaxReturn ($list,'JSON');
    	  
    }
  public function cleanrelation()
    {
    	  $id = I('get.id');
    	  $relationid= I('get.relationid');
    	// file_put_contents(APP_PATH.'Admin/Controller/log.txt', $id. $relationid,FILE_APPEND );
    		$sql="DELETE FROM wx_relation WHERE relationid=". $relationid ." and "."beRelationid=".$id;
    	   $Dao = M();
    	   $Dao->execute($sql);
    	$sql="DELETE FROM wx_relation WHERE relationid=". $id ." and "."beRelationid=".$relationid;
    	
    	  $Dao->execute($sql);
    	 echo 'ok';
    	  
    }
     public function sendMorerelation()
    {
    	  $ids = I('post.data');
    	  $relationid= I('post.relationid');
    	    $Dao = M("relation");
    	    foreach ($ids as $k1 => $v1) {
    	   $data[relationid]=$relationid;
    		$data[beRelationid]=$v1;
    		 $Dao->add($data);
    		 $data[relationid]=$v1;
    		$data[beRelationid]=$relationid;
    		 $Dao->add($data);
    	    }
    	 echo 'ok';
    	  
    }
    

    public function isdelete()
    {
        $Data =M("news"); // 实例化Data数据对象
        import('ORG.Util.Page');// 导入分页类
        //$count      = $Data->where($map)->count();// 查询满足要求的总记录数 $map表示查询条件
        $count      = $Data->where('status = 0')->count();// 查询满足要求的总记录数
        $Page       = new Page($count,15);// 实例化分页类 传入总记录数
        // 进行分页数据查询 注意page方法的参数的前面部分是当前的页数使用 $_GET[p]获取
        $nowPage = isset($_GET['p'])?$_GET['p']:1;
        //$list = $Data->where($map)->order('create_time')->page($nowPage.','.$Page->listRows)->select();
        $list = $Data->where('status = 0')->order('id desc')->page($nowPage.','.$Page->listRows)->select();
        $show       = $Page->show();// 分页显示输出
        $tags = M('tags');
        foreach($list as &$v){
            if($v['type'])
            {
                $t = $tags->where('id = '.$v['type'])->find();
                $v['typename'] = $t['name'];
            }
        }
        $this->assign('page',$show);// 赋值分页输出
        $this->assign('list',$list);// 赋值数据集
        $this -> meta_title = '回收站';
        $this->display(); // 输出模板
    }

    /**
     * 编辑
     */
    public function edit()
    {
        $id = I("get.id");
        if($id){
            $arr = M("News") -> where("id = $id") -> find();
            $this -> assign('arr',$arr);
        }
        $tags = M('tags')->where('status = 1')->select();
        $this->assign('tags',$tags);
        $this->display();
    }

    /**
     * 更新
     */
    public function update()
    {
        $title = I('post.title');
        $id = I('post.id');
        $data = array('type' => I('post.type'), 'title' => $title, 'content' => I('post.content'));
        $res = M('News')->where('id = ' . $id)->save($data);
        if ($res)
        {//添加成功
            $this->success('修改成功');
            $this->redirect('News/index');
        } else {//修改失败
            $this->error('修改失败!');
        }
    }

    /**\
     * 添加
     */
    public function add()
    {
        $tags = M('tags')->select();
        $this->assign('tags',$tags);
        $this->display();
    }

    /**
     * 保存
     */
    public  function save()
    {
        $data['title'] = I('post.title');
        $data['content'] = I('post.content');
        $data['addtime'] = time();
        if($data['title'] && $data['content']) {
            $insert =  M('news')->add($data);
            if($insert)
            {
                $this->success('修改成功');
                $this->redirect('News/index');
            }
            else
            {
                $this->error('添加失败!');
            }
        }
        else
        {
            $this->error('添加失败!');
        }
    }

    /**
     * 删除新闻
     */
    public function del()
    {
        $id = I('post.id');
        $update = M('news')->where('id = ' . $id)->save(array('status' => 0));
        if($update) {
            echo '1';
        }
        else
        {
            echo '0';
        }
    }

    public function dels()
    {
        $id = I('post.id');
        $update = M('news')->where('id = ' . $id)->delete();
        if($update) {
            echo '1';
        }
        else
        {
            echo '0';
        }
    }

    public function restore()
    {
        $id = I('post.id');
        $update = M('news')->where('id = ' . $id)->save(array('status' => 1));
        if($update) {
            echo '1';
        }
        else
        {
            echo '0';
        }
    }
	
	
	
	
	
}