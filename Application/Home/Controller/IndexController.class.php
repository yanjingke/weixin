<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Home\Controller;
use OT\DataDictionary;

/**
 * 前台首页控制器
 * 主要获取首页聚合数据
 */
class IndexController extends WeixinController {
    /**
     * 首页
     */
    public function index()
    {
        $uid = $_GET['uid'];
        $_SESSION['uid'] = $uid;
        $news = $this->getLatestNews();
        $this->assign('news',$news);
        $this->display();
    }

    /**
     * @return mixed
     * 获取最近新闻
     * 获取最近新闻
     */
    public function getLatestNews()
    {
        $news = M('news')->where('status=1')->order('ptime desc')->limit(20)->select();
        return $news;
    }

    /**
     * 搜索
     */
    public function  search()
    {
        $type = M('tags')->where('status = 1')->select();
        $area = M('area')->select();
        $this->assign('type',$type);
        $this->assign('area',$area);
        $this->display();
    }

    /**
     * 列表
     */
    public  function lists()
    {
        $tags = M('tags')->where('status = 1')->select();//所有栏目
        $first = $tags[0]['id'];
        $list = M('News') -> where(" type = $first ")->field('id,title,url,ptime,tags,source')->select();//第一个栏目新闻
        $this->assign('type',$tags[0]['name']);
        $this->assign('tags',$tags);
        $this->assign('list',$list);
        $this->display();
    }

    /**
     * 订阅页面
     */
    public function order()
    {
        $uid = $_SESSION['uid'];
        $model = M('tags');
        $res = $model -> select();
        foreach($res as &$v)
        {
            $exist = M('user_tags')->where("uid = $uid and tag_id =  ".$v['id'] )->find();
            if($exist)
            {
                $v['is_order'] = '1';
            }
            else
            {
                $v['is_order'] = '0';
            }
        }
        /*用户订阅*/
        $order = M('user_tags')->where('uid = '.$uid)->select();
        if($order) {
            foreach ($order as $k => &$o) {
                if ($o['tag_id']) {
                    $name = $model->where('id = ' . $o['tag_id'])->find();
                    if ($name) {
                        $o['tag_name'] = $name['name'];
                    } else {
                        unset($order[$k]);
                    }
                }
            }
        }
        $this->assign('order',$order);
        $this->assign('uid',$uid);
        $this->assign('list',$res);//所有栏目
        $this->assign('uid',$uid);//所有栏目
        $this->display();
    }

    /**
     * @return bool
     * 获取分类新闻
     */
    public function  getTypeList()
    {
        $id = I('post.i');
        $all = M('news')->field('id,title,url,source,ptime,tags')->where('type = '.$id )->select();
        if($all)
        {
            $str = '<ul class="tabslider yb-ul" style="padding:0 0.5rem;">';
            foreach($all as $v)
            {
                $str .=
                    ' <a href="'.U("Index/detail?id=".$v['id']).'">
                        <li class="clearfix" >
                            <div class="yb-ul-title clearfix">
                                <h2 class="zq-name fL"><img src="http://test.fixstyle.cn/Public/Home/images/gf.png">'.$v['source'].'</h2>
                                <span class="pro-name fL">'.$v['tags'].'<img src="http://test.fixstyle.cn/Public/Home/images/important.png" class="d-v"></span>
                            </div>
                            <div class="yb-ul-inf clearfix" style="border-top:1px solid #f0f0f0;">
                                <a href="'.U("Index/detail?id=".$v['id']).'">'.$v['title'].'</a><span class="yb-time">'.date('Y-m-d',$v['ptime']).'</span>
                            </div>
                        </li>
                    </a>
                    ';
            }
            $str .= '</ul>';
            echo $str;
        }
        else
        {
            echo '0';
        }
    }

