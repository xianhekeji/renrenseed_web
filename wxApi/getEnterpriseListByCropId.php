<?php

require '../common.php';
include '../wxAction.php';
$wxId = $_GET['cropid'];
//$lat=$_GET['lat'];
//$lon=$_GET['lon'];
//$PageNo = $_GET ['searchPageNum'];
$sql = "SELECT a.EnterpriseId,a.EnterpriseName,case when d.areaname='' OR ISNULL(d.areaname) then '' else d.areaname end EnterpriseProvince,case when e.areaname='' OR ISNULL(e.areaname) then '' else e.areaname end EnterpriseCity,case when f.areaname='' OR ISNULL(f.areaname) then '' else f.areaname end EnterpriseZone,a.EnterpriseAddressDetail,case when (EnterpriseUserAvatar=null or EnterpriseUserAvatar='') then '' else 'default_distirbutor.png' end img,
 EnterpriseCommentLevel CropLevel,case when c.BrandName='' OR ISNULL(c.BrandName) then '' else c.BrandName end  BrandName_1,c.BrandId BrandId_1,c.BrandImgMin BrandImgMin,b.CommodityOrderNoCompany,a.EnterpriseTelephone,b.CommodityVip EnterpriseLevel,b.CommodityImgsMin
 FROM AppEnterprise a
inner join (SELECT Owner,CommodityBrand,CommodityOrderNoCompany,CommodityVip,CommodityImgsMin FROM AppCommodity WHERE CommodityVariety=$wxId  AND OwnerClass=1 group by Owner ) b on a.EnterpriseId=b.Owner
left join AppBrand c on b.CommodityBrand=c.BrandId
left join AppArea d on a.EnterpriseProvince=d.areaid
left join AppArea e on a.EnterpriseCity=e.areaid
left join AppArea f on a.EnterpriseZone=f.areaid
where EnterpriseFlag=0 
order by EnterpriseLevel desc, CommodityOrderNoCompany desc;";
$result = $db->query($sql);
//$array = array();
$isshow = 0;
$array = array();
foreach ($result as $rows) {
    if ($rows['EnterpriseLevel'] == 1) {
        $isshow = 1;
    }

    $url = explode(';', $rows['EnterpriseTelephone']);
    array_push($url, '取消');
    $rows['EnterpriseTelephone'] = array_filter($url);
    $img = explode(';', $rows['CommodityImgsMin']);
    $rows['CommodityImgsMin'] = $img;
    $array[] = $rows;
}
echo app_wx_iconv_result('getEnterpriseListByCropId', true, $isshow, 0, 0, 0, $array);
?>