<?php

require '../common.php';
include '../wxAction.php';
$id = _post("id");

$sql = "select a.CommodityName,c.BrandName,d.varietyname CommodityVariety_1,e.varietyname CommodityVariety_2 from AppCommodity a
LEFT join AppBrand c on a.CommodityBrand=c.BrandId
left join app_variety d on a.CommodityVariety_1=d.varietyid
left join app_variety e on a.CommodityVariety_2=e.varietyid
 where CommodityId=$id limit 0,1";
$result = $db->row($sql);
echo app_wx_iconv_result('getCommodityById', true, 'success', 0, 0, 0, $result);
?>