<?php

//echo strtotime("-7 days");
defined('BASEPATH') OR exit('No direct script access allowed');

class Mdl_assets extends CI_Model {

    public function __construct() {
        parent::__construct();
        $collection = mongoDbInstance();
        $this->amInstance = $collection->assets;
        $this->ascInstance = $collection->assetcategory;
        $this->orgInstance = $collection->usermaster;
    }

    function getAssetsList() {
        $filterArr = array();
        if ($_POST["resetSearch"] == "resetSearch") {
            $filterassetname = "";
            $filterstatus = "";
            $filterassetlocation = "";
            $filterassetorg = "";
            $filterassetcat = "";
            $this->session->set_userdata("filterassetname", $filterassetname);
            $this->session->set_userdata("filterassetlocation", $filterassetlocation);
            $this->session->set_userdata("filterstatus", $filterstatus);
            $this->session->set_userdata("filterassetcat", $filterassetcat);
            $this->session->set_userdata("filterassetorg", $filterassetorg);
        } else if ($_POST["searchResult"] == "Search") {
            $filterassetname = getPostVal("filterassetname");
            $filterstatus = getPostVal("filterstatus");
            $filterassetlocation = getPostVal("filterassetlocation");
            $filterassetcat = getPostVal("filterassetcat");
            $filterassetorg = getPostVal("filterassetorg");
            $this->session->set_userdata("filterstatus", $filterstatus);
            $this->session->set_userdata("filterassetlocation", $filterassetlocation);
            $this->session->set_userdata("filterassetname", $filterassetname);
            $this->session->set_userdata("filterassetorg", $filterassetorg);
            $this->session->set_userdata("filterassetcat", $filterassetcat);
        } else {
            $filterassetname = getSessionVal("filterassetname");
            $filterassetlocation = getSessionVal("filterassetlocation");
            $filterstatus = getSessionVal("filterstatus");
            $filterassetorg = getSessionVal("filterassetorg");
            $filterassetcat = getSessionVal("filterassetcat");
        }
        if ($filterassetname != "")
            $filterArr["assetname"] = array('$regex' => $filterassetname, '$options' => 'i');
        if ($filterassetlocation != "")
            $filterArr["assetlocation"] = array('$regex' => $filterassetlocation, '$options' => 'i');

        if ($filterassetorg != "")
            $filterArr["assetorganizationid"] = "$filterassetorg";
        if ($filterassetcat != "")
            $filterArr["assetcategory"] = "$filterassetcat";
        if ($filterstatus != "")
            $filterArr["assetstatus"] = "$filterstatus";
        $curUserId = getSessionVal("curUserId");
        $curUserType = getSessionVal("userType");
        if ($curUserType != "admin")
            $filterArr["assetorganizationid"] = $curUserId->__toString();
//        pre($filterArr);
        $dataArr = [];
        $result = $this->amInstance->find($filterArr, array("sort" => array("assetname" => 1)));
        foreach ($result as $info) {
            $dataArr[] = $info->getArrayCopy();
        }

        if (count($dataArr) > 0)
            return $dataArr;
        else
            return array();
    }

