<?php
include "qywechat.class.php";

function logg($text)
{
    file_put_contents('./log.txt', $text . "\r\n\r\n", FILE_APPEND);
}

var_dump(Check_tecket('13605725464'));

$options = array(
    'token' => 'jianpiao',    //填写应用接口的Token
    'encodingaeskey' => 'X5HFXA537wZkVwUicueeuPlsGgvgftDPdyv9pnNMaMp',//填写加密用的EncodingAESKey
    'appsecret' => 'Fh7r_eihHhtjjmgKh9k7HuVlGBj-sSNV0AU5Pu8Y0ng',
    'appid' => 'wwfb1970349326c73f',    //填写高级调用功能的appid
    'debug' => true,
    'logcallback' => 'logg'

);
logg("GET参数为：\n" . var_export($_GET, true));
$weObj = new Wechat($options);
$ret = $weObj->valid();
if (!$ret) {
    logg("验证失败！");
    var_dump($ret);
    exit;
}


$f = $weObj->getRev()->getRevFrom();    //获取发送者微信号
$t = $weObj->getRevType();                //获取发送的类型
$d = $weObj->getRevData();                //获取发送的data
$c = $weObj->getRevContent();            //获取发送的内容
$weObj->news(Check_tecket('13605725'))->reply();
//$weObj->text("你好！来自星星的：")->reply();
//logg("-----------------------------------------");


//检票口
function Check_tecket($tel)
{
    //    $url="http://e.hengdianworld.com/searchorder_json.aspx?name=Anonymous&phone=".$tel;
//	$json=file_get_contents("http://e.hengdianworld.com/searchorder_json.aspx?name=Anonymous&phone=".$tel);

    /*
        $json=http_request_json("http://e.hengdianworld.com/searchorder_json.aspx?name=Anonymous&phone=".$tel);
        $data = json_decode($json,true);
          $ticketcount = count($data['ticketorder']);
        $inclusivecount = count($data['inclusiveorder']);
        $hotelcount = count($data['hotelorder']);
    */

    $url = "http://10.0.61.201/searchorder_json.aspx?name=Anonymous&phone=" . $tel;

    /*$ch = curl_init();
    curl_setopt ($ch, CURLOPT_URL, $url);
    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT,10);*/
    $json = file_get_contents($url);
//$json = curl_exec($ch);

    $data = json_decode($json, true);
//	return $data;
    $ticketcount = count($data['ticketorder']);
    /*$inclusivecount = count($data['inclusiveorder']);
    $hotelcount = count($data['hotelorder']);*/


    $i = 0;

    //    $str=$str."姓名：".$name."   电话：".$tel."\n";
    if ($ticketcount <> 0) {
        $str = "您好，该客人的预订信息如下\n注意，若是联票+梦幻谷或者三点+梦幻谷的门票仍然需要身份证检票\n";
        for ($j = 0; $j < $ticketcount; $j++) {
            $i = $i + 1;
            $str = $str . "\n订单" . $i;
            $str = $str . "\n姓名：" . $data['ticketorder'][$j]['name'];
            $str = $str . "\n订单号:" . $data['ticketorder'][$j]['sellid'];
            $str = $str . "\n预达日期:" . $data['ticketorder'][$j]['date2'];
            $str = $str . "\n预购景点:" . $data['ticketorder'][$j]['ticket'];
            $str = $str . "\n人数:" . $data['ticketorder'][$j]['numbers'];
            /*	  if ($data['ticketorder'][$j]['ticket']=='三大点+梦幻谷' || $data['ticketorder'][$j]['ticket']=='网络联票+梦幻谷')
                  {
                     $str=$str."\n注意：该票种需要身份证检票";
                  }
                  else
                  {*/
            $str = $str . "\n订单识别码:" . $data['ticketorder'][$j]['code'] . "（在检票口出示此识别码可直接进入景区。）";
//		  }
            $str = $str . "\n订单状态:" . $data['ticketorder'][$j]['flag'] . "\n";
        }
    } else {
        $str = "该手机号下无门票订单";
    }
    $newsData = array(
        "0" => array(
            'Title' => '查询结果',
            'Description' => $str,
//	   		'PicUrl'=>'http://qydev.weixin.qq.com/wiki/skins/common/images/weixin/weixin_wiki_logo.png',
            'Url' => 'http://weix2.hengdianworld.com/article/articledetail.php?id=44'
        )
    );
//    return $newsData;
    return $str;
}

?>