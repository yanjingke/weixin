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
 * 网址控制器
 * @author huajie <banhuajie@163.com>
 */
class NetsController extends AdminController
{
    public function index()
    {
        $Data =M("nets"); // 实例化Data数据对象
        import('ORG.Util.Page');// 导入分页类
        //$count      = $Data->where($map)->count();// 查询满足要求的总记录数 $map表示查询条件
        $count      = $Data->where('status = 1')->count();// 查询满足要求的总记录数
        $Page       = new Page($count,15);// 实例化分页类 传入总记录数
        // 进行分页数据查询 注意page方法的参数的前面部分是当前的页数使用 $_GET[p]获取
        $nowPage = isset($_GET['p'])?$_GET['p']:1;
        //$list = $Data->where($map)->order('create_time')->page($nowPage.','.$Page->listRows)->select();
        $list = $Data->where('status = 1')->order('id desc')->page($nowPage.','.$Page->listRows)->select();
        $show       = $Page->show();// 分页显示输出
        $this->assign('page',$show);// 赋值分页输出
        $this->assign('list',$list);// 赋值数据集
        $this -> meta_title = '所有网站';
        $this->display(); // 输出模板
    }

    public function add()
    {
        $this->display();
    }
    public function save()
    {
        $model = M('nets');
        $data = array('title'=>I('post.title'),'url'=>I('post.sub_title'),'routes'=>I('post.routes'),'addtime'=>time());
        $res = $model ->add($data);
        if($res){//添加成功
            $this->success('添加成功');
        }else{//添加失败
            $this->error('添加失败啦!');
        }
    }

    /**
     * 修改
     */
    public function edit()
    {
        $id = I('get.id');
        $exist = M('nets')->where(" id= $id ")->find();
        if($id && $exist) {
            $this->assign('res', $exist);
            $this->display(); // 输出模板
        }
        else
        {
            $this->redirect('Nets/index');
        }
    }

    /**
     * 更新
     */
    public function update()
    {
        $title = I('post.title');
        $id = I('post.id');
        if($title)
        {
            $res = M('nets')->where('id = '.$id)->save(array('title' => I('post.title')));
        }
        $url = I('post.sub_title');
        if($url)
        {
            $res = M('nets')->where('id = '.$id)->save(array('url' => I('post.sub_title')));
        }
        $this->success('修改成功','index');
    }

    /**
     * 删除
     */
    public function delete()
    {
        $id = I('post.id');
        $res = M('nets')->where('id = '.$id)->save(array('status' => 0));
        if ($res)
        {//添加成功
            echo '1';
        } else {//修改失败
            echo '0';
        }
    }
}