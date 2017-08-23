<?php
require_once('simple_html_dom.php');
/**
*   
*/
class Class_Curl_Html {
  public  $u = 'UTF-8';
  public  $http = '';
  public  $sql = '';
  public  $author;
  public  $d;
  public  $timeout;
  public  $news_top;
  public  $mid;
  public  $news_bo;
  public  $content = array();
  public  $resa = array();//存储数据集合
      // public $dadalist = array();//存储数据集合
  protected  $ua = 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.158888800.95 Safari/537.36 SE 2.X MetaSr 1.0';
  protected  $cookiejar = 'cookie.txt';
  protected  $tcookiefile = 'cookie.txt';




      function __construct() {
          list($t1, $t2) = explode(' ', microtime());
          $this->getMillisecond = $t2 . '' .  ceil( ($t1 * 1000) );
          return ;
      }

      protected function encode_mb($rst){ 
        $encode = mb_detect_encoding($rst, array('GBK','UTF-8','ASCII','GB2312','BIG5') ); 
        if($encode !== 'UTF-8'){
              // $day_html = mb_convert_encoding($day_html,'UTF-8','GBK');
          $rst = mb_convert_encoding($rst, $this->u, $encode);
              // $rst = mb_convert_encoding($rst, 'UTF-8');
        }

        return $rst;
      }

      public function http_url($rst){
          if($rst) {
              // if (!preg_match('/^(\/\/)|^(http)/i', $rst)) {
                if (!preg_match('/(^\/\/|^http)/i', $rst)) {
                  $rst = $this->http.$rst;  //  没有就加上 'http'
              }
              return $rst;
          }
      }


            /**
      *  多线程 抓取 数据
      */
      protected function multigeturlhtml($urls,$post= array(),$flag=''){
       
        $mh = curl_multi_init();
        foreach ($urls as $i => $url) {
         
          $ch[$i] = curl_init($url);
          curl_setopt($ch[$i],CURLOPT_SSL_VERIFYPEER,FALSE);
          curl_setopt($ch[$i],CURLOPT_SSL_VERIFYHOST,FALSE);
          curl_setopt($ch[$i],CURLOPT_URL,$url);
              // curl_setopt($ch,CURLOPT_URL,'cbigame.com/news');
          curl_setopt($ch[$i],CURLOPT_HEADER,0);
          curl_setopt($ch[$i],CURLOPT_RETURNTRANSFER,1);
          curl_setopt($ch[$i],CURLOPT_FOLLOWLOCATION,1);
              // curl_setopt($ch,CURLOPT_HTTPPROXYTUNNEL,1);
          curl_setopt($ch[$i],CURLOPT_ENCODING,"");

          if(isset($post) && !empty($post) ){
            curl_setopt($ch,CURLOPT_POST,1);
            
            if( is_array($post[$i]))
                      curl_setopt($ch[$i],CURLOPT_POSTFIELDS,http_build_query($post[$i])); // 要提交的信息
                    else
                      curl_setopt($ch[$i],CURLOPT_POSTFIELDS,$post[$i]); // 要提交的信息

                  }
                  
                  curl_multi_add_handle($mh, $ch[$i]);

                }

                do{
                  curl_multi_exec($mh,$active);
                }while($active);

                foreach ($urls as $i => $url) {
                 $data[$i] = curl_multi_getcontent($ch[$i]); // 获取爬取得代码字符串

                 curl_multi_remove_handle($mh,$ch[$i]);
                 curl_close($ch[$i]);
               }

              curl_multi_close($mh);  //  关闭多线程
              // return $day_html;
            }





/**
*  单线程 抓取
*/
 public function geturlHtml($url,$first,$post,$flag='',$timeoutms='',$cookisstring=''){
  $ch = curl_init();
  curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
  curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,FALSE);
  curl_setopt($ch,CURLOPT_URL,$url);
  curl_setopt($ch,CURLOPT_HEADER,0);
  curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
  curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
        // curl_setopt($ch,CURLOPT_HTTPPROXYTUNNEL,1);
  curl_setopt($ch,CURLOPT_ENCODING,"");

  if(!empty($timeoutms)){
                curl_setopt($ch,CURLOPT_TIMEOUT_MS,$timeoutms); //  10秒未响应就断开连接
              }
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.130 Safari/537.36');//模拟浏览器 
            curl_setopt($ch,CURLOPT_USERAGENT,$_SERVER["HTTP_USER_AGENT"]);  // $ua $_SERVER["HTTP_USER_AGENT"]  $defined_vars['HTTP_USER_AGENT']

              if($first==1){
                curl_setopt($ch,CURLOPT_COOKIEJAR,$this->cookiejar);
              }else if($first==2){
                curl_setopt($ch,CURLOPT_COOKIEJAR,$this->cookiejar);
                curl_setopt($ch,CURLOPT_COOKIEFILE,$this->tcookiefile);
              }else{
                curl_setopt($ch,CURLOPT_COOKIEFILE,$this->tcookiefile);
              }

              if(!empty($post)){
                curl_setopt($ch,CURLOPT_POST,1);
                if(is_array($post))
                    curl_setopt($ch,CURLOPT_POSTFIELDS,http_build_query($post)); // 要提交的信息
                  else
                    curl_setopt($ch,CURLOPT_POSTFIELDS,$post); // 要提交的信息
                }

