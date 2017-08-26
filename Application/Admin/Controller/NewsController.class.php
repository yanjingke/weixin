<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: huajie <banhuajie@163.com>
// +----------------------------------------------------------------------

namespace Admin\Controller;
use Think\Page;
/**
 * 信息控制器
 * @author huajie <banhuajie@163.com>
 */
class NewsController extends AdminController
{
    public function index()
    {
        $Data =M("news"); // 实例化Data数据对象
        import('ORG.Util.Page');// 导入分页类
        //$count      = $Data->where($map)->count();// 查询满足要求的总记录数 $map表示查询条件
        $count      = $Data->where('status = 1')->count();// 查询满足要求的总记录数
        $Page       = new Page($count,15);// 实例化分页类 传入总记录数
        // 进行分页数据查询 注意page方法的参数的前面部分是当前的页数使用 $_GET[p]获取
        $nowPage = isset($_GET['p'])?$_GET['p']:1;
        //$list = $Data->where($map)->order('create_time')->page($nowPage.','.$Page->listRows)->select();
        $list = $Data->where('status = 1')->order('ptime desc')->page($nowPage.','.$Page->listRows)->select();
      
        
        $show       = $Page->show();// 分页显示输出
        $tags = M('tags');
        foreach($list as &$v){
        	file_put_contents(APP_PATH.'Admin/Controller/log.txt','-2-'.$v['ptime'],FILE_APPEND );//log
        
            if($v['type'])
            {
                $t = $tags->where('id = '.$v['type'])->find();
                $v['typename'] = $t['name'];
               
            }
        }
        $this->assign('page',$show);// 赋值分页输出
        $this->assign('counts',$count);// 赋值分页输出
        $this->assign('list',$list);// 赋值数据集
        $this -> meta_title = '所有网站';
        $this->display(); // 输出模板
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
         $update = M('relation')->where('relationid  = ' . $id)->delete();
          $update = M('relation')->where('beRelationid= ' . $id)->delete();
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