    function manageAssetsInfo() {
        $assetname = getPostVal("assetname");
        $assetstatus = getPostVal("assetstatus");
        $assetlocation = getPostVal("assetlocation");
        $assetcategory = getPostVal("assetcategory");
        $assetorganizationid = getPostVal("assetorganizationid");
        $assetlatitude = getPostVal("assetlatitude");
        $assetlongitude = getPostVal("assetlongitude");
        $assetqty = getPostVal("assetqty");
        $assetdescription = getPostVal("assetdescription");
        $curRecId = getPostVal("recordId");

        $dataArr["assetname"] = $assetname;
        $dataArr["assetstatus"] = $assetstatus;
        $dataArr["assetcategory"] = $assetcategory;
        $dataArr["assetlocation"] = $assetlocation;
        $dataArr["assetorganizationid"] = $assetorganizationid;
        $dataArr["assetlatitude"] = $assetlatitude;
        $dataArr["assetlongitude"] = $assetlongitude;
        $dataArr["assetqty"] = $assetqty;
        $dataArr["assetdescription"] = $assetdescription;
        $dataArr["assetlastupdatetime"] = time();
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

    function getAssetsInfo($curRecId) {
        $filterArr["_id"] = getMongoID($curRecId);
        return $this->amInstance->findOne($filterArr)->getArrayCopy();
    }

    function deleteAssets($curRecId) {
        $filterArr["staffassetid"] = getMongoID($curRecId);
        $deleteResult = $this->orgInstance->deleteMany($filterArr);
        
        $filterArr2["_id"] = getMongoID($curRecId);
        $deleteResult = $this->amInstance->deleteOne($filterArr2);
        return getMsgList(7);
    }

    function getAssetCategoryList() {
        $filterArr = $dataArr = [];
        $result = $this->ascInstance->find($filterArr, array("sort" => array("assetname" => 1)));
        foreach ($result as $info) {
            $dataArr[] = $info->getArrayCopy();
        }
        return $dataArr;
    }

    function getOrganisationList($filterParam) {
        $filterArr = array("usertype" => "organization");
        $curUserId = $filterParam["userAuthId"];
        $curUserType = $filterParam["userType"];
        if ($curUserType != "admin")
            $filterArr["_id"] = getMongoID($curUserId);
//            $filterArr["assetorganizationid"] = $curUserId;
        
        $dataArr = [];
        $result = $this->orgInstance->find($filterArr, array("sort" => array("userfirstname" => 1)));
        foreach ($result as $info) {
            $dataArr[] = $info->getArrayCopy();
        }
        return $dataArr;
    }

    function updateStatus() {
        $assetstatus = getPostVal("assetstatus");
        $dataArr["assetstatus"] = $assetstatus;
        $dataArr["assetlastupdatetime"] = time();
        foreach ($_POST["assetList"] as $curRecId) {
            $filterArr["_id"] = getMongoID($curRecId);
            $result = $this->amInstance->updateOne($filterArr, array('$set' => $dataArr), ['upsert' => true]);
        }
        $sucMsg = getMsgList(6);
        return $sucMsg;
    }

    function getApiAssetsList($filterParam) {
        $filterArr = array();
        $filterassetname = $filterParam["filterassetname"];
        $filterstatus = $filterParam["filterstatus"];
        $filterassetlocation = $filterParam["filterassetlocation"];
        $filterassetcat = $filterParam["filterassetcat"];
        $filterassetorg = $filterParam["filterassetorg"];
        $curUserId = $filterParam["userAuthId"];
        $curUserType = $filterParam["userType"];

        if ($filterassetname != "")
            $filterArr["assetname"] = array('$regex' => $filterassetname, '$options' => 'i');
        if ($filterassetlocation != "")
            $filterArr["assetlocation"] = array('$regex' => $filterassetlocation, '$options' => 'i');

        if ($filterassetorg != "")
            $filterArr["assetorganizationid"] = "$filterassetorg";
        if ($filterassetcat != "")
            $filterArr["assetcategory"] = "$filterassetcat";
        if ($filterstatus != "")
            $filterArr["assetstatus"] = "$filterstatus";
        if ($curUserType != "admin")
            $filterArr["assetorganizationid"] = $curUserId;
        
        $dataArr = [];
        $result = $this->amInstance->find($filterArr, array("sort" => array("assetname" => 1)));
        foreach ($result as $info) {
            $dataArr[] = $info->getArrayCopy();
        }

        if (count($dataArr) > 0)
            return $dataArr;
        else
            return array();
    }
    
    function manageApiAssetsInfo($requestData) {
        $assetname = $requestData["assetname"];
        $assetstatus = $requestData["assetstatus"];
        $assetlocation = $requestData["assetlocation"];
        $assetcategory = $requestData["assetcategory"];
        $assetorganizationid = $requestData["assetorganizationid"];
        $assetlatitude = $requestData["assetlatitude"];
        $assetlongitude = $requestData["assetlongitude"];
        $assetqty = $requestData["assetqty"];
        $assetdescription = $requestData["assetdescription"];
        $curRecId = $requestData["recordId"];

        $dataArr["assetname"] = $assetname;
        $dataArr["assetstatus"] = $assetstatus;
        $dataArr["assetcategory"] = $assetcategory;
        $dataArr["assetlocation"] = $assetlocation;
        $dataArr["assetorganizationid"] = $assetorganizationid;
        $dataArr["assetlatitude"] = $assetlatitude;
        $dataArr["assetlongitude"] = $assetlongitude;
        $dataArr["assetqty"] = $assetqty;
        $dataArr["assetdescription"] = $assetdescription;
        $dataArr["assetlastupdatetime"] = time();
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
