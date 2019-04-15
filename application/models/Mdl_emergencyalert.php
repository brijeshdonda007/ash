<?php

//echo strtotime("-7 days");
defined('BASEPATH') OR exit('No direct script access allowed');

class Mdl_emergencyalert extends CI_Model {

    public function __construct() {
        parent::__construct();
        $collection = mongoDbInstance();
        $this->eaInstance = $collection->emergancyalert;
    }

    function getEmergencyAlertInfo($curRecId) {
        $filterArr["_id"] = getMongoID($curRecId);
        $tempArr = $this->eaInstance->findOne($filterArr)->getArrayCopy();
        $tempArr["disprequestcreationtime"] = date("Y-m-d h:i:s a",$tempArr["requestcreationtime"]);
        $tempArr["dispassetlastupdatetime"] = date("Y-m-d h:i:s a",$tempArr["assetlastupdatetime"]);
        return $tempArr;
    }

    function deleteEmergencyAlert($curRecId) {
        $filterArr2["_id"] = getMongoID($curRecId);
        $deleteResult = $this->eaInstance->deleteOne($filterArr2);
        return getMsgList(7);
    }


    function getApiEmergencyAlertList($filterParam) {
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
        $result = $this->eaInstance->find($filterArr, array("sort" => array("requeststatus" => 1)));
        foreach ($result as $info) {
            $dataArr[] = $info->getArrayCopy();
        }

        if (count($dataArr) > 0)
            return $dataArr;
        else
            return array();
    }

    function manageApiEmergencyAlertInfo($requestData) {
        $requestname = $requestData["requestname"];
        $requeststatus = isset($requestData["requeststatus"]) ? $requestData["requeststatus"] : "pending";
        $requeststatus = isset($requestData["priority"]) ? $requestData["priority"] : "high";
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
            $result = $this->eaInstance->updateOne($filterArr, array('$set' => $dataArr), ['upsert' => true]);
            $sucMsg = getMsgList(6);
        } else {
            $result = $this->eaInstance->insertOne($dataArr);
            $sucMsg = getMsgList(5);
        }
        return $sucMsg;
    }

}
