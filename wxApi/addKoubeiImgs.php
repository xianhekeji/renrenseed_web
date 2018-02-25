<?php

$path = "../files/upload/";
require '../common.php';
include '../wxAction.php';
include '../comm/imgageUnit.php';
include 'UtilClass.php';
set_time_limit(300);
$UserId = $_POST ['UserId'];
$imageid = $_POST ["imageid"];
if ($UserId == 0) {
    $data = array(
        'content' => '您还未登录！',
        'status' => 1
    );
} else {
    $images = isset($_FILES ["file"]) ? $_FILES ["file"] : '';
    $site = isset($_REQUEST ['site']) ? $_REQUEST ['site'] : '';
    $name = array();
    $save = array();
    if (!empty($images) && is_array($images ['name'])) {
        foreach ($images ['name'] as $k => $image) {
            if (empty($image))
                continue;

            $name [] = $images ['name'] [$k];
            $save [] = $images ['tmp_name'] [$k];
        }
    } elseif (!empty($images) && !empty($images ['name']) && !empty($images ['tmp_name'])) {
        $name [] = $images ['name'];
        $save [] = $images ['tmp_name'];
    }

    if (!empty($name) && !empty($save)) {
        $insert_name = array();
        $insert_name_min = array();
        $i = 0;
        foreach ($name as $k => $n) {
            if (!is_file($save [$k]))
                continue;
            $rename = 'comment_' . $UserId . '_' . time() . "_" . $imageid;
            $ext = pathinfo($n, PATHINFO_EXTENSION);
            // setShuiyin($save [$k], $path, $rename . '_min' . '.' . $ext, 500, 500);
            if (copy($save [$k], $path . $rename . '.' . $ext)) {
                $insert_name [] = $rename . '.' . $ext;
                $insert_name_min [] = $rename . '.' . $ext;
                //  $insert_name_min [] = $rename . '_min' . '.' . $ext;
                @unlink($save [$k]);
            }
            $i++;
        }
        if (!empty($insert_name)) {
            $insert = implode(";", $insert_name);
            $insert_min = implode(";", $insert_name_min);
            $data = array(
            'img' => $insert,
            'imgmin' => $insert_min,
            'status' => 0
            );
        } else {
            $data = array(
                'content' => '上传失败',
                'status' => 1
            );
        }
    }
}
echo app_wx_iconv_result('addKoubeiImgs', true, 'success', 0, 0, 0, $data);
?>

