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
class WeChatController extends AdminController
{
   ///*******************微信配置****************************////
    public function index(){
        $Data =M("menus"); // 实例化Data数据对象
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
        foreach($list as &$v)
        {
            $g = M('menus')->where('id = '.$v['pid']) ->find();
            if($g) {
                $v['g_name'] = $g['name'];
                }
        }
        $this->assign('list',$list);// 赋值数据集
        $this -> meta_title = '所有菜单';
        $this->display(); // 输出模板
    }

    public function  addMenu()
    {
        $group = M('menus')->where('pid = 0 ')->select();
        $this->assign('group',$group);
        $this->display();
    }

    /**
     * 保存菜单
     */
    public function saveMenu()
    {
        $model = M('menus');
        if(I('post.group')) {
            $group = $model->where('id = ' . I('post.group'))->find();
            $g = $group['id'];
            $p=1;
        }
        else{
            $g = 0;
            $p = 0;
        }
        $data = array('name'=>I('post.name'),'group'=>$g,'addtime'=>time(),'o'=>I('post.order'),'url'=>I('post.url'),'pid'=>$p);
        $res = $model ->add($data);
        if($res){//添加成功
            $this->success('添加成功','index');
        }else{//添加失败
            $this->error('添加失败啦!');
        }
    }
    /**
     * 修改
     */
    public function editMenu()
    {
        $group = M('menus')->where('pid = 0 ')->select();
        $this->assign('group',$group);
        $id = I('get.id');
        $exist = M('menus')->where(" id= $id ")->find();
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
    public function updateMenu()
    {
        $id = I('post.id');
        $model = M('menus');
        if(I('post.group')) {
            $group = $model->where('id = ' . I('post.group'))->find();
            $g = $group['id'];
            $p=1;
        }
        else{
            $g = '';
            $p = 0;
        }
        $data = array('name'=>I('post.name'),'group'=>$g,'addtime'=>time(),'o'=>I('post.order'),'url'=>I('post.url'),'pid'=>$p);
        $res = M('menus')->where('id = '.$id)->save($data);
        if ($res)
        {//添加成功
            $this->success('修改成功','index');
        } else {//修改失败
            $this->error('修改失败!');
        }
    }

    /*******公众号管理********/

    public function manager()
    {

        $this->display(); // 输出模板
    }
    /******消息模板******/

    public function  message()
    {
        $Data =M("message"); // 实例化Data数据对象
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
        $this -> meta_title = '所有菜单';
        $this->display(); // 输出模板
    }

    public function addMsg()
    {
        $this -> display();
    }

    public function  msgsave()
    {
        $res = M('message')->add(array('title'=>I('post.title'),'content'=>I('post.content')));
        if ($res)
        {//添加成功
            $this->success('添加成功','index');
        } else {//修改失败
            $this->error('添加失败!');
        }
    }

    /**
     * 修改
     */
    public function editMsg()
    {

        $id = I('get.id');
        $exist = M('message')->where(" id= $id ")->find();
        if($exist) {
            $this->assign('res', $exist);
            $this->display(); // 输出模板
        }
        else
        {
            $this->redirect('Nets/index');
        }
    }

    /**
     * 模板更新
     */
    public function msgUpdate()
    {
        $id = I('post.id');
        $data = array('title' => I('post.title'),'content'=>I('post.content'));
        $res = M('message')->where('id = '.$id)->save($data);
        if($res)
        {//添加成功
            $this->success('修改成功');
            $this->redirect('Wechat/message');
        } else {//修改失败
            $this->error('修改失败!');
        }
    }

    /**
     * 删除菜单
     */
    public function delmenu()
    {
        $id = I('post.id');
        $res = M('menus')->where('id ='.$id )->save(array('status'=>0,'update'=>time()));
        if($res)
        {
            echo '1';
        }
        else
        {
            echo '0';
        }
    }
    /**
     * 删除消息模板
     */
    public function delmsg()
    {
        $id = I('post.id');
        $res = M('message')->where('id ='.$id )->save(array('status'=>0,'update'=>time()));
        if($res)
        {
            echo '1';
        }
        else
        {
            echo '0';
        }
    }
}