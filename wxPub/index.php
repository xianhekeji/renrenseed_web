<?php

/* -------------------------------------------------
  |   index.php [ 微信公众平台接口 ]
  +--------------------------------------------------
  |   Author: LimYoonPer
  +------------------------------------------------ */
$wechatObj = new wechat();
$wechatObj->responseMsg();

class wechat {

    public function responseMsg() {
        //---------- 接 收 数 据 ---------- //

        $input = file_get_contents("php://input"); //获取POST数据
        $postObj = simplexml_load_string($input, 'SimpleXMLElement', LIBXML_NOCDATA); //提取POST数据为simplexml对象
//
//        $postStr = $GLOBALS['HTTP_RAW_POST_DATA'];
//        //用SimpleXML解析POST过来的XML数据
//        $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
        $fromUsername = $postObj->FromUserName; //获取发送方帐号（OpenID）
        $toUsername = $postObj->ToUserName; //获取接收方账号
        $keyword = trim($postObj->Content); //获取消息内容
        $time = time(); //获取当前时间戳
        //---------- 返 回 数 据 ---------- //
        //返回消息模板
        $textTpl = "<xml>
  <ToUserName><![CDATA[%s]]></ToUserName>
  <FromUserName><![CDATA[%s]]></FromUserName>
  <CreateTime>%s</CreateTime>
  <MsgType><![CDATA[%s]]></MsgType>
  <Content><![CDATA[%s]]></Content>
  <FuncFlag>0</FuncFlag>
  </xml>";
        $msgType = "text"; //消息类型

        $contentStr = "人人种品种大全"; //返回消息内容
        //格式化消息模板
        $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
        echo $resultStr; //输出结果
    }

}

?>