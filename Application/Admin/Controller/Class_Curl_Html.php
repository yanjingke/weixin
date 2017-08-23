<?php
/**
*
*/
class Class_Curl_Html
{
    public $u = 'UTF-8';
    public $http = '';
    public $sql = '';
    public $author;
    public $d;
    public $timeout;
    public $news_top;
    public $mid;
    public $news_bo;
    public $content = array();
    public $resa = array();//存储数据集合
    // public $dadalist = array();//存储数据集合
    protected $ua = 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.158888800.95 Safari/537.36 SE 2.X MetaSr 1.0';
    protected $cookiejar = 'cookie.txt';
    protected $tcookiefile = 'cookie.txt';


    function __construct()
    {
        list($t1, $t2) = explode(' ', microtime());
        $this->getMillisecond = $t2 . '' . ceil(($t1 * 1000));
        return;
    }

    protected function encode_mb($rst)
    {
        $encode = mb_detect_encoding($rst, array('GBK', 'UTF-8', 'ASCII', 'GB2312', 'BIG5'));
        if ($encode !== 'UTF-8') {
            // $day_html = mb_convert_encoding($day_html,'UTF-8','GBK');
            $rst = mb_convert_encoding($rst, $this->u, $encode);
            // $rst = mb_convert_encoding($rst, 'UTF-8');
        }

        return $rst;
    }

    public function http_url($rst)
    {
        if ($rst) {
            // if (!preg_match('/^(\/\/)|^(http)/i', $rst)) {
            if (!preg_match('/(^\/\/|^http)/i', $rst)) {
                $rst = $this->http . $rst;  //  没有就加上 'http'
            }
            return $rst;
        }
    }


    /**
     *  多线程 抓取 数据
     */
    protected function multigeturlhtml($urls, $post = array(), $flag = '')
    {

        $mh = curl_multi_init();
        foreach ($urls as $i => $url) {

            $ch[$i] = curl_init($url);
            curl_setopt($ch[$i], CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch[$i], CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($ch[$i], CURLOPT_URL, $url);
            // curl_setopt($ch,CURLOPT_URL,'cbigame.com/news');
            curl_setopt($ch[$i], CURLOPT_HEADER, 0);
            curl_setopt($ch[$i], CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch[$i], CURLOPT_FOLLOWLOCATION, 1);
            // curl_setopt($ch,CURLOPT_HTTPPROXYTUNNEL,1);
            curl_setopt($ch[$i], CURLOPT_ENCODING, "");

            if (isset($post) && !empty($post)) {
                curl_setopt($ch, CURLOPT_POST, 1);

                if (is_array($post[$i]))
                    curl_setopt($ch[$i], CURLOPT_POSTFIELDS, http_build_query($post[$i])); // 要提交的信息
                else
                    curl_setopt($ch[$i], CURLOPT_POSTFIELDS, $post[$i]); // 要提交的信息

            }

            curl_multi_add_handle($mh, $ch[$i]);

        }

        do {
            curl_multi_exec($mh, $active);
        } while ($active);

        foreach ($urls as $i => $url) {
            $data[$i] = curl_multi_getcontent($ch[$i]); // 获取爬取得代码字符串

            curl_multi_remove_handle($mh, $ch[$i]);
            curl_close($ch[$i]);
        }

        curl_multi_close($mh);  //  关闭多线程
        // return $day_html;
    }


    /**
     *  单线程 抓取
     */
    public function geturlHtml($url, $first, $post, $flag = '', $timeoutms = '', $cookisstring = '')
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        // curl_setopt($ch,CURLOPT_HTTPPROXYTUNNEL,1);
        curl_setopt($ch, CURLOPT_ENCODING, "");

        if (!empty($timeoutms)) {
            curl_setopt($ch, CURLOPT_TIMEOUT_MS, $timeoutms); //  10秒未响应就断开连接
        }
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.130 Safari/537.36');//模拟浏览器
        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER["HTTP_USER_AGENT"]);  // $ua $_SERVER["HTTP_USER_AGENT"]  $defined_vars['HTTP_USER_AGENT']

        if ($first == 1) {
            curl_setopt($ch, CURLOPT_COOKIEJAR, $this->cookiejar);
        } else if ($first == 2) {
            curl_setopt($ch, CURLOPT_COOKIEJAR, $this->cookiejar);
            curl_setopt($ch, CURLOPT_COOKIEFILE, $this->tcookiefile);
        } else {
            curl_setopt($ch, CURLOPT_COOKIEFILE, $this->tcookiefile);
        }

        if (!empty($post)) {
            curl_setopt($ch, CURLOPT_POST, 1);
            if (is_array($post))
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post)); // 要提交的信息
            else
                curl_setopt($ch, CURLOPT_POSTFIELDS, $post); // 要提交的信息
        }

        $day_html = curl_exec($ch);  // 执行cURL抓取页面内容
        curl_close($ch);
        // $this->dadalist = $day_html;
        return $day_html;
    }
}

