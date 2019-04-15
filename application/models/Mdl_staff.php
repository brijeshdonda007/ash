<?php

//echo strtotime("-7 days");
defined('BASEPATH') OR exit('No direct script access allowed');

class Mdl_staff extends CI_Model {

    public function __construct() {
        parent::__construct();
        $collection = mongoDbInstance();
        $this->amInstance = $collection->usermaster;
        $this->sscInstance = $collection->staffcategory;
        $this->assetInstance = $collection->assets;
    }

    function validateUname($curUname, $curRecId) {
        $curRecId = getPostVal("recordId");
        $curUname = getPostVal("uname");
        if ($curRecId != "" && $curRecId != 0)
            $filterArr["_id"] = array('$ne' => getMongoID($curRecId));
        $filterArr["uname"] = $curUname;
        return $this->amInstance->count($filterArr);
    }

    function getStaffInfo($curRecId) {
        $filterArr["_id"] = getMongoID($curRecId);
        return $this->amInstance->findOne($filterArr)->getArrayCopy();
    }

    function deleteStaff($curRecId) {
        $filterArr["_id"] = getMongoID($curRecId);
        $deleteResult = $this->amInstance->deleteOne($filterArr);
        return getMsgList(7);
    }

    function getStaffCategoryList() {
        $filterArr = $dataArr = [];
        $result = $this->sscInstance->find($filterArr, array("sort" => array("categoryname" => 1)));
        foreach ($result as $info) {
            $dataArr[] = $info->getArrayCopy();
        }
        return $dataArr;
    }

    function getAssetList($filterParam) {
        $filterArr = array();
        $curUserId = $filterParam["userAuthId"];
        if ($filterParam['userType'] != "admin")
            $filterArr = array("assetorganizationid" => $curUserId);
        $dataArr = [];
        $result = $this->assetInstance->find($filterArr, array("sort" => array("assetname" => 1)));
        foreach ($result as $info) {
            $dataArr[] = $info->getArrayCopy();
        }
        return $dataArr;
    }

    function getAssetListById($curUserId) {
        $filterArr = array();
        $filterArr = array("assetorganizationid" => $curUserId);
        $dataArr = [];
        $result = $this->assetInstance->find($filterArr, array("sort" => array("assetname" => 1)));
        foreach ($result as $info) {
            $dataArr[] = $info->getArrayCopy();
        }
        return $dataArr;
    }

    function getOrgList($filterParam) {
        $curUserId = $filterParam["userAuthId"];
        $filterArr = array(
            '$or' => array(array('usertype' => array('$in' => array("organization", "volunteer")))
        ));

//        $number = $collection->find(array(
//                    '$or' => array(array('usertype' => array('$in' => array("organization", "volunteer")))
//            )))->count();

        if ($filterParam['userType'] != "admin")
            $filterArr["_id"] = getMongoID($curUserId);
//        pre($filterArr);
//        die;

        $dataArr = [];
        $result = $this->amInstance->find($filterArr, array("sort" => array("userfirstname" => 1)));
        foreach ($result as $info) {
            $dataArr[] = $info->getArrayCopy();
        }
        $returnArr = array();
        foreach ($dataArr as $key => $val) {
            $tempArr = array();
            $assetList = $this->getAssetListById($val["_id"]->__toString());
            $tempArr = $val;
            $tempArr["assetList"] = $assetList;
            $returnArr[] = $tempArr;
        }
//        pre($returnArr);
        return $returnArr;
    }

    function getApiStaffList($filterParam) {
        $filterArr = array("usertype" => "staff");
        $filterfirstname = $filterParam["filterfirstname"];
        $filteruserstatus = $filterParam["filteruserstatus"];
        $filterstaffcat = $filterParam["filterstaffcat"];
        $filterassetId = $filterParam["filterassetId"];
        $curUserId = $filterParam["userAuthId"];
        $curUserType = $filterParam["userType"];

        if ($filterfirstname != "")
            $filterArr["userfirstname"] = array('$regex' => $filterfirstname, '$options' => 'i');
        if ($filterassetId != "")
            $filterArr["staffassetid"] = "$filterassetId";
        if ($filterstaffcat != "")
            $filterArr["staffcategoryid"] = "$filterstaffcat";
        if ($filteruserstatus != "")
            $filterArr["userstatus"] = "$filteruserstatus";
        if ($curUserType != "admin")
            $filterArr["stafforganizationid"] = $curUserId;

        $dataArr = [];
        $result = $this->amInstance->find($filterArr, array("sort" => array("uname" => 1)));
        foreach ($result as $info) {
            $dataArr[] = $info->getArrayCopy();
        }

        if (count($dataArr) > 0)
            return $dataArr;
        else
            return array();
    }

    function manageApiStaffInfo($requestData) {
        $uname = $requestData["uname"];
        $password = $requestData["password"];
        $userstatus = $requestData["userstatus"];
        $userfirstname = $requestData["userfirstname"];
        $contactpersonnumber = $requestData["contactpersonnumber"];
        $staffcategoryid = $requestData["staffcategoryid"];
        $stafforganizationid = $requestData["stafforganizationid"];
        $staffassetid = $requestData["staffassetid"];
        $curRecId = $requestData["recordId"];
        if ($password != "")
            $dataArr["password"] = md5($password);

        $dataArr["uname"] = $uname;
        $dataArr["userstatus"] = $userstatus;
        $dataArr["userfirstname"] = $userfirstname;
        $dataArr["staffcategoryid"] = $staffcategoryid;
        $dataArr["stafforganizationid"] = $stafforganizationid;
        $dataArr["staffassetid"] = $staffassetid;
        $dataArr["usertype"] = "staff";
        if ($curRecId != "" && $curRecId != 0) {
            $filterArr["_id"] = getMongoID($curRecId);
            $result = $this->amInstance->updateOne($filterArr, array('$set' => $dataArr), ['upsert' => true]);
            $sucMsg = getMsgList(6);
        } else {
            $result = $this->amInstance->insertOne($dataArr);
            $sucMsg = getMsgList(5);
        }
        return $sucMsg;
    }

}
