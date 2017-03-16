<?php

include_once "WXBizMsgCrypt.php";

// 假设企业号在公众平台上设置的参数如下
$encodingAesKey = "4WGM6Jmxyqg05GXkKoNutpVSWGfRHKdwUoLzL6UeVyE";
$token = "hengdianworld";
$corpId = "wx6bb8b192d1dcfe19";

//verifyurl
$sVerifyMsgSig =$_GET["msg_signature"];
$sVerifyTimeStamp = $_GET["timestamp"];
$sVerifyNonce = $_GET["nonce"];
$sVerifyEchoStr =$_GET["echostr"] ;
 
$EchoStr = "";
 
 
$wxcpt = new WXBizMsgCrypt($token, $encodingAesKey, $corpId);
 
$errCode = $wxcpt->VerifyURL($sVerifyMsgSig, $sVerifyTimeStamp, $sVerifyNonce, $sVerifyEchoStr, $sEchoStr);
if ($errCode == 0) { 
echo $sEchoStr;
} else {
print($errCode . "\n\n");
}

//http://weix.hengdianworld.com/qyh/jp/index.php?msg_signature=1fae5f6df910cc3c31ec411d1e9b1dd4a6c37ac8&timestamp=1412917199&nonce=403680659&echostr=dI+YSBxiMkbl2Thcb3oGG4D2C/yWtf3AmSnexEpbYYI1gt494iMKX8eS11NAqX2VkxSg5Vj3FPpkAX9HyCwBcg==
?>

