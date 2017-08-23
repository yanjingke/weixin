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
class WeixinController extends HomeController
{
    public $C;
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
        //file_put_contents(APP_PATH.'Home/Controller/log.txt','-1-',FILE_APPEND );//
        if($this->checkSignature()&&$echoStr)
        {//配置url
            header('content-type:text');
           // file_put_contents(APP_PATH.'Home/Controller/log.txt',$echoStr,FILE_APPEND );//
            echo $echoStr;
            exit;
        }
        else
        {//关注，事件
            file_put_contents(APP_PATH.'Home/Controller/log.txt','-2-',FILE_APPEND );//log
            $this->responseMsg();
        }
    }

    public function responseMsg()
    {
        //get post data, May be due to the different environments
        $postArr = file_get_contents("php://input");
        if(!empty($postArr)){
            $postObj = simplexml_load_string($postArr, 'SimpleXMLElement', LIBXML_NOCDATA);
           // file_put_contents(APP_PATH.'Home/Controller/log.txt',$postObj->FromUserName.$this->getLocalToken(),FILE_APPEND );//log
            if( strtolower( $postObj->MsgType) == 'event'){
                //如果是关注 subscribe 事件
                if( strtolower($postObj->Event) == 'subscribe')
                {
                    /*用户信息记录*/
                    $key = C('APPKEY');
                    $secret = C('APPSECRET');
                    $token = $this->getLocalToken();
                   // file_put_contents(APP_PATH.'Home/Controller/log.txt','-token:'.$token.'---',FILE_APPEND );//log
                    $openId = $postObj->FromUserName;
                    $this->updateUser($openId,$token);
                    //回复用户消息(纯文本格式)
                    $toUser   = $postObj->FromUserName;
                    $fromUser = $postObj->ToUserName;
                    $time     = time();
                    $msgType  =  'text';
                    $content  = "感谢您的关注，您可以在'订阅'栏添加感兴趣的关键字或分类，如需帮助请点击：'更多>帮助'查看。";
                    $template = "<xml><ToUserName><![CDATA[%s]]></ToUserName>
										<FromUserName><![CDATA[%s]]></FromUserName>
										<CreateTime>%s</CreateTime>
										<MsgType><![CDATA[%s]]></MsgType>
										<Content><![CDATA[%s]]></Content></xml>";
                    echo sprintf($template, $toUser, $fromUser, $time, $msgType, $content);
                }
                elseif(strtolower($postObj->Event) == 'unsubscribe')
                {
                    $openId = $postObj->FromUserName;
                    M('user')->where(" openid = '{$openId}' ")->save(array('status'=>0));
                }
                else
                {
//                    if($postObj->EventKey == 'help'){
//                        $content = "发烧友请回复［单机］，查看最新单机大作。\n\n剁手党请回复［steam］,查看G胖最新动态。\n\n技术宅请回复［硬件］,查看游戏相关硬件资讯。";
//                    }else{
//                        $content = "小编正在努力策划ing.....";
//                    }
                    $content = '1111';
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
        /*if(strtolower($postObj->MsgType)=='text')
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
        }*/
    }

    /**
     * @param $APPID
     * @param $APPSECRET
     * @return mixed
     * 获取token
     */
    public function getToken(){
    	//S('access_token',2000);
    	 $token=S('access_token');
    	 if($token==''&& $token==null){
    	 	
    	
       // $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wxb5e2f78d117caf9f&secret=2eb5822204122b72b89bc2cf3e0dc46a";
	    $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wx542285e21b5ffb86&secret=88f01978f07496824dae16d9bec76fe3";
       
        $res = json_decode($this->https_request($url),true);
        $token = $res['access_token'];
        S('access_token',$token,'2000');
    	  }
        return $token;
    }

    /**
     * @param $token
     * @param $openid
     * @return string
     * 获取用户信息
     */
    public function getInfo($token,$openId){
        $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=$token&openid=$openId&lang=zh_CN";
        $res = json_decode($this->https_request($url),true);
        return $res;
    }

    /*
     * {
           "touser":"OPENID",
           "template_id":"ngqIpbwh8bUfcSsECmogfXcV14J0tQlEpBO27izEYtY",
           "url":"http://test.fixstyle.cn/",
           "data":{
                   "first": {
                       "value":"咨询更新！",
                       "color":"#173177"
                   },
                   "keyword1":{
                       "value":"订阅咨询",
                       "color":"#173177"
                   },
                   "keyword2": {
                       "value":"立法",
                       "color":"#173177"
                   },
                   "remark":{
                       "value":"测试",
                       "color":"#173177"
                   }
           }
       }*/
    /**
     * @param $openid
     * @param $url
     * @param $first
     * @param $keyword1
     * @param $keyword2
     * @param $remark
     * 自定义消息发送：标签
     */
    public function sendMessage1($token,$openid,$url,$first,$keyword1,$keyword2,$remark)
    {
       $data = array(
           'touser'=>$openid,
           'template_id'=>'6hsaXXNTeNwam_wSdga2gu2AxhzgY8UyF-7JC576o9c',
           'url'=>$url,
           'data'=>array(
               'first'=>$first,
               'keyword1'=>$keyword1,
               'keyword2'=>$keyword2,
               'remark'=>$remark
           )
       );
        $template = json_encode($data);
        $url = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$token;
        $res = $this->https_request($url,urldecode($template));
        file_put_contents(APP_PATH.'Home/Controller/log.txt','-res-:'.$res.'---',FILE_APPEND );
    }

    /**
     * @param $str
     * @return mixed|string
     * 转义emoji表情
     */
    function userTextEncode($str){
        if(!is_string($str))return $str;
        if(!$str || $str=='undefined')return '';

        $text = json_encode($str); //暴露出unicode
        $text = preg_replace_callback("/(\\\u[ed][0-9a-f]{3})/i",function($str){
            return addslashes($str[0]);
        },$text); //将emoji的unicode留下，其他不动，这里的正则比原答案增加了d，因为我发现我很多emoji实际上是\ud开头的，反而暂时没发现有\ue开头。
        return json_decode($text);
    }

    /**
     *解码emoji表情转义
     */
    function userTextDecode($str){
        $text = json_encode($str); //暴露出unicode
        $text = preg_replace_callback('/\\\\\\\\/i',function($str){
            return '\\';
        },$text); //将两条斜杠变成一条，其他不动
        return json_decode($text);
    }


    public function getLocalToken()
    {
        $model = M('Token');
        $exist = $model->where('token != null and time > '.time())->order('time desc')->find();
        if($exist)
        {
            $token = $exist['token'];
        file_put_contents(APP_PATH.'Home/Controller/log.txt','-insert-:'. '我是碍手碍脚就'.$token.'---',FILE_APPEND );
        
        }
        else
        {
            $token = $this->getToken();
            file_put_contents(APP_PATH.'Home/Controller/log.txt','-insert-:'.$res.'---',FILE_APPEND );
            $data = array('token'=>$token,'time'=>time() + 7100);
            $res = $model->add($data);
            
        }
        
        return $token;
    }

    public function updateUser($openId,$token)
    {
        $model = M('user');
        $exist =  $model->where(" openid = '{$openId}' ")->find();
        if($exist)
        {
            $insert = $exist['id'];
            $model->where(" openid = '{$openId}' ")->save(array('status'=>1,'time'=>time()));
        }
        else
        {
        	
            $info = $this->getInfo($token, $openId);
            
            $data['nick'] = $this->userTextEncode($info['nickname']);
            $data['openid'] = $info['openid'];
            $data['city'] = $info['city'];
            $data['province'] = $info['province'];
            $data['avatar'] = $info['headimgurl'];
            $data['sex'] = $info['sex'];
            $data['time'] = time();
            file_put_contents(APP_PATH.'Home/Controller/log.txt',$data['openid'].'9219838921'.$data['nick'],FILE_APPEND );//log
            
            $model->add($data);
        }
    }

    public function  send1($openid,$uid,$id=null)
    {
        if($id == null) {
            /*查询用户订阅时间*/
            $hour = date('H');
            $map['start'] = array('lt', $hour);
            $map['end'] = array('gt', $hour);
            $is_send = M('user')->where($map)->select();
            /**可以推送的用户**/
            if ($is_send) {
                /*查询用户订阅数据*/
                $where = '';
                foreach ($is_send as $v) {
                    $uid = $v['id'];
                    $tags = M('tags')->where('uid = ' . $uid)->select();
                    if ($tags)
                    {
                        if ($v['tag_id']) {
                            $name = M('tags')->where('id = ' . $v['tag_id'])->find();
                            $where .= " or where title like %{$name['name']}% ";
                        } else {
                            $where .= "or where title like %{$v['tag_name']}% ";
                        }
                        $where = trim($where, ' ');
                        $where = trim($where, 'or');
                        $res = M('news')->where($where)->order('ptime desc')
                            ->limit(10)
                            ->select();
                        if ($res) {
                            /*发送消息*/
                        }
                    }
                }
            }
            $res = M('news')
                ->order('rand()')
                ->limit(10)
                ->select();
            $str = '';
            foreach ($res as $k => $v) {
                $key = $k + 1;
                if ($this->utf8_strlen($v['title']) > 50) {
                    $title = $this->utf8_strcut($v['title'], 50) . '...' . '[查看详情]' . '\n';
                } else {
                    $title = $v['title'] ;
                }
                $str .= "({$key})" . $title;
            }
            $remark = $str . '[查看更多]';
            $url = "http://test.fixstyle.cn/home/index/index.html/uid/$uid/start/10/end/10";
        }
        else
        {
            if(is_string($id)) {//单条
                $res = M('news')
                    ->where(' id = ' . $id)
                    ->select();
                $str = '';
                foreach ($res as $k => $v) {
                    $key = $k + 1;
                   // $title = $v['title'] . '[查看详情]' . '\n';
                   // $str .= "({$key})" . $title;
                   $title = $v['title'];
                   $str = $title;
                }
                   $remark = $str;
                $url = "http://test.fixstyle.cn/Home/Index/detail/id/{$id}.html";
                    M('news')
                    ->where(' id = ' . $id)
                    ->setInc('times');
            }
            else
            {//多条
                $where['id'] = array('in',$id);
                $res = M('news')
                    ->where($where)
                    ->select();
                $str = '';
                foreach ($res as $k => $v) {
                    $key = $k + 1;
                    if ($this->utf8_strlen($v['title']) > 50) {
                        $title = $this->utf8_strcut($v['title'], 50) . '...' . '[查看详情]' . '\n';
                    } else {
                        $title = $v['title'] . '[查看详情]' . '\n';
                    }
                    $str .= "({$key})" . $title;
                }
                $remark = $str;
                $url = "http://test.fixstyle.cn/home/index/index.html/uid/$uid/start/10/end/10";
                M('news')
                    ->where($where)
                    ->setInc('times');
            }
        }
        //sendMessage($openid,$url,$first,$keyword1,$keyword2,$remark)
        //$openid = 'oPgzJw6KafsYsBegWgrFW0fTLuTA';
          $first ='';
        $keyword1 = '';
        $keyword2 = '';
       // $remark=substr($remark,0,15);
//        $first = array('value' => urlencode("法务咨询更新"), 'color' => "#000000");
//        $keyword1 = array('value' => urlencode("咨询更新"), 'color' => '#000000');
//        $keyword2 = array('value' => urlencode('咨询'), 'color' => '#000000');
       // $remark = array('value' => urlencode($remark), 'color' => '#0000CD');
      	 // file_put_contents(APP_PATH.'Home/Controller/log.txt','-dasdss-:'.$remark.'---',FILE_APPEND );
        $token = $this->getLocalToken();
        file_put_contents(APP_PATH.'Home/Controller/log.txt','-dasdss-:'. $token.'---',FILE_APPEND );
        $this->sendMessage($token, $openid, $url, $first, $keyword1, $keyword2,$remark);
    }

    function utf8_strlen($str) {	//UTF编码字符长度计算
        preg_match_all('/./us',$str, $match);
        return count($match[0]);
    }
    function utf8_strcut($str, $start, $length=null) {   //UTF编码字符截取
        preg_match_all('/./us', $str, $match);
        $chars = is_null($length)? array_slice($match[0], $start ) : array_slice($match[0], $start, $length);
        unset($str);
        return implode('', $chars);
    }

    /**
     * 群发
     */
    public function sendAll()
    {
        $all = M('user')->where('status = 1')->select();
        foreach($all as $v)
        {
            $this->send($v['openid'],$v['uid']);
        }
        echo 'ok';
    }

    public function customMenu()
    {
        $model =  M('menus');
        $token = $this->getLocalToken();
        $url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$token;
        $data = $model ->where('pid = 0')->order('o')->select();
        $crr = array();
        foreach($data as $v)
        {
            $sub = $model -> where(" `group` = ".$v['id'])->order('o')->select();
            if($sub)
            {
                $arr['name'] = $v['name'];
                foreach($sub as $item)
                {
                    $brr['type'] = 'view';
                    $brr['name'] = $item['name'];
                    $brr['url'] =  $item['url'];
                    $arr['sub_button'][] = $brr;
                }
            }
            else
            {
                $arr['type'] = 'view';
                $arr['name'] = $v['name'];
                $arr['url'] = $v['url'];
            }
            $crr[] = $arr;
        }
        foreach($crr as &$v)
        {
            if($v['sub_button'])
            {
                unset($v['type']);
                unset($v['url']);
            }
        }

        $data = json_encode(array('button'=>$crr),JSON_UNESCAPED_UNICODE);
        $data = str_replace("\\/", "/",  $data);
        return $this->https_request($url,$data);
    }

    /**
     * 群发
     */
    public function sendOne()
    {
        $id = I('get.id');
      
   		
 		           
//        $model = M('history');
//        $uid=$this->getUUid();
//        $data = array('uid'=>$uid,'id'=>$id,'time'=>time(),'title'=>$title,'content'=> $content,'juimage'=>0);
//        $res = $model->add($data);
     
        $all = M('user')->where("status = 1 ")->select();
         $tem=0;
  		 $cot=1;
        foreach($all as $v)
        {
        	 $tem++;
           if( $tem==1 ){
            $cot=1;
        }else {
        	 $cot=0;
        }
        	
            $this->send($v['openid'],$v['uid'],$id, $cot);
        }
        echo 'ok';
    }

    /**
     * 群发
     */
    public function sendMore()
    {
        $ids = I('post.data');
        $all = M('user')->where("status = 1 ")->select();
         $tem=0;
  		 $cot=1;
//          $where['id'] = array('in',$ids);
//                $res = M('news')
//                    ->where($where)
//                    ->select();
//         $uid=$this->getUUid();
//         $model = M('history');
//          $modelc = M('sehistory');
//            $datac=array('uid'=> $uid);
//            $modelc.add($datac);
//       	 $time= time();
//       	 $time= date("Y-m-d H:i",$time);
//           foreach ($res as $k1 => $v1) {
//    	     		//$arr2=array();
//                    $title = $v1['title'];
//                     $content = $v1['content'];
//                     $id =$v1['id'];
//                   
//       				 $data = array('uid'=> $uid,'id'=>$id,'time'=>$time,'title'=>$title,'content'=> $content,'juimage'=>1);
//        			 $res = $model->add($data);
//           }
        foreach($all as $v)
        {
         $tem++;
           if( $tem==1 ){
            $cot=1;
        }else {
        	 $cot=0;
        }
            $this->send($v['openid'],$v['uid'],$ids,$cot);
        }
        echo 'ok';
    }
    /**
     * 自定义菜单
     * //    {
    //        "button":[
    //     {
    //         "type":"view",
    //         "name":"首页",
    //         "url":"http://test.fixstyle.cn"
    //      },
    //      {
    //         "type":"view",
    //         "name":"列表",
    //         "url":"http://test.fixstyle.cn/Home/Index/lists.html"
    //      },
    //      {
    //          "name":"更多",
    //           "sub_button":[
    //           {
    //               "type":"view",
    //               "name":"搜索",
    //               "url":"http://test.fixstyle.cn/Home/Index/search.html"
    //            },
    //            {
    //                "type":"view",
    //               "name":"订阅",
    //               "url":"http://test.fixstyle.cn/Home/Index/order.html"
    //            }]
    //       }]
    // }
     */


    public function  sendMessage($token, $openid, $url, $pic, $title,$content,$cot)
    {
    	$arr= array(array(
               'title'=> urlencode($title),
               'description'=>urlencode("saaddadasdsadsads"),
               'url'=>urlencode($url),
               'picurl'=>urlencode($pic)
                 ));
    	 $data = array(
           'touser'=>$openid,
           'msgtype'=>'news',
           'news'=>array(
    	 'articles'=>
    			$arr
               
           )
   //UL4r7reKvqewLxORv-3JikoucGQIePS_ZCs70NxKduyNR2gXLqHK4F06frFkmZzMQsUU_z4ndEdsfDgkIhFLxaOdCMIPoqr6rLMATra0z7Sc3KButH5O2WZuekK9UdYzWRUdAIAJEH
       );
       if($cot==1){
       	
       $arr = urldecode(json_encode($arr)); 
       $new = serialize($arr);
       $model = M('historyj');
       $uid=$this->getUUid();
       $time=time();
       $time= date("Y-m-d H:i:s",$time);
       $data = array('uid'=>$uid,'time'=> $time,'historyjson'=>$new,'juimage'=>0);
       $res = $model->add($data);
       }
        $template = urldecode(json_encode($data));
        $url = 'https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token='.$token;
        // $url = 'https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=tJVTeo2x-U6x8gWLTnzKi-4AVF3MHA4prY3xoIJVd5_fT7tjOsz6DNKCvUt7ut9UWJKhWyUd1cTYBoWeWwoW3fDQp0-EiAWddqQiG2U1FAgPWIbAHABIU';
     
             $res = $this->https_request($url,$template);
        file_put_contents(APP_PATH.'Home/Controller/log.txt','-res-:'.$template .'---',FILE_APPEND );
 
           }
  
 public function  send($openid,$uid,$id=null,$cot)
    {
        if($id == null) {
            /*查询用户订阅时间*/
            $hour = date('H');
            $map['start'] = array('lt', $hour);
            $map['end'] = array('gt', $hour);
            $is_send = M('user')->where($map)->select();
            /**可以推送的用户**/
            if ($is_send) {
                /*查询用户订阅数据*/
                $where = '';
                foreach ($is_send as $v) {
                    $uid = $v['id'];
                    $tags = M('tags')->where('uid = ' . $uid)->select();
                    if ($tags)
                    {
                        if ($v['tag_id']) {
                            $name = M('tags')->where('id = ' . $v['tag_id'])->find();
                            $where .= " or where title like %{$name['name']}% ";
                        } else {
                            $where .= "or where title like %{$v['tag_name']}% ";
                        }
                        $where = trim($where, ' ');
                        $where = trim($where, 'or');
                        $res = M('news')->where($where)->order('ptime desc')
                            ->limit(10)
                            ->select();
                        if ($res) {
                            /*发送消息*/
                        }
                    }
                }
            }
            $res = M('news')
                ->order('rand()')
                ->limit(10)
                ->select();
            $str = '';
            foreach ($res as $k => $v) {
                $key = $k + 1;
                if ($this->utf8_strlen($v['title']) > 50) {
                    $title = $this->utf8_strcut($v['title'], 50) . '...' . '[查看详情]' . '\n';
                } else {
                    $title = $v['title'] ;
                }
                $str .= "({$key})" . $title;
            }
            $remark = $str . '[查看更多]';
            $url = "http://test.fixstyle.cn/home/index/index.html/uid/$uid/start/10/end/10";
               $token = $this->getLocalToken();
        file_put_contents(APP_PATH.'Home/Controller/log.txt','-dasdss-:'. $url.'---',FILE_APPEND );
        $this->sendMessage($token, $openid, $url, $pic, $title,$content);
        }
        else
        {
            if(is_string($id)) {//单条
                $res = M('news')
                    ->where(' id = ' . $id)
                    ->select();
                $str = '';
                $tem=M('spider')
                    //->where(' id = ' . $id)
                    ->where(' id =8')
                    ->select();
                foreach ($res as $k => $v) {
              	
                   $title = $v['title'];
                   
                    $content = $v['content'];
                }
             foreach ($tem as $k => $v) {
              	
                //   $url = $v['url'];
                   $pics = $v['pic'];
   					//$y=count($pics);
   					 // file_put_contents(APP_PATH.'Home/Controller/log.txt','-长度为-:'. $y.'---',FILE_APPEND );
       			$pic=preg_replace('/[ ]/', '', $pics);
       			$pic=str_replace('[','',$pic);
       			$pic=str_replace(']','',$pic);
       			$pic=str_replace('\'','',$pic);
   				$pic=  strrchr($pic, "download");	         
                }
                 $pic = "http://yanjingke.w3.luyouxia.net/weixin/Application/Home/Public/downloadpic/thumbs/www.bjr".$pic;
   			
                 $url = "http://test.fixstyle.cn/Home/Index/detail/id/".$id.".html";
                 $token = $this->getLocalToken();//测试
//                 $model = M('pushhistory');
//            	 $data = array('id'=>$id,'endtime'=>time(),'title'=>$title,'content'=> $content);
//               	 $res = $model->add($data);

            //   $token = null;//测试
       // file_put_contents(APP_PATH.'Home/Controller/log.txt','-dasdss-:'.$res.'---',FILE_APPEND );
        $this->sendMessage($token, $openid, $url, $pic, $title,$content,$cot);
                 
            }
            else
            {
            	//多条
                $where['id'] = array('in',$id);
                $res = M('news')
                    ->where($where)
                    ->select();
                    
                $str = '';
                
                $tem=M('spider')
                    //->where(' id = ' . $id)
                    ->where(' id =8')
                    ->select();
                   $token = $this->getLocalToken();//测试
             // $token = null;//测试 
              $this->sendMessageduo($openid,$token, $res ,$tem,$cot);
			}
          
                    }
                   
              
        }
            
        
  
    
    public function  sendMessageduo($openid,$token, $res ,$tem,$cot)
    {
    		$arr=array(); 
    		
    	     foreach ($res as $k1 => $v1) {
    	     	$arr2=array();
                    $title = $v1['title'];
                     $content = $v1['content'];
                     $id =$v1['id'];
                     $url = "http://test.fixstyle.cn/Home/Index/detail/id/".$id.".html";
              foreach ($tem as $k => $v) {
              	
                   $pics = $v['pic'];
   				$pic=preg_replace('/[ ]/', '', $pics);
       			$pic=str_replace('[','',$pic);
       			$pic=str_replace(']','',$pic);
       			$pic=str_replace('\'','',$pic);
   				$pic=  strrchr($pic, "download");
			 	$pic = "http://yanjingke.w3.luyouxia.net/weixin/Application/Home/Public/downloadpic/thumbs/www.bjr".$pic;
   			
   				 $arr2[description]="asdsadas";
          		 $arr2[url]= urlencode($url);
          		 $arr2[picurl]=urlencode($pic);
				$arr2[title]=urlencode($title);
                }

          		
				array_push($arr,$arr2);
				
         }
    	 
    	
    	 $data = array(
           'touser'=>$openid,
           'msgtype'=>'news',
           'news'=>array(
    	 	'articles'=> $arr
           )
       );
      if($cot==1){
       	
       $arr = urldecode(json_encode($arr)); 
       $new = serialize($arr);
       $model = M('historyj');
       $uid=$this->getUUid();
       $time=time();
       $time= date("Y-m-d H:i:s",$time);
       $data = array('uid'=>$uid,'time'=> $time,'historyjson'=>$new,'juimage'=>1);
       $res = $model->add($data);
       }
       
        $template = urldecode(json_encode($data));
        $url = 'https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token='.$token;
         $res = $this->https_request($url,$template);
        // $this->arrayToXml($data);
        //file_put_contents(APP_PATH.'Home/Controller/log.txt','-res-:'. $template .'---',FILE_APPEND );
 		
           
    }
     public function test(){
    // S('data',123);

	//echo $redis->get("test");
	echo S('access_token');
     }
    function getUUid() {    
      return  date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
    }
	
	
}
