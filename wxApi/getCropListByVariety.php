<?php

require '../common.php';
include '../wxAction.php';
$variety = $_GET ['variety_name'];
$PageNo = $_GET ['searchPageNum'];
$PageStart = $PageNo * 20;
$province = $_GET ['province'];

$click_variety = $db->row("select * from app_variety WHERE varietyname = '$variety' limit 0,1");
if (count($click_variety) > 0) {
    $id = $click_variety['varietyid'];
    if ($PageNo == 0) {
        $db->query("update app_variety set hotclick=hotclick+1 where varietyid=$id");
    }
}
$pro_sql = "select * from AppProvince WHERE ProName LIKE '%$province%' limit 0,1";
$arr_province = $db->row($pro_sql);
$province_id = $arr_province ['ProSort'];
$province_name = $arr_province ['ProName'];
$sql = "select a.*,(select COUNT(*) from AppCropCommentRecord WHERE CommentCropId=a.CropId) Comment,b.varietyname category_1,c.varietyname category_2 
,case when (CropImgsMin is null or CropImgsMin='') then c.variety_img else a.CropImgsMin end img  ,auths.pro pro,
  case when (ISNULL(CropImgsMin)  or CropImgsMin='') then 1 else 0 end isCrop,a.CropVipStatus
from WXCrop a
left join app_variety b on a.CropCategory1=b.varietyid
left join app_variety c on a.CropCategory2=c.varietyid
left join (select AuCropId,'$province_name' pro from WXAuthorize where BreedRegionProvince like '%$province_id%' group by AuCropId) auths on auths.AuCropId=a.CropId

where a.Flag=0 and c.varietyname like '%$variety%' 
ORDER BY CropVipStatus desc,auths.pro desc,CropOrderNo desc
limit $PageStart,20";
$result = $db->query($sql);
$array = array();
foreach ($result as $rows) {
    $url = explode(';', $rows ['img']);
    $rows ['img'] = $url;
    $array [] = $rows;
}

echo app_wx_iconv_result('getCropListByVariety', true, 'success', 0, 0, 0, $array);
?>