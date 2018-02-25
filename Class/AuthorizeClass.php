<?php

class AuthorizeClass {

    private $AuthorizeId; //唯一id
    private $AuthorizeNumber; //审定编码
    private $AuthorizeYear; //审定年份
    private $BreedOrganization; //育种单位
    private $BreedId; //育种单位ID
    private $VarietySource; //品种来源
    private $Features; //特征特性
    private $Production; //实验产量
    private $BreedRegion; //适宜地区
    private $BreedSkill; //栽培技术
    private $OwnerShip; //
    private $AuthorizeStatus; //状态 0:无审定无登记1：审定编号 2：引种编号 3：登记编号
    private $BreedRegionProvince; //适宜省份
    private $AuthorizeUnit; //审定省份
    private $AuCropId; //审定品种
    private $AuCropName; //审定品种名称
    private $AuFlag; //作废退出标记0：启用1：作废 2：退出
    private $AuthorizeProvince; //审定省份id
    private $AuOrderNo; //审定
    private $AuKangxing; //抗性表现
    private $AuPinzhi; //品质表现
    private $FlagReason; //退出理由
    private $table = "WXAuthorize"; //类关联的数据库表名称
    private $columns; //文章数据表字段集合

    public function __construct() {
        require (DT_ROOT . "/data/dbClass.php"); //包含配置信息.
        $this->db = $db;
        $this->columns = $this->db->getColumn($this->table, null);
    }

    function setInfo($id) {
        $sql = "select * from $this->table where AuthorizeId=$id";
        $result = $this->db->row($sql); //返回查询结果到数组
        foreach ($this->columns as $column) {
            $aa = "set" . "$column";
            $this->$aa($result["$column"]);
        }
        return $result;
    }

    function updateInfo($param) {
        $condition = '';
        foreach ($this->columns as $column) {
            if (!empty($param[$column])) {
                if (empty($condition)) {
                    $condition = $column . "='" . $param[$column] . "'";
                } else {
                    $condition = $condition . "," . $column . "='" . $param[$column] . "'";
                }
            }
        }
        $sql = "update $this->table set $condition where AuthorizeId=$this->AuthorizeId";
        return $this->db->query($sql);
    }

    function insertInfo($param) {
        $condition = '';
        foreach ($this->columns as $column) {
            if (!empty($param[$column])) {
                if (empty($condition)) {
                    $condition = $column . "='" . $param[$column] . "'";
                } else {
                    $condition = $condition . "," . $column . "='" . $param[$column] . "'";
                }
            }
        }
        $sql = "insert into $this->table set $condition ";
        $this->db->query($sql);
        return $this->db->lastInsertId();
    }

    //返回每个属性的public 方法.
    function setTuichu($flag, $reason) {
        $sql = "update $this->table SET AuFlag=2,FlagReason='$reason'  WHERE AuthorizeId= $this->AuthorizeId";
        $update = $this->db->query($sql);
        if ($update == 1) {
            return '退出成功--' . $update;
        } else {
            return '操作失败--' . $update;
        }
    }

    //返回每个属性的public 方法.
    function setThisFlag($flag) {
        $sql = "update $this->table SET AuFlag=$flag WHERE AuthorizeId= $this->AuthorizeId";
        $update = $this->db->query($sql);
        if ($update == 1) {
            if ($flag == 0) {
                return '启用成功--' . $update;
            } else if ($update == 2) {
                return '退出成功--' . $update;
            } else if ($update == 1) {
                return '作废成功--' . $update;
            }
        } else {
            return '操作失败--' . $update;
        }
    }

    //更新品种表状态标记
    function updateCropStatus($cropid) {
        $sql_more = "select DISTINCT(AuthorizeStatus) AuthorizeStatus from WXAuthorize where AuCropId=$cropid";
        $result_more = $this->db->query($sql_more);
        $array = array();
        $shending = false;
        $dengji = false;
        foreach ($result_more as $rows) {
            // 可以直接把读取到的数据赋值给数组或者通过字段名的形式赋值也可以
            if ($rows['AuthorizeStatus'] == 1 || $rows['AuthorizeStatus'] == 2) {
                $shending = true;
            }
            if ($rows['AuthorizeStatus'] == 3) {
                $dengji = true;
            }
        }
        $statu = '';
        if ($shending) {
            $statu = '1';
        }
        if ($dengji) {
            // $statu = $statu . '已登记';
            $statu = '2';
        }
        if (!$shending && !$dengji) {
            $statu = '0';
        }
        $sql_update = "update WXCrop set CropStatus='$statu' where CropId='$cropid'";
        $update = $this->db->query($sql_update);
    }

