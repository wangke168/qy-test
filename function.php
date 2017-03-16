<?
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

$url = "http://e.hengdianworld.com/searchorder_json.aspx?name=Anonymous&phone=".$tel;
$ch = curl_init();
curl_setopt ($ch, CURLOPT_URL, $url);
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT,10);
$json = curl_exec($ch);
$data = json_decode($json,true);
$ticketcount = count($data['ticketorder']);
$inclusivecount = count($data['inclusiveorder']);
$hotelcount = count($data['hotelorder']);


  	$i=0;
  	
  //    $str=$str."姓名：".$name."   电话：".$tel."\n";
	if ($ticketcount<>0)
    {
      $str="您好，该客人的预订信息如下\n注意，若是联票+梦幻谷的门票仍然需要身份证检票\n";
      	for ($j=0; $j<$ticketcount; $j++)
        {
          $i=$i+1;
          $str=$str."\n订单".$i;
          $str=$str."\n姓名：".$data['ticketorder'][$j]['name'];
          $str=$str."\n订单号:".$data['ticketorder'][$j]['sellid'];
          $str=$str."\n预达日期:".$data['ticketorder'][$j]['date2'];
          $str=$str."\n预购景点:".$data['ticketorder'][$j]['ticket'];
          $str=$str."\n人数:".$data['ticketorder'][$j]['numbers'];
          $str=$str."\n订单识别码:".$data['ticketorder'][$j]['code']."（在检票口出示此识别码可直接进入景区。）";
          $str=$str."\n订单状态:".$data['ticketorder'][$j]['flag']."\n";
        }
    }
  else
  {
    $str="该手机号下无门票订单";
  }
  $newsData= array(
	   	"0"=>array(
	  		'Title'=>'查询结果',
	 		'Description'=>$str,
//	   		'PicUrl'=>'http://qydev.weixin.qq.com/wiki/skins/common/images/weixin/weixin_wiki_logo.png',
	  		'Url'=>'http://www.domain.com/1.html'
	 			)
			);
return $newsData;
}
?>