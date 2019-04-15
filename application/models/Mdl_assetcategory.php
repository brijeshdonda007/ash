<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mdl_assetcategory extends CI_Model {

    public function __construct() {
        parent::__construct();
        $collection = mongoDbInstance();
        $this->ascInstance = $collection->assetcategory;
    }

    function getAssetCategoryList() {
        $filterArr = array();
        if ($_POST["resetSearch"] == "resetSearch") {
            $filtercatname = "";
            $filterstatus = "";
            $this->session->set_userdata("filtercatname", $filtercatname);
            $this->session->set_userdata("filterstatus", $filterstatus);
        } else if ($_POST["searchResult"] == "Search") {
            $filtercatname = getPostVal("filtercatname");
            $filterstatus = getPostVal("filterstatus");
            $this->session->set_userdata("filterstatus", $filterstatus);
            $this->session->set_userdata("filtercatname", $filtercatname);
        } else {
            $filtercatname = getSessionVal("filtercatname");
            $filterstatus = getSessionVal("filterstatus");
        }
        if ($filtercatname != "")
            $filterArr["categoryname"] = array('$regex' => $filtercatname, '$options' => 'i');
        if ($filterstatus != "")
            $filterArr["categorystatus"] = "$filterstatus";
        $dataArr = [];
        $result = $this->ascInstance->find($filterArr, array("sort" => array("categoryname" => 1)));
        foreach ($result as $info) {
            $dataArr[] = $info->getArrayCopy();
        }

        if (count($dataArr) > 0)
            return $dataArr;
        else
            return false;
    }

    function validateCatName($curUname, $curRecId) {        
        if ($curRecId != "" && $curRecId != 0)
            $filterArr["_id"] = array('$ne' => getMongoID($curRecId));
        $filterArr["categoryname"] = $curUname;
        return $this->ascInstance->count($filterArr);
    }

    function manageAssetCategoryInfo() {
        $categoryname = getPostVal("categoryname");
        $categorystatus = getPostVal("categorystatus");
        $curRecId = getPostVal("recordId");
        $dataArr["categoryname"] = $categoryname;
        $dataArr["categorystatus"] = $categorystatus;

        if ($curRecId != "" && $curRecId != 0) {
            $filterArr["_id"] = getMongoID($curRecId);
            $result = $this->ascInstance->updateOne($filterArr, array('$set' => $dataArr), ['upsert' => true]);
            $sucMsg = getMsgList(6);
        } else {
            $result = $this->ascInstance->insertOne($dataArr);
            $sucMsg = getMsgList(5);
        }
        return $sucMsg;
    }

    function getAssetCategoryInfo($curRecId) {
        $filterArr["_id"] = getMongoID($curRecId);
        return $this->ascInstance->findOne($filterArr)->getArrayCopy();
    }

    function deleteAssetCategory($curRecId) {
        $filterArr["_id"] = getMongoID($curRecId);
        $deleteResult = $this->ascInstance->deleteOne($filterArr);
        return getMsgList(7);
    }

    function getApiAssetcategoryList($filterParam) {
        $filtercatname = $filterParam["filtercatname"];
        $filterstatus = $filterParam["filterstatus"];
        $filterArr = array();
        if ($filtercatname != "")
            $filterArr["categoryname"] = array('$regex' => $filtercatname, '$options' => 'i');
        if ($filterstatus != "")
            $filterArr["categorystatus"] = "$filterstatus";
        $dataArr = [];
        $result = $this->ascInstance->find($filterArr, array("sort" => array("categoryname" => 1)));
        foreach ($result as $info) {
            $dataArr[] = $info->getArrayCopy();
        }

        if (count($dataArr) > 0)
            return $dataArr;
        else
            return array();
    }
    
    function manageApiAssetcategoryInfo($requestData) {
        $categoryname = $requestData["categoryname"];
        $categorystatus = $requestData["categorystatus"];
        $curRecId = $requestData["recordId"];
        $dataArr["categoryname"] = $categoryname;
        $dataArr["categorystatus"] = $categorystatus;

        if ($curRecId != "" && $curRecId != 0) {
            $filterArr["_id"] = getMongoID($curRecId);
            $result = $this->ascInstance->updateOne($filterArr, array('$set' => $dataArr), ['upsert' => true]);
            $sucMsg = getMsgList(6);
        } else {
            $result = $this->ascInstance->insertOne($dataArr);
            $sucMsg = getMsgList(5);
        }
        return $sucMsg;
    }
}