    function getAuthorizeId() {
        return $this->AuthorizeId;
    }

    function getAuthorizeNumber() {
        return $this->AuthorizeNumber;
    }

    function getAuthorizeYear() {
        return $this->AuthorizeYear;
    }

    function getBreedOrganization() {
        return $this->BreedOrganization;
    }

    function getBreedId() {
        return $this->BreedId;
    }

    function getVarietySource() {
        return $this->VarietySource;
    }

    function getFeatures() {
        return $this->Features;
    }

    function getProduction() {
        return $this->Production;
    }

    function getBreedRegion() {
        return $this->BreedRegion;
    }

    function getBreedSkill() {
        return $this->BreedSkill;
    }

    function getOwnerShip() {
        return $this->OwnerShip;
    }

    function getAuthorizeStatus() {
        return $this->AuthorizeStatus;
    }

    function getBreedRegionProvince() {
        return $this->BreedRegionProvince;
    }

    function getAuthorizeUnit() {
        return $this->AuthorizeUnit;
    }

    function getAuCropId() {
        return $this->AuCropId;
    }

    function getAuCropName() {
        return $this->AuCropName;
    }

    function getAuFlag() {
        return $this->AuFlag;
    }

    function getAuthorizeProvince() {
        return $this->AuthorizeProvince;
    }

    function getAuOrderNo() {
        return $this->AuOrderNo;
    }

    function getAuKangxing() {
        return $this->AuKangxing;
    }

    function getAuPinzhi() {
        return $this->AuPinzhi;
    }

    function getFlagReason() {
        return $this->FlagReason;
    }

    function setAuthorizeId($AuthorizeId) {
        $this->AuthorizeId = $AuthorizeId;
    }

    function setAuthorizeNumber($AuthorizeNumber) {
        $this->AuthorizeNumber = $AuthorizeNumber;
    }

    function setAuthorizeYear($AuthorizeYear) {
        $this->AuthorizeYear = $AuthorizeYear;
    }

    function setBreedOrganization($BreedOrganization) {
        $this->BreedOrganization = $BreedOrganization;
    }

    function setBreedId($BreedId) {
        $this->BreedId = $BreedId;
    }

    function setVarietySource($VarietySource) {
        $this->VarietySource = $VarietySource;
    }

    function setFeatures($Features) {
        $this->Features = $Features;
    }

    function setProduction($Production) {
        $this->Production = $Production;
    }

    function setBreedRegion($BreedRegion) {
        $this->BreedRegion = $BreedRegion;
    }

    function setBreedSkill($BreedSkill) {
        $this->BreedSkill = $BreedSkill;
    }

    function setOwnerShip($OwnerShip) {
        $this->OwnerShip = $OwnerShip;
    }

    function setAuthorizeStatus($AuthorizeStatus) {
        $this->AuthorizeStatus = $AuthorizeStatus;
    }

    function setBreedRegionProvince($BreedRegionProvince) {
        $this->BreedRegionProvince = $BreedRegionProvince;
    }

    function setAuthorizeUnit($AuthorizeUnit) {
        $this->AuthorizeUnit = $AuthorizeUnit;
    }

    function setAuCropId($AuCropId) {
        $this->AuCropId = $AuCropId;
    }

    function setAuCropName($AuCropName) {
        $this->AuCropName = $AuCropName;
    }

    function setAuFlag($AuFlag) {
        $this->AuFlag = $AuFlag;
    }

    function setAuthorizeProvince($AuthorizeProvince) {
        $this->AuthorizeProvince = $AuthorizeProvince;
    }

    function setAuOrderNo($AuOrderNo) {
        $this->AuOrderNo = $AuOrderNo;
    }

    function setAuKangxing($AuKangxing) {
        $this->AuKangxing = $AuKangxing;
    }

    function setAuPinzhi($AuPinzhi) {
        $this->AuPinzhi = $AuPinzhi;
    }

    function setFlagReason($FlagReason) {
        $this->FlagReason = $FlagReason;
    }

}

?>