    public function more()
    {
        $model = M('news');
        $id = I('post.id');
        $time = $model -> where('id = '.$id )->find();
        $list = $model ->where('ptime < '.$time['ptime'] )->order('ptime desc')->limit(20)->select();
        if($list){
            $str = '';
            foreach($list as $n)
            {
                $str .= '
	<li class="clearfix" >
                    <div class="yb-ul-title clearfix" a="'.$n['id'].'">
                        <input type="hidden" name="id" value="'.$n['id'].'">
                        <h2 class="zq-name fL"><img src="http://test.fixstyle.cn/Public/Home/images/gf.png">'.$n['source'].'</h2>
                        <span class="pro-name fL">'.$n['tags'].'<img src="http://test.fixstyle.cn/Public/Home/images/important.png" class="d-v"></span>
                        <span class="hy-b fR">'.$n['area'].'</span>
                    </div>
                    <div class="yb-ul-inf clearfix" style="border-top:1px solid #f0f0f0;" >
                        <a href="'.U("Index/detail?id=".$n['id']).'">'.$n['title'].'</a><span class="yb-time">'.date('Y-m-d',$n['ptime']).'</span>
</div>
</li>';
            }
            echo $str;
        }
    }

    /**
     * 返回分类栏目
     */
    public function getType()
    {
        $like = I('post.tag');
        $uid = I('post.uid');
        $uid=1;
        $map['name'] = array('LIKE',$like.'%');
        $all = M('tags')->where($map)->select();
        $str='';
        if($all)
        {
            $str = '<p>为您查询到以下栏目：</p>
            <div class="my-dy-box">';
            foreach($all as $v)
            {
                $is_order = M('user_tags')->where("tag_id = {$v['id']} and uid = $uid")->find();
                if($is_order){
                $str .= "<p>".$v["name"]."<a href='javascript:;' onclick='cancel({$v['id']},{$uid})' class='cancel' u='".U('cancel')."' style='margin-left:50%;'>取消订阅</a></p>";
                }
                else
                {
                    $str .= "<p>".$v["name"]."<a href='javascript:;' onclick='add({$v['id']},{$uid})' class='and' u='".U('and')."'  style='margin-left:50%;'>添加订阅</a></p>";
                }
            }

        }
        echo $str.'</div>';
    }

    /**
     * 订阅
     */
       public function add()
    {
        $model = M('user_tags');
        $uid = I('post.uid');
        $id = I('post.id');
        $action = I('post.action');
        $tags = I('post.tags');
        if($action == 'add') {
            if($id || $tags) {
                $exist1 = $model ->where("uid = $uid and tag_id = $id ")->find();
                $exist2 = $model ->where("uid = $uid and tag_name = '{$tags}' ")->find();
                if(!$exist1 && !$exist2) {
                    $res = $model->add(array('tag_id' => $id, 'uid' => $uid, 'tag_name' => $tags));
                }
                else
                {
                    echo '0';
                }
            }
        }
        if($action == 'cancel')
        {
            $res = $model ->where(" id =  $id and uid = $uid ")->delete();
            if($res)
            {
                if($action=='cancel')
                {
                    echo '1';
                }
                else
                {
                    echo '2';
                }
            }
            else
            {
                echo '0';
            }
        }
    }

    /**
     *
     */
    public function choose()
    {
        $type = I('post.type');
        $model = M('news');
        if($type == 'time' || $type == 'day')
        {
            if($type == 'day'){
                $i = I('post.s');
                $start = time() - $i * 86400;
                $end = time();
            }
            else
            {
                $start = strtotime(I('post.s'));
                $end = strtotime(I('post.e'));
            }

            $all = $model->query("select * from wx_news where( status = 1 and  ptime > $start and ptime < $end ) order by ptime desc ");
        }
        elseif($type == 'area')
        {
            $area = I('post.area');
            $arr = explode(' ',$area);
            $str = str_replace('市','',$arr[1]);
            $all = $model->where(" area = '$str' ")->select();
        }
        elseif($type == 'words')
        {
            $words = I('post.words');
            $map['title'] = array('like',"%$words%");
            $all = $model->where($map)->select();
        }
        if($all)
        {
            $str = '<ul class="tabslider yb-ul" style="padding:0 0.5rem;">';
            foreach($all as $v)
            {
                $str .=
                    ' <a href="'.U("Index/detail?id=".$v['id']).'">
                        <li class="clearfix" >
                            <div class="yb-ul-title clearfix">
                                <h2 class="zq-name fL"><img src="http://test.fixstyle.cn/Public/Home/images/gf.png">'.$v['source'].'</h2>
                                <span class="pro-name fL">'.$v['tags'].'<img src="http://test.fixstyle.cn/Public/Home/images/important.png" class="d-v"></span>
                            </div>
                            <div class="yb-ul-inf clearfix" style="border-top:1px solid #f0f0f0;">
                                <a href="'.U("Index/detail?id=".$v['id']).'">'.$v['title'].'</a><span class="yb-time">'.date('Y-m-d',$v['ptime']).'</span>
                            </div>
                        </li>
                    </a>
                    ';
            }
            $str .= '</ul>';
            echo $str;
        }
        else
        {
            echo '0';
        }
    }

