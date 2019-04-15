<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mdl_staffcategory extends CI_Model {

    public function __construct() {
        parent::__construct();
        $collection = mongoDbInstance();
        $this->ascInstance = $collection->staffcategory;
    }

    function validateCatName($curUname, $curRecId) {        
        if ($curRecId != "" && $curRecId != 0)
            $filterArr["_id"] = array('$ne' => getMongoID($curRecId));
        $filterArr["categoryname"] = $curUname;
        return $this->ascInstance->count($filterArr);
    }

    function getStaffCategoryInfo($curRecId) {
        $filterArr["_id"] = getMongoID($curRecId);
        return $this->ascInstance->findOne($filterArr)->getArrayCopy();
    }

    function deleteStaffCategory($curRecId) {
        $filterArr["_id"] = getMongoID($curRecId);
        $deleteResult = $this->ascInstance->deleteOne($filterArr);
        return getMsgList(7);
    }

    function getApiStaffCategoryList($filterParam) {
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
    
    function manageApiStaffCategoryInfo($requestData) {
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