            $day_html=curl_exec($ch);  // 执行cURL抓取页面内容
            curl_close($ch);
            // $this->dadalist = $day_html;
            return $day_html;
          }

 /***
*    数据库 处理
*
*/
public function article_sql(){
    set_time_limit(0); //  链接无时间限制
    $content = $this->news_content;
    // echo $content;
    $title = $content['title'];
    // $author = $content['author'];       
    $author = $this->author;
    $mid = $this->mid;
    $cent = $this->news_top.$content['content'].$this->news_bo;
    $tag = $content['tag'];
    $url = $content['url'];
    $lead = '';
    $tion = '';
    $time = time();
    $comment = $content['comment'];
    if($content['lead'] ){
      $lead = ',a1';
      $tion = ",'".$content['lead']."'";
    }else if($content['introduction']){
      $lead = ',a1';
      $tion = ",'".$content['introduction']."'";
    }
    $cent = str_replace("'","\'",$cent);
    $gi = $this->title_sql($title);
    $d = $this->d;
    echo $gi.'-';
   if( $gi == 'ok' && mb_strlen($comment)>10){
    $sql="insert into news_b(a,b,k,m,c,p,mid,t $lead,d) values('$title','$cent','$tag','$author','$url','$comment','$mid','$time $tion','$d') ";
    $res=pdo($sql);
    if($res){
        $news['k'] = '1';
        $news['id'] = $res;
        $news['title'] = $title;
        $news['a'] = $author;
        $news['t'] = $time;
        $news['ti'] = date('Y-m-d H:s:i',$time);
      }else{
        $news['info'] = 'null';
      }
    }else{
      // $sql = "select id,a,t,m from news_b where a = '$title' limit 1";
      // $data=pdo($sql)[0];
      // $news['k'] = '2'; //  已有了
      // $news['id'] = $data[0];
      // $news['title'] = $data[1];
      // $news['a'] = $data[3];
      // $news['t'] = $data[2];
      // $news['ti'] = date('Y-m-d H:s:i',$data[2]);
    }
      return $news;
}

public function title_sql($title){
    set_time_limit(0); //  链接无时间限制
  
    $sql = "select id,a,t,m from news_b where a = '$title' limit 1";
    // echo $sql;
    $data=pdo($sql)[0];
    $el = empty($data[0])? 'ok' : 'off';
   
    return $el;
    
  }


