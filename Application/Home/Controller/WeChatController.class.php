<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: huajie <banhuajie@163.com>
// +----------------------------------------------------------------------
namespace Home\Controller;
use Think\Page;
/**
 * 网址控制器
 * @author huajie <banhuajie@163.com>
 */
class WechatController extends HomeController
{
    protected function https_request($url, $data = null)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        if (!empty($data)){
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }

    private function checkSignature()
    {
        // you must define TOKEN by yourself
        // if (!defined("TOKEN")) {
        //  throw new Exception('TOKEN is not defined!');
        // }
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        $token = 'weixin';
        $tmpArr = array($token, $timestamp, $nonce);
        // use SORT_STRING rule
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );
        if( $tmpStr == $signature ){
            return true;
        }else{
            return false;
        }
    }

    public function valid()
    {
        $echoStr = $_GET["echostr"];
        //valid signature , option
        file_put_contents("ff.txt",'-1-',FILE_APPEND );//
        if($this->checkSignature()&&$echoStr)
        {
            header('content-type:text');
            file_put_contents("ff.txt",$echoStr,FILE_APPEND );//
            echo $echoStr;
            exit;
        }
        else
        {
            // file_put_contents("log.txt",'-dsa-',FILE_APPEND );//log
            $this->responseMsg();
        }
    }

    public function responseMsg()
    {
        //get post data, May be due to the different environments
        $postArr = file_get_contents("php://input");
        // file_put_contents("log.txt",$postArr,FILE_APPEND );//log
        if(!empty($postArr)){
            $postObj = simplexml_load_string($postArr, 'SimpleXMLElement', LIBXML_NOCDATA);
            if( strtolower( $postObj->MsgType) == 'event'){
                //如果是关注 subscribe 事件
                if( strtolower($postObj->Event) == 'subscribe')
                {
                    //回复用户消息(纯文本格式)
                    $toUser   = $postObj->FromUserName;
                    $fromUser = $postObj->ToUserName;
                    $time     = time();
                    $msgType  =  'text';
                    $content  = "欢迎来到cbi游戏天地,专业发车".$this->unicode2utf8_2("\ue159")."20年！\n\n告诉我,你从哪里知道伦家微信的？你为什么会关注伦家的公众号？".$this->unicode2utf8_2("\ue40a")."\n\n问题想问伦家的话,记得加上".$this->unicode2utf8_2("\ue210")."提问".$this->unicode2utf8_2("\ue210")."标签哦～\n\n司机聚集地：qq群 xxxxxxx，欢迎上车！\n\n快到菜单栏看看,各种资讯、福利,火爆来袭！".$this->unicode2utf8_2("\ue231")."<a href='http://mp.weixin.qq.com/mp/getmasssendmsg?__biz=MjM5MDQ3MDcwMQ==#wechat_webview_type=1&wechat_redirect'>历史消息</a>\n\n友情提示：<a href='http://m.cbigame.com/app/apk/%E6%B8%B8%E6%88%8F%E5%A4%A9%E5%9C%B0.apk'>安卓下载</a>".$this->unicode2utf8_2("\ue12E")."<a href='http://itunes.apple.com/cn/app/id1077997684?mt=8'>ios下载</a>,适合你的都在这里".$this->unicode2utf8_2("\ue41F");
                    $template = "<xml><ToUserName><![CDATA[%s]]></ToUserName>
										<FromUserName><![CDATA[%s]]></FromUserName>
										<CreateTime>%s</CreateTime>
										<MsgType><![CDATA[%s]]></MsgType>
										<Content><![CDATA[%s]]></Content></xml>";
                    echo sprintf($template, $toUser, $fromUser, $time, $msgType, $content);
                }
                else
                {
                    if($postObj->EventKey == 'help'){
                        $content = "发烧友请回复［单机］，查看最新单机大作。\n\n剁手党请回复［steam］,查看G胖最新动态。\n\n技术宅请回复［硬件］,查看游戏相关硬件资讯。";
                    }else{
                        $content = "小编正在努力策划ing.....";
                    }
                    $template = "<xml>
					 				<ToUserName><![CDATA[%s]]></ToUserName>
					 				<FromUserName><![CDATA[%s]]></FromUserName>
					 				<CreateTime>%s</CreateTime>
					 				<MsgType><![CDATA[%s]]></MsgType>
					 				<Content><![CDATA[%s]]></Content>
					 				</xml>";
                    $fromUser = $postObj->ToUserName;
                    $toUser   = $postObj->FromUserName;
                    $time = time();
                    $msgType = 'text';
                    echo sprintf($template,$toUser,$fromUser,$time,$msgType,$content);
                }
            }
        }
        //回复纯文本
        if(strtolower($postObj->MsgType)=='text')
        {
            $name = $postObj->Content;
            if($name=='单机'||strtolower($name)=="steam"||$name=='硬件')
            {
                $toUser = $postObj->FromUserName;
                $fromUser = $postObj ->ToUserName;
                require_once '../inc/function.php';
                if($name == '硬件'){
                    $sql="select news.a as title,news.a1 as description,news.pic as picUrl,news.id from news left join web on news.typeid=web.id where news.isshow=1 and web.a = '{$name}' order by news.id desc limit 10";
                }elseif($name == '单机'){
                    $sql = "select g.id as id,g.a as title,g.pic as picUrl,g.a as description from game as g   where find_in_set(5,g.b1) and g.pic !='' group by g.id order by addtime desc,id desc  limit 10";
                }else{
                    $sql = "select id,a as title,a1 as description,pic as picUrl from news where tid_='3,98' and isshow=1 order by id desc limit 10";
                }
                // file_put_contents("log.txt",$sql."||",FILE_APPEND );//log
                $arr = pdo($sql);
                $template = "<xml>
										<ToUserName><![CDATA[%s]]></ToUserName>
										<FromUserName><![CDATA[%s]]></FromUserName>
										<CreateTime>%s</CreateTime>
										<MsgType><![CDATA[%s]]></MsgType>
										<ArticleCount>".count($arr)."</ArticleCount>
										<Articles>";
                // file_put_contents("log.txt",$template,FILE_APPEND );//log
                foreach ($arr as $k => $v) {
                    $template .= "<item>
											<Title><![CDATA[".str_replace('%','%%',$v['title'])."]]></Title>
											<Description><![CDATA[".str_replace('%','%%',$v['description'])."]]></Description>
											<PicUrl><![CDATA["._imgdomain.$v['picUrl']."]]></PicUrl>
											<Url><![CDATA[http://m.cbigame.com/app/details.php?id=".$v['id']."]]></Url>
											</item>";
                }
                $template .= "</Articles>
											</xml>";
                // file_put_contents("log.txt",$template,FILE_APPEND );//log
                echo sprintf($template,$toUser,$fromUser,time(),'news');
            }
            else
            {
                $content = "寂寞难耐找小编!\n小编竟然不理人？\n不要急".$this->unicode2utf8_2("\ue021").$this->unicode2utf8_2("\ue021").$this->unicode2utf8_2("\ue021")."\n乐享社区大把基友软妹等约～ \n下载：<a href='http://m.cbigame.com/app/apk/%E6%B8%B8%E6%88%8F%E5%A4%A9%E5%9C%B0.apk'>安卓下载</a>".$this->unicode2utf8_2("\ue12E")."<a href='http://itunes.apple.com/cn/app/id1077997684?mt=8'>ios下载</a>";
                $template = "<xml>
					 				<ToUserName><![CDATA[%s]]></ToUserName>
					 				<FromUserName><![CDATA[%s]]></FromUserName>
					 				<CreateTime>%s</CreateTime>
					 				<MsgType><![CDATA[%s]]></MsgType>
					 				<Content><![CDATA[%s]]></Content>
					 				</xml>";
                $fromUser = $postObj->ToUserName;
                $toUser   = $postObj->FromUserName;
                $time = time();
                $msgType = 'text';
                echo sprintf($template,$toUser,$fromUser,$time,$msgType,$content);

            }
        }
    }

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

    public function saveMenu()
    {
        $model = M('menus');
        $group = $model->where('id = '.I('post.group')) ->find();
        $data = array('name'=>I('post.name'),'group'=>$group['name'],'addtime'=>time());
        $res = $model ->add($data);
        if($res){//添加成功
            $this->success('添加成功');
            $this->redirect('Wechat/index');
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
        $group = M('menus')->where('id = '.I('post.group'))->find();
        $data = array('name' => I('post.name'),'group'=>$group['name']);
        $res = M('menus')->where('id = '.$id)->save($data);
        if ($res)
        {//添加成功
            $this->success('修改成功');
            $this->redirect('Wechat/index');
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
            $this->success('添加成功');
            $this->redirect('Wechat/message');
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

    public function msgUpdate()
    {
        $id = I('post.id');
        dump(I('post.'));
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
}