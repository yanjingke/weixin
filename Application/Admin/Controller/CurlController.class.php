<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: huajie <banhuajie@163.com>
// +----------------------------------------------------------------------

namespace Admin\Controller;
/**
 * 信息控制器
 * @author huajie <banhuajie@163.com>
 */

class CurlController extends AdminController
{

    public $curl;
    public $dom;
    public function __construct()
    {
        include ('Class_Curl_Html.php');
        include ('simple_html_dom.php');
    }
    /*
     * 编码转换
     */
    function encode_mb($rst){
        $encode = mb_detect_encoding($rst, array('GBK','UTF-8','ASCII','GB2312','BIG5') );
        if($encode !== 'UTF-8'){
            // $day_html = mb_convert_encoding($day_html,'UTF-8','GBK');
            $rst = mb_convert_encoding($rst, 'UTF-8', $encode);
            // $rst = mb_convert_encoding($rst, 'UTF-8');
        }
        return $rst;
    }
    #######################################成都人大 start################################
    /**
     *成都人大
     */
    public function cdrd()
    {
        $this->curl = new \Class_Curl_Html();
        $this->dom = new \simple_html_dom();
        $url = 'http://www.cdrd.gov.cn/html/works/legislation/';
        $urls = $this->getUrlListcd($url);
       // $this -> getListPage();//获取栏目列表
        if($urls)
        {
            foreach($urls['urls'] as $k=>$v)
            {
                $res[] = $this->getContentcd($v,$urls['time'][$k]);
            }
            dump($res);
        }

    }

    /**
     * @param $url
     * @return array
     * 获取列表
     */
    public function getUrlListcd($url)
    {
        $page_html=$this->curl->geturlHtml($url,2,'');
        $page_html=$this->encode_mb($page_html);
        preg_match_all('/<div class="li">.*?<\/div>/ism',$page_html,$page);
        foreach($page[0] as $v)
        {
            preg_match_all('/<a href="(.*?)".*>/',$v,$u);
            $list[] = $u[1];
            preg_match_all('/<div class="Ttime">(.*?)<\/div>/',$v,$t);
            $time[] = $t[1][0];
        }
        foreach($list as $v)
        {
            foreach ($v as $item) {
                if(!preg_match('/^http/i',$item)) {
                    $urls[] = 'http://www.cdrd.gov.cn' . $item;
                }
                else
                {
                    $urls[] = $item;
                }
            }
        }
        $res['time'] = $time;
        $res['urls'] = $urls;
        return $res;
     }

    /**
     * @param string $url
     * 获取单页内容
     */
    public function getContentcd($url,$time=null)
    {
        set_time_limit(0);
        $html =$this->curl->geturlHtml($url,2,'');
        preg_match_all('/<div class="new_til">(.*?)<\/div>/ism',$html,$titleHtml);
        //新闻标题
        $title = $titleHtml[1][0];
        //新闻内容
        preg_match_all('/<div class="new_text" id="pgcontent">(.*?)<\/div>/ism',$html,$contentHtml);

        $content = $contentHtml[1][0];
        /**内容图片处理**/
//        $imgUrl = substr($url,0,strrpos($url,'/'));
        preg_match_all("/\<[img].*?src\=\"(.*?)\"[^>]*>/i", $content, $match);
        if($match)
        {
            foreach($match[1] as $val)
            {
                $content = str_replace($val,'http://www.cdrd.gov.cn/'.substr($val,1),$content);
            }
        }
        $ptime = $time;
        $str = str_replace('[','',$ptime);
        $str = str_replace(']','',$str);
        $str = str_replace('年','-',$str);
        $str = str_replace('月','-',$str);
        $str = str_replace('日','',$str);
        $time =  strtotime('20'.$str);
        $model = M('news');
        $exist = $model -> where("title = '{$title}'")->select('title');
        if(!$exist)
        {//添加数据
            $res = $model ->add(array('title'=>$title,'ptime'=>$time,'content'=>$content,'url'=>$url,'addtime'=>time(),'source'=>'成都人大网','area'=> '成都'));
            if($res)
            {
                $arr['success'] = $title;
            }
            else
            {
                $arr['fail'] = $title;
            }
            return $arr;
        }
    }

