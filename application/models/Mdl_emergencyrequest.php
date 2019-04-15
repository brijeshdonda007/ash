<?php

//echo strtotime("-7 days");
defined('BASEPATH') OR exit('No direct script access allowed');

class Mdl_emergencyrequest extends CI_Model {

    public function __construct() {
        parent::__construct();
        $collection = mongoDbInstance();
        $this->erInstance = $collection->emergancyrequest;
        $this->eaInstance = $collection->emergancyalert;
    }

    function getEmergencyRequestInfo($curRecId) {
        $filterArr["_id"] = getMongoID($curRecId);
//        return $this->erInstance->findOne($filterArr)->getArrayCopy();
        $tempArr = $this->erInstance->findOne($filterArr)->getArrayCopy();
        $tempArr["disprequestcreationtime"] = date("Y-m-d h:i:s a",$tempArr["requestcreationtime"]);
        $tempArr["dispassetlastupdatetime"] = date("Y-m-d h:i:s a",$tempArr["assetlastupdatetime"]);
        return $tempArr;
    }

    function deleteEmergencyRequest($curRecId) {
        $filterArr2["_id"] = getMongoID($curRecId);
        $deleteResult = $this->erInstance->deleteOne($filterArr2);
        return getMsgList(7);
    }

    function updateStatus() {
        $requeststatus = getPostVal("requeststatus");
        $dataArr["requeststatus"] = $requeststatus;
        $dataArr["assetlastupdatetime"] = time();
        foreach ($_POST["assetList"] as $curRecId) {
            $filterArr["_id"] = getMongoID($curRecId);
            $result = $this->erInstance->updateOne($filterArr, array('$set' => $dataArr), ['upsert' => true]);
        }
        $sucMsg = getMsgList(6);
        return $sucMsg;
    }

    function getApiEmergencyRequestList($filterParam) {
        $filterArr = array();
        $requestname = $filterParam["requestname"];
        $requestcontactnumber = $filterParam["requestcontactnumber"];
        $place = $filterParam["place"];
        $requeststatus = $filterParam["requeststatus"];
        $curUserId = $filterParam["userAuthId"];
        $curUserType = $filterParam["userType"];

        if ($requestname != "")
            $filterArr["requestname"] = array('$regex' => $requestname, '$options' => 'i');
        if ($place != "")
            $filterArr["place"] = "$place";
        if ($requestcontactnumber != "")
            $filterArr["requestcontactnumber"] = "$requestcontactnumber";
        if ($requeststatus != "")
            $filterArr["requeststatus"] = "$requeststatus";

        $dataArr = [];
        $result = $this->erInstance->find($filterArr, array("sort" => array("requeststatus" => 1)));
        foreach ($result as $info) {
            $dataArr[] = $info->getArrayCopy();
        }

        if (count($dataArr) > 0)
            return $dataArr;
        else
            return array();
    }

    function manageApiEmergencyRequestInfo($requestData) {
        $requestname = $requestData["requestname"];
        $requeststatus = isset($requestData["requeststatus"]) ? $requestData["requeststatus"] : "pending";
//        $requeststatus = isset($requestData["priority"]) ? $requestData["priority"] : "high";
        $requestlocation = $requestData["requestlocation"];
        $requestcontactnumber = $requestData["requestcontactnumber"];
        $placelatitude = $requestData["placelatitude"];
        $placelongitude = $requestData["placelongitude"];
        $requestdescription = $requestData["requestdescription"];
        $requestreason = $requestData["requestreason"];
        $curRecId = $requestData["recordId"];

        $dataArr["requestname"] = $requestname;
        $dataArr["requeststatus"] = $requeststatus;
        $dataArr["requestcontactnumber"] = $requestcontactnumber;
        $dataArr["requestlocation"] = $requestlocation;
        $dataArr["assetorganizationid"] = $assetorganizationid;
        $dataArr["placelatitude"] = $placelatitude;
        $dataArr["placelongitude"] = $placelongitude;
        $dataArr["requestdescription"] = $requestdescription;
        if($curRecId != "")
            $dataArr["requestcreationtime"] = time();
        $dataArr["assetlastupdatetime"] = time();
        if ($curRecId != "" && $curRecId != 0) {
            $filterArr["_id"] = getMongoID($curRecId);
            $result = $this->erInstance->updateOne($filterArr, array('$set' => $dataArr), ['upsert' => true]);
            $sucMsg = getMsgList(6);
        } else {
            $result = $this->erInstance->insertOne($dataArr);
            $sucMsg = getMsgList(5);
        }
        return $sucMsg;
    }

    function processEmergencyRequestInfo($requestData) {
        $processType = $requestData["processType"];
        $requestreason = $requestData["requestreason"];
        $curRecId = $requestData["recordId"];
        if ($processType == "reject") {
            $dataArr["requeststatus"] = "reject";
            $dataArr["requestreason"] = $requestreason;
            $dataArr["assetlastupdatetime"] = time();
            $filterArr["_id"] = getMongoID($curRecId);
            $result = $this->erInstance->updateOne($filterArr, array('$set' => $dataArr), ['upsert' => true]);
            $sucMsg = getMsgList(6);
        } else {
            $requestInfo = $this->getEmergencyRequestInfo($curRecId);
            unset($requestInfo["_id"]);
            $requestInfo["priority"]    =   "high";
            $result = $this->eaInstance->insertOne($requestInfo);
            $this->deleteEmergencyRequest($curRecId);
            $sucMsg = getMsgList(5);
        }
        return $sucMsg;
    }        

}