/**
*   以下是数据得获取 处理
*
*/
    /***
     *      以下是 http://toutiao.com/  今日头条网站的处理   链接
     *
     */

    /***
     *       http://toutiao.com/  评论 时间得处理
     *
     */
    public function getMillisecond() {
        list($t1, $t2) = explode(' ', microtime());
        $this->timeout = $t2 . '' .  ceil( ($t1 * 1000) );
        return ;
    }



    /**
     *      获取新闻 所以 得 url 链接 处理
     *
     */
    public function ngacn_url($url){
        set_time_limit(0); //  链接无时间限制
        $this->get_author($url);
        $day_html=$this->geturlHtml($url,2,'');

        $day_html=$this->encode_mb($day_html);

        $html = new simple_html_dom();  //  解析 方式二
        $html->load($day_html);
        foreach ( $html->find('#m_threads #topicrows .topicrow') as $k => $valu) {
            $content = $valu->find('.c2 a',0)->plaintext;
            $tit = $this->title_sql($content);
            if($tit == 'off'){continue ;}
            $red[$k]['content'] = $content;

            // $red[$k]['href'] = $this->http.trim($valu->find('.c2 a',0)->href);   //  测试用
            // echo  $red[$k]['href'];
            $href = $this->http.$valu->find('.c2 a',0)->href.'&_ff=7';
            // $this->author = trim($valu->find('.c3 .author',0)->plaintext); // 作者 获取
            //echo $href;
            // $href  = 'http://bbs.ngacn.cc/'.$href;
            
            $coent[] = $this->ngacn_news($href);
            // if($k == 4){ break ;}  //  测试用 只循环5个
        }

        unset($red);
        return $coent;
    }

    /**
     *     获取 新闻 页面得评论 处理，所以得 根据分页 来获取 url
     */
    public function ngacn_coemmt($url){
        set_time_limit(0); //  链接无时间限制

        $com = $this->count_;
        $num = ceil($com);
        $b = '';
        for($i=1;$i<=$num;$i++){

            $coms = $url.'&page='.$i;
            $day_html=$this->geturlHtml($coms,2,'');

            $day_html=$this->encode_mb($day_html);
            $html = new simple_html_dom();  //  解析 方式二
            $html->load($day_html);
////////////////////////
            $et = $html->find('#m_posts_c .forumbox',0);
            if( empty($et) ){continue ;}
            foreach ($html->find('#m_posts_c .forumbox') as $k => $value) {

                $cv = $value->find(".c2 .postcontent",0)->plaintext;//innertext;
                if( $k==1 ){

                }elseif( $k > 1 ){
                  // $cv = "[b]Reply to [pid=193009249,9828908,1]Reply[/pid] Post by [uid=40931]蹦豆[/uid] (2016-08-30 10:08)[/b]<br/><br/>这样还不错，要是投er444----";

                $pr = preg_replace("/\[[b]\]Reply(.*?)\W*\/uid(.*?)\d{4}-\d{1,2}-\d{1,2} \d{1,2}:\d{1,2}:?\d{0,2}(.*?)\/b\]/i", '', $cv);
                // echo $pr;
                    // $pr = preg_replace("/\w*[a-zA-Z0-9]{1,}\b[\s\:]*/i", '', $cv);
                    $pr = preg_replace("/[\[]{1}(.*?)[\]]{1}/","",$pr);
                    $pr = preg_replace("/\(\d{4}-\d{1,2}-\d{1,2} \d{1,2}:\d{1,2}:?\d{0,2}\)?/i", '', $pr);
                    $pr = preg_replace("/\w*[a-zA-Z0-9]{1,}\b[\s\:]*/i", '', $pr);
                    $pr = preg_replace("/[\/\\\.\-]/",'',$pr);
                    if( mb_strlen($pr,'utf-8') > 5 ){
                        $b.= trim($pr).'\n';
                        unset($pr);
                    }else{
                        continue ;
                    }

                }
            }

/////////////////////////////

        }
        return trim($b,'\n');
    }

    /**
     *      获取新闻数据 及 评论
     *
     */
    public function ngacn_news($url){

        set_time_limit(0); //  链接无时间限制
        $day_html=$this->geturlHtml($url,2,'');
        
        $day_html=$this->encode_mb($day_html);
        $html = new simple_html_dom();  //  解析 方式二
        $html->load($day_html);
        // echo $day_html;
        $et = $html->find('#post1strow0 .c2',0);
        if(empty($et)){return false;}

        $red['title'] = $et->find('h3#postsubject0', 0)->plaintext;

        $tit = $this->title_sql($red['title']);
        if ($tit == 'off') {
            return false;
        }

        $content = $et->find('#postcontent0', 0)->outertext;

        // $ace = "/([=]+)([\x{4e00}-\x{9fa5}]+\(?[\x{4e00}-\x{9fa5}]+\)?)([=]+)/u";
        $ace = "/([=]{2,})(.*?)([=]{2,})/is";
        $ace2 = "/(\[img\]\.){1}(.*?)(\[{1}\/{1}img{1}\]{1})/u";
        // preg_match_all($ace2,$content,$arr);
        $content = preg_replace($ace, "<h4> $2 </h4>", $content);
        $content = preg_replace($ace2, "<img src='http://img.ngacn.cc/attachments$2 '>", $content);
        $content = str_replace('postcontent','',$content);
        $content = str_replace('postcontent0','',$content);
        $red['content'] = preg_replace("/[\[]{1}(.*?)[\]]{1}/", "<$1>", $content); // (\/?\w{1,5})
        if (mb_strlen($red['content'], 'utf-8') < 140) {
            return false;
        }

        $com = $html->find('#m_pbtntop  .left script', 0)->innertext;
        $com = preg_replace("/(.*?)([\{]{1})(.*?)/", "$2$3", $com);

        $comp = preg_replace("/(\d{1})(\:{1})/", "\"$1\"$2", preg_replace("/(\'{1})/", "\"", $com));

        $contents2 = json_decode($comp);
        $cont = json_decode(json_encode($contents2), true);

        if ($cont[1] > 1) {

            $this->count_ = $cont[1];
            $mm = $this->ngacn_coemmt($url);
            $comment = $mm;
            unset($mm);

        }

        $red['comment'] = trim($comment, '\n');
        // $red['author'] = $this->author;
        $red['url'] = $url;
        unset($comment);
        $this->news_content = $red;
        $reds = $this->article_sql();
        // $reds['c'] = $red['title'];
        unset($red);
        return $reds;
    }
    //****************************************baidutieba
    public function get_url($url){
        $this->get_author($url);
        $day_html = $this->geturlHtml($url,2,'');
        $preg = "/<script[\s\S]*?<\/script>/i";
        $newstr = preg_replace($preg,"",$day_html); 
        $newstr = str_replace('<--','',$newstr);
        $newstr = str_replace('-->','',$newstr);
        // echo $newstr;
        preg_match_all('/<li class=" j_thread_list.*?".*?>.*?<\/li>/ism',$newstr,$pattern);
        // print_r($pattern[0]);
        // exit();
        foreach($pattern[0] as $v){
            preg_match_all('/<a[^>]+>[^>]+a>/',$v,$out);
            // print_r($out);
            foreach($out[0] as $v1){
                if(preg_match('/<a href="\/p.*?".*?>.*?<\/a>/ism',$v1)){
                    preg_match_all('/<a href="(\/p.*?)".*?>.*?<\/a>/ism',$v,$a);
                    $b = 'http://tieba.baidu.com'.$a[1][0];
                    $u[] = $b;
                }
            }    
        }
        return $u;
    }
    public function get_author($url){
        $sql = "select m,mid,d from url_b where url = '$url' ";
        $m = pdo($sql)[0];
        $this->author = $m[0];
        $this->mid = $m[1];
        $this->d = $m[2];
    }
    public function get_content($url){//baidu
        $res = array();        
        set_time_limit(0);
        $day_html=$this->geturlHtml($url,2,'');
        preg_match_all('/<title>(.*?)<\/title>/ism',$day_html,$a);
        if($this->title_exist($a[1][0])){
            $title = $a[1][0];

            preg_match_all('/<cc>(.*?)<\/cc>/',$day_html,$cc);
            if(mb_strlen($cc[0][0],'utf8') > 10 ){
            foreach($cc[0] as$k=>$v){                
                if($k==0){
                    $content = $v;
                }else{                  
                  $str = strip_tags($v);
                  $comment .='\n'.$str;                  
                }
            }
            
            if(mb_strlen(strip_tags($content),'utf8')>100 && mb_strlen($comment,'utf8')>0){
            $author = $this->author;
            $mid = $this->mid;
            $d = $this->d;
            $sql = "insert into news_b(mid,a,b,c,m,p,s,t,d)values('$mid','$title','$content','$url','$author','$comment','1',".time().",'$d')";
            // echo $sql;
            $id = pdo($sql);
            return $id;
          }
        }
    }
  }
    ////baidu
    public function title_exist($title){
        $sql = "select id from news_b where a = '$title' limit 1";
        $e = pdo($sql);
        if($e){
            return false;
        }else{
            return true;
        }
    }
    public function baidu_url($url){
        //获取列表url
        $this->get_author($url);
        $list_url = $this->get_url($url);
        //获取文章->保存
        foreach($list_url as $v){
            $msg[] = $this->get_content($v);
        }
        return $msg;
    }
    //*******************************zhihu
    function get_url_list($url){//获取最新消息 ulr list
      $day_html=$this->geturlHtml($url,2,'');
      $preg = "/<script[\s\S]*?<\/script>/i";
        $day_html = preg_replace($preg,"",$day_html); 
        if(strpos($url,'topic')){
            preg_match_all('/<div class="feed-item feed-item-hook  folding".*?>.*<\/div>/ism',$day_html,$pat);
              preg_match_all('/<link itemprop="url" href="(.*?)">/ism',$pat[0][0],$pa);

              // print_r($pa);
              foreach($pa[1] as $v){
                if(!preg_match('/^http/i',$v)){
                  $u[] ='https://www.zhihu.com'.$v;
                }else{
                  $u[] = $v;
                }
              }
              preg_match_all('/<a target=\'_blank\' class="post-link" href="(.*?)".*?>(.*?)<\/a>/ism',$pa[0][0],$p);
              foreach($p[1] as $v){
                if(!preg_match('/^http/i',$v)){
                  $u[] = 'https://www.zhihu.com'.$v;
                }else{
                  $u[] = $v;
                }                
            }

            preg_match_all('/<a class="question_link" href="(.*?)".*?>.*?<\/a>/ism',$day_html,$q);
            // print_r($q);
            foreach($q[1] as $v){
              if(!preg_match('/^http/i',$v)){
                $u[] = 'https://www.zhihu.com'.$v;
              }else{
                $u[] = $v;
              }
            }

          $u = array_unique($u);
      }else{
            preg_match_all('/<div class="zm-profile-section-wrap".*?>.*<\/div>/ism',$day_html,$pat);
            // echo $str;//--------------问答url
            preg_match_all('/<div class="zm-profile-section-wrap" id="zh-profile-activity-wrap">.*<\/div>/ism',$day_html,$pa);//最新动态
            preg_match_all('/<a class="question_link" href="(.*?)".*?>(.*?)<\/a>/ism',$pa[0][0],$pat);
            foreach($pat[1] as $v){
              if(!preg_match('/^http/i',$v)){
                $u[] ='https://www.zhihu.com'.$v;
              }else{
                $u[] = $v;
              }
            }
            preg_match_all('/<a target=\'_blank\' class="post-link" href="(.*?)".*?>(.*?)<\/a>/ism',$pa[0][0],$p);
            foreach($p[1] as $v){
              if(!preg_match('/^http/i',$v)){
                $u[] = 'https://www.zhihu.com'.$v;
              }else{
                $u[] = $v;
              }
            }
      }
      return $u;
    }
   
    function get_con_zhihu($url){
        set_time_limit(0); //  链接无时间限制
          if(!strpos($url,'zhuanlan'))
            {
              //################################      
                $day_html=$this->geturlHtml($url,2,'');
                $preg = "/<script[\s\S]*?<\/script>/i";
                $day_html = preg_replace($preg,"",$day_html); 
                $preg = "/<noscript[\s\S]*?<\/noscript>/i";
                $day_html = preg_replace($preg,"",$day_html); 
                preg_match_all('/<title>(.*?)<\/title>/ism',$day_html,$a);//title
                $title = $a[1][0];///title
                if($this->title_exist($title)){ 
                preg_match_all('/<div class="zu-main-content-inner">.*<div class="zu-main-sidebar"/ism',$day_html,$pattern);//content 部分
                // echo '<pre>';
                // print_r($pattern);
                $contenthtml = $pattern[0][0];
                // echo $contenthtml;
                preg_match_all('/<div class="zm-editable-content">(.*?)<\/div>/ism',$contenthtml,$c);//conent
                // print_r($c);
                $content = $c[1][0];//content
                preg_match_all('/<div class="zm-editable-content.*?>(.*?)<\/div>/ism',$day_html,$commenthtml);//commenthtml--
                // echo '<pre>';
                preg_match_all('/<textarea hidden class="content">(.*?)<\/textarea>/ism',$day_html,$commenthtml_);//commenthtml--显示全部
                // print_r($commenthtml_);//完整的评论内容：排除显示全部
                if($commenthtml_[0]){
                    foreach ($commenthtml_[1] as $val) {
                        $comment[] = $val;
                    }
                }                  
                if($commenthtml[0]){
                  foreach($commenthtml[0] as $k=>$v1){
                      $v1 = htmlspecialchars_decode($v1);
                        preg_match_all('/<img.*?data-actualsrc="(.*?)">/ism',$v1,$p);
                        if($p[0]){
                          for($i=0;$i<count($p[0]);$i++){
                             $v1 = str_replace($p[0][$i],'<img src="'.$p[1][$i].'"/>',$v1);
                          }
                        }
                        // $p='';
                        preg_match_all('/<img src="(.*?)".*?>/ism',$v1,$p1);
                        // print_r($p);
                        if($p1[0]){
                          for($i=0;$i<count($p1[0]);$i++){
                             $v1 = str_replace($p1[0][$i],'<img src="'.$p1[1][$i].'"/>',$v1);
                          }
                        }
                        $content .= $v1;
                  }
                }
                $author = $this->author;
                $mid = $this->mid;
                $d = $this->d;
                $content = str_replace("'","\'",$content);
                ////comment
                preg_match_all('/<meta itemprop="answer-id" content="(.*?)">/',$day_html,$comid);
                $arr = $comid[1];
                if(count($arr)>0){
                  foreach($arr as $v){
                    $com .= $this->get_zhihu_comment($v);
                  }
                }
                ////
                $sql = "insert into news_b(mid,a,b,c,m,p,s,t,d)values('$mid','$title','$content','$url','$author','$com','1',".time().",'$d')";
                $id = pdo($sql);
              //################################
            }
            return $id;
          }
        }
    function get_zhihu_comment($id,$p=1){
       set_time_limit(0); //  链接无时间限制  
        $url = 'https://www.zhihu.com/r/answers/'.$id.'/comments?page='.$p;
        $com = $this->geturlHtml($url,2,'');
        // print_r(json_decode($com,true));
        $coms = json_decode($com,true);
        $total = $coms['paging']['totalCount'];
        $currentPage = $coms['paging']['currentPage'];
        $perPage = $coms['paging']['perPage'];
        $pageCount = $total / $perPage;
        $data = $coms['data'];
        if(count($data)>0){
            foreach($data as $v){
                $comments .= strip_tags($v['content']).'\n';
            }    
        }
        if($pageCount > $currentPage){
            $p++;
            $comments .= $this->get_zhihu_comment($id,$p);
        }
        return $comments;
    }
    public function zhihu_url($url){
       set_time_limit(0); //  链接无时间限制  
      if(strpos($url,'question')){
        $id[] = $this->get_con_zhihu($url);
      }else{
          $urls = $this->get_url_list($url);
          $this->get_author($url);
          if(is_array($urls)){
           foreach ($urls as $v) {
                 $id[] = $this->get_con_zhihu($v);
               }           
            }
          return $id; 
    }}
      //######################163.bbs
      function get_163_list($url){   
          set_time_limit(0); //  链接无时间限制  
          $day_html=$this->geturlHtml($url,2,'');
          $preg = "/<script[\s\S]*?<\/script>/i";
          $day_html = preg_replace($preg,"",$day_html); 
          $preg = "/<noscript[\s\S]*?<\/noscript>/i";
          $day_html = preg_replace($preg,"",$day_html); 
          $html = new simple_html_dom();  //  解析 方式二
          $html->load($day_html);
          // echo '<pre>';
          preg_match_all('/<tbody.*?>.*?<\/em> <a href="(.*?)".*?>.*?<\/a>.*?<\/tbody>/',$html,$pattern);
          foreach($pattern[1] as $v){
            $u = 'http://bbs.d.163.com/'.$v;
            $arr[] = html_entity_decode($u);
          }
          return $arr;
        }
        function get_cont_163($url){    
          set_time_limit(0); //  链接无时间限制
            $day_html=$this->geturlHtml($url,2,'');
            $day_html=$this->encode_mb($day_html);
            $preg = "/<script[\s\S]*?<\/script>/i";
            $day_html = preg_replace($preg,"",$day_html); 
            $preg = "/<noscript[\s\S]*?<\/noscript>/i";
            $day_html = preg_replace($preg,"",$day_html); 
            preg_match_all('/<h1 class="ts">(.*?)<\/h1>/ism', $day_html,$tt);
            foreach($tt[1] as $v){
              preg_match_all('/<a.*?>(.*?)<\/a>/ism', $v,$t);
              // print_r($t);
              $title = $t[1][0].$t[1][1];
            }
            if($this->title_exist($title))
            {
              preg_match_all('/<div class="z">(.*?)<\/div>/ism',$day_html,$tag);
              preg_match_all('/<\/em> <a.*?>(.*?)<\/a>/',$tag[1][0],$tg);
              // print_r($tg);
              foreach($tg[1] as $k=>$v){
                if($k==0||$k==1){
                  $tags .= ','.$v;
                }
              }
              $tags = substr($tags, 1);
              preg_match_all('/<td class="t_f".*?>.*?<\/td>/ism',$day_html,$cont);  
              foreach($cont[0] as $k=>$v){
                if($k==0){
                  $v = $day_html = preg_replace('/<i[\s\S]*?<\/i>/ism',"",$v);
                  $content = $v;
                }else{
                  $v = $day_html = preg_replace('/<i[\s\S]*?<\/i>/ism',"",$v);
                  $v =  strip_tags($v);
                  $comment .= $v.'\n';
                }
              }
              if(mb_strlen(strip_tags($content),'utf8')>100 && mb_strlen($comment,'utf8')>0){
                $author = $this->author;
                $mid = $this->mid;
                $d = $this->d;
                $sql = "insert into news_b(mid,a,b,c,m,p,s,t,k,d)values('$mid','$title','$content','$url','$author','$comment','1',".time().",'$tags','$d')";
                          // echo $sql;
                $id = pdo($sql);
                return $id;
              }
            }
        }
      public  function  bbs163_url($url){
            $urls = $this->get_163_list($url);
            // print_r($urls);
            foreach($urls as $v){
              $id[] = $this->get_cont_163($v);
            }
            return $id;
        }
         //#############play.163.com
       public  function get_play163_list($url){
            set_time_limit(0); //  链接无时间限制
            $day_html=$this->geturlHtml($url,2,'');
            $day_html=$this->encode_mb($day_html);
            preg_match_all('/<div class="article-item".*?>.*?<\/div>/ism',$day_html,$pa);
            foreach($pa[0] as $v){
              preg_match_all('/<a href="(.*?)">/',$v,$u);
              $arr[] = $u[1][0];
            }
            return $arr;
          }
      public  function paly163_cont($url){  
              set_time_limit(0); //  链接无时间限制      
              $day_html=$this->geturlHtml($url,2,'');
              $day_html=$this->encode_mb($day_html);
              $preg = "/<script[\s\S]*?<\/script>/i";
              $day_html = preg_replace($preg,"",$day_html); 
              $preg = "/<noscript[\s\S]*?<\/noscript>/i";
              $day_html = preg_replace($preg,"",$day_html); 
              preg_match_all('/<h1.*?>.*?<\/h1>/',$day_html,$h);
              $title = strip_tags($h[0][0]); 
              if($this->title_exist($title)){
              preg_match_all('/<div id="endText".*?>.*?<\/div>/ism',$day_html,$con);
              $content = $con[0][0];
              // echo $day_html;
              preg_match_all('/<div class="tie-newest".*?>.*?<\/div>/ism',$day_html,$com);//获取不到评论
              preg_match_all('/<div class="location">.*?<\/div>/ism', $day_html, $t);
              if($t[0]){
                preg_match_all('/<a.*?>(.*?)<\/a>/ism', $t[0][0],$tags);
                $tag = $tags[1][1];
              }
              $author = $this->author;
              $mid = $this->mid;
              $d = $this->d;
              $sql = "insert into news_b(mid,a,b,c,m,p,s,t,k,d)values('$mid','$title','$content','$url','$author','','1',".time().",'$tag','$d')";//没有评论
              $id = pdo($sql);
              return $id;
                }
            }
     public  function play163_url($url){
          $arr = $this->get_play163_list($url);
          foreach($arr as $v)
          {
             if(strpos($v,'bbs.d.163.com'))
             {
                $id[] = $this->get_cont_163($v);
             }else{
                $id[] = $this->paly163_cont($v);
             }
          }
          return $id;
      }
      //#################gg.163.com
      function get_gg163_list($url){
        set_time_limit(0);
          $page_html=$this->geturlHtml($url,2,'');
          $page_html=$this->encode_mb($page_html);
          preg_match_all('/<div class="m-collist".*?>.*?<\/div>/ism',$page_html,$page);
          foreach($page[0] as $v){
            preg_match_all('/<a href="(.*?)".*>/',$v,$u);
            $list[] = $u[1][0];
          }
          return $list;
        }
        function get_gg163_cont($url){
          set_time_limit(0);
          $page_html=$this->geturlHtml($url,2,'');
          $page_html=$this->encode_mb($page_html);
          preg_match_all('/<h1.*?>.*?<\/h1>/',$page_html,$h);
            $title = strip_tags($h[0][0]); 
            if($this->title_exist($title)){
          preg_match_all('/<div id="endText".*?>.*?<\/div>/ism',$page_html,$con);
            $content = $con[0][0];
            $author = $this->author;
            $mid = $this->mid;
            $d = $this->d;
            $sql = "insert into news_b(mid,a,b,c,m,p,s,t,k,d)values('$mid','$title','$content','$url','$author','','1',".time().",'$tag','$d')";//没有评论
            $id = pdo($sql);
            return $id;
          }
        }
        function gg163_url($url){
          $list = $this->get_gg163_list($url);
          foreach($list as $v){
            $id[] = $this->get_gg163_cont($v);
          }
          return $id;
        }
        //################bbs.hupu.com
        function get_hupu_list($url){
            $day_html = $this->geturlHtml($url,2,'');
            $day_html = $this->encode_mb($day_html);
            preg_match_all('/<tr mid=".*?">.*?<\/tr>/ism',$day_html,$pa);
            foreach($pa[0] as $v){
              preg_match_all('/<a id="" href="(.*?)">.*?<\/a>/ism',$v,$u);
              $arr[] = 'http://bbs.hupu.com'.$u[1][0];
            }
            return $arr;
          }
        function get_hupu_cont($url){
            set_time_limit(0);
            $day_html = $this->geturlHtml($url,2,'');
            $day_html = $this->encode_mb($day_html);
            preg_match_all('/<h1.*?>(.*?)<\/h1>/ism',$day_html,$t);
            $title = $t[1][0];
            if($this->title_exist($title)){
            preg_match_all('/<table class="case".*?>.*?<\/table>/ism',$day_html,$page);
            foreach($page[0] as $k=>$v){
                if($k==0){
                  $v = preg_replace('/<small.*?>.*?<\/small>/ism','',$v);
                  $content = preg_replace('/<div class="subhead">.*?<\/div>/ism','',$v);
                }else{
                  $v = preg_replace('/<blockquote>.*?<\/blockquote>/ism','',$v);
                  $v = preg_replace('/<small.*?>.*?<\/small>/ism','',$v);
                  $comment .= strip_tags($v).'\n';
                }                
              }
            preg_match_all('/<img src="http:\/\/b1.hoopchina.com.cn\/web\/sns\/bbs\/images\/placeholder.png" data-original="(.*?)"\/>/ism',$content,$img);
            if($img[0])
            {
              for ($i=0; $i <count($img[0]); $i++) { 
                $content = str_replace($img[0][$i],'<img src="'.$img[1][$i].'">', $content);
                }
            }
            if(mb_strlen($content,'utf8')>50 && mb_strlen($comment,'utf8')>10){
                  $author = $this->author;
                  $mid = $this->mid;
                  $d = $this->d;
                  $sql = "insert into news_b(mid,a,b,c,m,p,s,t,k,d)values('$mid','$title','$content','$url','$author','$comment','1',".time().",'','$d')";
                    $id = pdo($sql);
                    return $id;
                }
            }
          }
          function hupu_url($url){
              $this->get_author($url); 
              $list = $this->get_hupu_list($url);
              foreach($list as $v){
                $id[] = $this->get_hupu_cont($v);
              }
              return $id;
          }
          //############agamer
          function get_sgamer_list($url){
                set_time_limit(0);
                $day_html = $this->geturlHtml($url,2,'');
                $preg = "/<noscript[\s\S]*?<\/noscript>/i";
                $day_html = preg_replace($preg,"",$day_html); 
                $day_html = $this->encode_mb($day_html);
                preg_match_all('/<tbody id=".*?">.*?<\/tbody>/ism',$day_html,$pa);
                foreach($pa[0] as $v){
                  preg_match_all('/<a href="(thread.*?)".*?>.*?<\/a>/',$v,$u);
                  if($u[1][0]){
                    $arr[] = 'http://bbs.sgamer.com/'.$u[1][0];
                  }
                }
                return $arr;
              }
              function get_sgamer_cont($url){ 
                set_time_limit(0);
                $day_html = $this->geturlHtml($url,2,'');
                $preg = "/<noscript[\s\S]*?<\/noscript>/i";
                $day_html = preg_replace($preg,"",$day_html); 
                $day_html = $this->encode_mb($day_html);
                preg_match_all('/<div class="z">.*?<\/div>/ism',$day_html,$t);
                preg_match_all('/<a.*?>(.*?)<\/a>/ism',$t[0][1], $tags);
                array_shift($tags[1]);
                array_shift($tags[1]);
                array_pop($tags[1]);
                foreach ($tags[1] as $v) {
                  $tag = ','.$v;
                }
                $tag = substr($tag,1);
                preg_match_all('/<span id="thread_subject">(.*?)<\/span>/',$day_html,$pa);
                $title = $pa[1][0];
                if($this->title_exist($title)){
                preg_match_all('/<td class="t_f".*?>(.*?)<\/td>/ism',$day_html,$con);
                  foreach($con[1] as $k=>$v){
                    if($k==0){
                        $v = preg_replace('/<i class="pstatus">.*?<\/i>/ism','',$v);
                        preg_match_all('/<img.*?file="(.*?)".*?>/',$v,$cc);
                        for ($i=0; $i <count($cc[0]) ; $i++) { 
                          $v = str_replace($cc[0][$i],'<img src="'.$cc[1][$i].'">',$v);
                        }
                        preg_match_all('/<img src="(static.*?)".*?>/',$v,$static);
                        for ($i=0; $i <count($static[0]) ; $i++) { 
                          $v = str_replace($static[0][$i],'<img src="http://bbs.sgamer.com/'.$static[1][$i].'">',$v);
                        }
                        $content = $v;
                    }else{      
                      $v = preg_replace('/<blockquote>.*?<\/blockquote>/ism','',$v);
                      $v = preg_replace('/<i class="pstatus">.*?<\/i>/ism','',$v);
                      $v = preg_replace('/<strong>.*?<\/strong>/ism','',$v);
                      $v = preg_replace('/<a onclick="return false".*?>.*?<\/a>/ism','',$v);
                      $v = strip_tags($v);
                      $comment .= $v.'\n';
                    }
                  }
                }
                if(mb_strlen(strip_tags($content),'utf8')>50 && mb_strlen($comment,'utf8')>10){
                      $author = $this->author;
                      $mid = $this->mid;
                      $d = $this->d;
                      $sql = "insert into news_b(mid,a,b,c,m,p,s,t,k,d)values('$mid','$title','$content','$url','$author','$comment','1',".time().",'$tag','$d')";
                        $id = pdo($sql);
                  }
                return $id;
              }
              function sgamer_url($url){                
                 $this->get_author($url); 
                    $list = $this->get_sgamer_list($url);
                    foreach($list as $v){
                      $id[] = $this->get_sgamer_cont($v);
                    }
                    return $id;
                }
                //#######################lol
                function get_lol_list($url){
                  set_time_limit(0);
                    $day_html = $this->geturlHtml($url,2,'');
                    $preg = "/<noscript[\s\S]*?<\/noscript>/i";
                    $day_html = preg_replace($preg,"",$day_html); 
                    $day_html = $this->encode_mb($day_html);
                   preg_match_all('/<th class=".*?">.*?<\/th>/ism',$day_html,$pa);
                    // print_r($pa);
                    foreach($pa[0] as $v){
                      preg_match_all('/<a href="(.*?)".*?>.*?<\/a>/ism', $v, $a);
                      $arr[] = 'http://bbs.lol.qq.com/'.htmlspecialchars_decode($a[1][0]);
                    }
                    return $arr;
                  }
                    function get_lol_cont($url)
                    {
                      set_time_limit(0);
                      $day_html = $this->geturlHtml($url,2,'');
                      $preg = "/<noscript[\s\S]*?<\/noscript>/i";
                      $day_html = preg_replace($preg,"",$day_html); 
                      $day_html = $this->encode_mb($day_html);
                      preg_match_all('/<h1 class="ts">(.*?)<\/h1>/ism',$day_html,$t);
                      $title = strip_tags($t[1][0]);
                      if($this->title_exist($title))
                      {
                      preg_match_all('/<td class="t_f" id=".*?">.*?<\/td>/ism',$day_html,$con);
                      foreach($con[0] as $k=>$v){
                        if($k==0){
                          preg_match_all('/<img.*?file="(.*?)".*?>/',$v,$cc);
                          for ($i=0; $i <count($cc[0]) ; $i++) { 
                            $v = str_replace($cc[0][$i],'<img src="'.$cc[1][$i].'">',$v);
                          }
                          $v = preg_replace('/<i class="pstatus">.*?<\/i>/ism','',$v);
                          $content = $v;
                        }else{
                          $v = preg_replace('/<blockquote>.*?<\/blockquote>/ism','',$v);
                          $v = preg_replace('/<strong>.*?<\/strong>/ism','',$v);
                          $v = strip_tags($v);
                          $comment .= $v.'\n';
                        }
                      }
                       if(mb_strlen(strip_tags($content),'utf8')>50 && mb_strlen($comment,'utf8')>10)
                       {
                         $author = $this->author;
                         $mid = $this->mid;
                         $d = $this->d;
                         $sql = "insert into news_b(mid,a,b,c,m,p,s,t,k,d)values('$mid','$title','$content','$url','$author','$comment','1',".time().",'','$d')";
                                  $id = pdo($sql);               
                       }
                       return $id;
                    }
                  }
                  function qq_url($url){//bbs.lol.qq.com
                    set_time_limit(0);
                      $this->get_author($url); 
                      $list = $this->get_lol_list($url);
                      foreach($list as $v){
                        $id[] = $this->get_lol_cont($v);
                      }
                      return $id;
                  }
  //#################toutiao
   function get_toutiao_url($url){
    set_time_limit(0);
      $html = $this->geturlHtml($url,2,'');
      $html = $this->encode_mb($html);
      preg_match_all('/<li class="article-item">.*?<\/li>/ism',$html,$page);
      foreach($page[0] as $v){
        preg_match_all('/<a class="title" href="(.*?)".*?>.*?<\/a>/ism', $v, $u);
        $arr[] = $u[1][0];
      }
      return $arr;
    }

    function get_toutiao_cont($url){
      set_time_limit(0);
      $html = $this->geturlHtml($url,2,'');
      $html = $this->encode_mb($html);
      preg_match_all('/<h1 class="article-title">(.*?)<\/h1>/ism',$html,$t);
      $title = $t[1][0];
       if($this->title_exist($title))
      {
      preg_match_all('/<div class="article-content">.*?<\/div>/ism',$html,$con);
      $content =str_replace('点击上方蓝色字体关注','',$con[0][0]);
      preg_match_all('/<ul class="label-list">.*?<\/ul>/ism',$html,$tag);
      preg_match_all('/<a.*?>.*?<\/a>/ism',$tag[0][0],$a);
      foreach($a[0] as $v){
        $tags .= ','.strip_tags($v);
      }
      $tags = substr($tags,1);
      ///////评论
      preg_match_all('/<link rel="alternate".*? href="(.*?)".*?\/>/ism',$html,$link);
      if($link[1]){//link 中 含有groupid
        $arr = explode('/',$link[1][0]);
        array_pop($arr);      
        $groupid = substr(array_pop($arr),1);
      }else{//link 中 无 groupid
            preg_match_all('/<script>.*?<\/script>/is',$html,$js);
            // print_r($js);
            foreach($js[0] as $v){
              if(strpos($v,'item_id')){
                $str = $v;
              }
            }
            echo $str;
            preg_match_all('/\{(.*?)\}/ism',$str,$id);
            print_r($id);
            $arr = explode(',',$id[1][0]);
            print_r($arr);
            foreach($arr as $v){
              if(strpos($v,'group_id')!==false){
                $group_id = substr($v,strpos($v,'group_id')+9);
              }
            }
            $groupid = str_replace("'",'',$group_id);
      }
      $brr = explode('/',$url);
      array_pop($brr);
      $item_id = substr(array_pop($brr),1);
      $comments = $this->get_toutiao_comment($groupid,$item_id);
    }
      ///////
      if(mb_strlen(strip_tags($content),'utf8')>100 ){

            $author = $this->author;
            $mid = $this->mid;
            $d = $this->d;
            $sql = "insert into news_b(mid,a,b,c,m,p,s,t,k,d)values('$mid','$title','$content','$url','$author','$comments','1',".time().",'$tags','$d')";
            $id = pdo($sql);
            return $id;
          }
        }   

    function toutiao_url($url){
      set_time_limit(0);
      $this->get_author($url); 
      $list = $this->get_toutiao_url($url);
       foreach($list as $v){
          $v = str_replace('tem/','',$v);
          $id[] = $this->get_toutiao_cont($v);
          }
        return $id;
    }
     function get_toutiao_comment($groupid,$item_id,$p=0){
        $comurl = 'http://www.toutiao.com/api/comment/list/?group_id='.$groupid.'&item_id='.$item_id.'&offset='.$p.'&count=5';
        set_time_limit(0);
        $comment = $this->geturlHtml($comurl,2,'');
        $cc = json_decode($comment,true);
        print_r($cc);
        if(count($cc['data'])>0){
           $comm = $cc['data'];
           $total = $comm['total'];
           foreach($comm['comments'] as $v){
            $comments .= $v['text'].'\n';
           }
         $page = ceil($total / 5);
        // echo $page;
        if($total >$p ){
          $p = $p+5;
          $comments .= $this->get_toutiao_comment($groupid,$item_id,$p);
        }
      }
      return $comments;
    }
}
//  ========================================================
/**   任务
*  http://toutiao.com/m5590938021/  
*  http://blog.sina.com.cn/
*  http://tieba.baidu.com/f?kw=%C2%B7%B9%FD%B5%C4%D2%BB%D6%BB
*
*  http://bbs.ngacn.cc/thread.php?fid=7
*
*/