    /**
     *自定义菜单
     */
    public function custom()
    {
        $res = $this->customMenu();
        if(json_decode($res,true))
        {
            if($res['errcode'] == 0)
            {
                $this->success('成功',U('Admin/WeChat/index'));
            }
            else
            {
                $this->erros('请检查数据',U('Admin/WeChat/index'));
            }

        }
    }

    /**
     * 帮助
     */
    public function help()
    {
        $this -> display();
    }

    /**
     * 关于
     */
    public function about()
    {
        $this -> display();
    }

    /**
     * 推送
     */
    public function  push()
    {
        if($_SESSION['uid'])
        {
            $uid = $_SESSION['uid'];
        }else
        {
            $uid = I('get.uid');
        }
        $info = M('user')->where('id = ' .$uid )->find();
        $this->assign('uid',$uid);
        $this->assign('info',$info);
        $this -> display();
    }

    /**
     * 推送时间设置
     */
    public function setTime()
    {
        $uid = I('post.u');
        if (I('post.type') == '1'){//6-23点以后
            $update = M('user')->where('id = '.$uid )->save(array('push'=>1,'start'=>9,'end'=>23));
        }elseif(I('post.type')=='2'){//9点一次
            $update = M('user')->where('id = '.$uid )->save(array('push'=>2,'start'=>9,'end'=>9));
        }else{//自定义
            $push = explode(',',I('post.type'));
            $update = M('user')->where('id = '.$uid )->save(array('push'=>3,'start'=>$push[0],'end'=>$push[0]));
        }
        echo '1';
    }

    /**
     * 详情
     */
    public function detail()
    {
        $res = M('news')->where('id = '.I('get.id'))->find();
        if($res)
        {
            $n =  M('news')->where('ptime < '.$res['ptime'])->order('ptime desc')->find();
            $p =  M('news')->where('ptime > '.$res['ptime'])->order('ptime asc')->find();
            if($n) {
                $res['next'] = $n['id'];
            }
            else
            {
                $max = M('news')->max('id');;
                $res['next'] = $max;
            }
            if($p) {
                $res['pre'] = $p['id'];
            }
            else
            {
                $res['pre'] = 1;
            }
            $this->assign('res',$res);
            $this->display();
        }
        else
        {
            $this->redirect('Index/index');
        }
    }

    /**
     * 意见反馈
     */
    public function feedback()
    {
      $this->display();
    }

    public function feedsave()
    {
        $content = I('post.content');
        $uid = I('post.uid');
        $res = M('feedback')->add(array('uid'=>$uid,'content'=>$content,'addtime'=>time()));
        if ($res)
        {//添加成功
            $this->success('感谢您！');
            $this->redirect('Index/index');
        } else {//修改失败
            $this->error('对不起，服务器出错了！');
        }
    }

    /**
     * js回调地址
     */
    public function gets()
    {
        echo 'a';
    }

}
//    {
//        "button":[
//     {
//           "type":"view",
//           "name":"搜索",
//           "url":"http://test.fixstyle.cn/Home/Index/search.html"
//
//      },
//      {
//           "type":"view",
//           "name":"订阅",
//           "url":"http://test.fixstyle.cn/Home/Index/order.html"
//
//      },
//      {
//          "name":"发现",
//           "sub_button":[
//           {
//             "type":"view",
//             "name":"全部",
//             "url":"http://test.fixstyle.cn"
//            },
//            {
//             "type":"view",
//             "name":"分类",
//             "url":"http://test.fixstyle.cn/Home/Index/lists.html"
//            },
//          {
//               "type":"view",
//               "name":"关于",
//               "url":"http://test.fixstyle.cn/Home/Index/about.html"
//            },
//          {
//               "type":"view",
//               "name":"帮助",
//               "url":"http://test.fixstyle.cn/Home/Index/help.html"
//            },{
//               "type":"view",
//               "name":"反馈",
//               "url":"http://test.fixstyle.cn/Home/Index/feedback.html"
//            }
//]
//       }]
// }