    /**
     * 首页:获取栏目 list
     */
    public  function  getListPagecd()
    {
        $url = 'http://www.scspc.gov.cn/lfgz/';
        $page_html=$this->curl->geturlHtml($url,2,'');

        $page_html=$this->encode_mb($page_html);
        preg_match_all('/<div class="nav">.*?<\/div>/ism',$page_html,$page);
        preg_match_all('/<a href="(.*?)".*>/',$page[0][0],$u);
        foreach($u[1] as $v)
        {
            $urls[] = 'http://www.scspc.gov.cn'.str_replace('..','',$v);
        }
        return $urls;
    }
    #######################################成都人大 end ################################
    #######################################四川人大 start ################################
    /**
     *四川人大
     */
    public function scrd()
    {
        if( I('post.url')) {
            $url = I('post.url');
        }
        else {
            $url = 'http://www.scspc.gov.cn/lfgz/index.html';
        }
        $this->curl = new \Class_Curl_Html();
        $this->dom = new \simple_html_dom();
         $url = 'http://www.scspc.gov.cn/lfgz/lfdt/201609/t20160922_31570.html';
        $con = $this->getContentsc($url);
        print_r($con);
        /***/
//        $urls = $this->getUrlListsc($url);
//        if($urls)
//        {
//            $i = 0;
//            foreach($urls as $k=>$v)
//            {
//                $res = $this->getContentsc($v);
//                if($res['success'])
//                {
//                    $i++;
//                }
//            }
//            $this->redirect('News/index');
//        }
    }

    /**
     * @param $url
     * @return array
     * 获取列表
     */
    public function getUrlListsc($url)
    {
        $page_html=$this->curl->geturlHtml($url,2,'');
        $page_html=$this->encode_mb($page_html);
        $preg = "/<script[\s\S]*?<\/script>/i";
        $page_html = preg_replace($preg,"",$page_html);
        $page_html = str_replace('<--','',$page_html);
        $page_html = str_replace('-->','',$page_html);
        preg_match_all('/<ul class=\'right_ul1\'>.*?<\/ul>/ism',$page_html,$page);
        $urls=array();
        foreach($page[0] as $v)
        {
            preg_match_all('/<a href="(.*?)".*>/',$v,$u);
            foreach($u[1] as $item) {
                if (!preg_match('/^http/i', $item)) {
                    $urls[] = 'http://www.scspc.gov.cn/lfgz/' . substr($item,2);
                } else {
                    $urls[] = $item;
                }
            }
        }
        return $urls;
    }

    public function getContentsc($url)
    {
        set_time_limit(0);
        $html =$this->curl->geturlHtml($url,2,'');
        preg_match_all('/<a href=".*?" target="_self" class="CurrChnlCls">(.*?)<\/a>/ism',$html,$u);
        foreach($u[1] as $k => $v)
        {
            if($k>0) {
                $tags .= ',' . $v;
            }
        }
        $tag =  trim($tags,',');//分类
        preg_match_all('/<h1 class="mt46 cc0" id="testNO">(.*?)<\/h1>/ism',$html,$titleHtml);
        //新闻标题
        $title = $titleHtml[1][0];
        //新闻内容
        if(strpos($tags,'立法计划')!== false || strpos($tags,'新法聚焦')!== false){
            preg_match_all('/<div class="TRS_Editor">(.*?)<\/div><\/div>/ism',$html,$contentHtml);
        }
        else
        {
            preg_match_all('/<div class="TRS_Editor">(.*?)<\/div><\/div>/ism',$html,$contentHtml);
        }
        $content = $contentHtml[1][0];
        if(!$content)
        {
            preg_match_all('/<div .*? id="content" .*?>(.*?)<\/div><\/div>/ism',$html,$contentHtml);
            $content = $contentHtml[1][0];
        }

        /**内容图片处理**/
        $imgUrl = substr($url,0,strrpos($url,'/'));
        preg_match_all("/\<[img].*?src\=\"(.*?)\"[^>]*>/i", $content, $match);
        if($match)
        {
            foreach($match[1] as $val)
            {
                $content = str_replace($val,$imgUrl.substr($val,1),$content);
            }
        }
        preg_match_all('/<span class="span2">(.*?)<\/span>/ism',$html,$timeHtml);
        $ptime = $timeHtml[1][0];
        $time = strtotime($ptime);
        $model = M('news');
        $exist = $model -> where("title = '{$title}'")->find();
        if(!$exist)
        {//添加数据
            $insert = $model ->add(array('title'=>$title,'ptime'=>$time,'content'=>$content,'url'=>$url,'addtime'=>time(),'source'=>'四川人大网','tags'=>$tag,'area'=>'四川'));
            if($insert)
            {
                $arr['success'] = $title;
            }
            else
            {
                preg_match_all('/<div class=TRS_Editor>(.*?)<\/div>/ism',$html,$contentHtml);
                $content = $contentHtml[1][0];
                /**内容图片处理**/
                $imgUrl = substr($url,0,strrpos($url,'/'));
                preg_match_all("/\<[img].*?src\=\"(.*?)\"[^>]*>/i", $content, $match);
                if($match)
                {
                    foreach($match[1] as $val)
                    {
                        $content = str_replace($val,$imgUrl.substr($val,1),$content);
                    }
                }
                $insert = $model ->add(array('title'=>$title,'ptime'=>$time,'content'=>$content,'url'=>$url,'addtime'=>time(),'source'=>'四川人大网','tags'=>$tag,'area'=>'四川'));

                if($insert)
                {
                    $arr['success'] = $title;
                }
                else {
                    $arr['fail'] = $title;
                }
            }
            return $arr;
        }
    }
}

