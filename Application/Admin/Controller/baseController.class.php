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
class BaseController extends AdminController
{
    public $curl;
    public $dom;
    public function __construct()
    {
        include ('Class_Curl_Html.php');
        include ('simple_html_dom.php');
        $this->curl = new \Class_Curl_Html();
        $this->dom = new \simple_html_dom();
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


}