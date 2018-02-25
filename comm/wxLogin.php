<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


require DT_ROOT . '/Class/UserClass.php';
$info = new UserClass();
if (isset($_GET['code']) && !isset($_SESSION['userinfo'])) {
    $code = $_GET['code'];
    $appid = 'wx64b9c6f2847a57c5';
    $secret = '1007480f392e17582f5343ccabcd4c1d';
    $grant_type = 'authorization_code';
    $access_token_url = 'https://api.weixin.qq.com/sns/oauth2/access_token';
    $access_token_url = sprintf("%s?appid=%s&secret=%s&code=%s&grant_type=%s", $access_token_url, $appid, $secret, $code, $grant_type);
    $weixin_user_data = json_decode(get_url($access_token_url));
    $access_token = $weixin_user_data->access_token;
    $open_id = $weixin_user_data->openid;
    $get_user_url = "https://api.weixin.qq.com/sns/userinfo";
    $get_user_url = sprintf("%s?access_token=%s&openid=%s", $get_user_url, $access_token, $open_id);
    $get_user_info = json_decode(get_url($get_user_url));
    $_SESSION['userinfo'] = json_encode($get_user_info);
    $aa = $get_user_info;
    //检测本地是否存在该用户
    if ($info->checkInfo($aa->unionid)) {
        $info->setInfo($aa->unionid);
         
        $info->updateLoginTime();
        $_SESSION['local_user'] = $info->getUserInfo();
    } else {
        $param = array();
        $param['UserName'] = $aa->nickname;
        $param['UserAvatar'] = $aa->headimgurl;
        $param['UserWebOpenId'] = $aa->openid;
        $param['UserUnionId'] = $aa->unionid;
        if ($info->insertInfo($param)) {
            $info->updateLoginTime();
            $_SESSION['local_user'] = $info->getUserInfo();
        }
    }
}

function get_url($user_info_url) {
    $ch = curl_init();
    $timeout = 5;
    curl_setopt($ch, CURLOPT_URL, $user_info_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    $file_contents = curl_exec($ch);
    curl_close($ch);
    return $file_contents;
}
