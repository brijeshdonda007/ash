<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mdl_login extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->collection = mongoDbInstance();
        $this->umInstance = $this->collection->usermaster;
        $this->amInstance = $this->collection->assets;
    }

    function isValidLogin($uname, $password) {
//        $uname = getPostVal("email");
//        $password = getPostVal("password");
        $result = $this->collection->usermaster->count(array("uname" => $uname, "password" => md5($password)));
        return $result;
    }

    function isValidEmail($uname) {
//        $uname = getPostVal("email");
//        $password = getPostVal("password");
        $result = $this->collection->usermaster->count(array("uname" => $uname));
        if ($result > 0)
            return true;
        else
            return false;
    }

    function getLoginInformation($uname, $password) {

//        $result = $this->collection->usermaster->find(array("uname" => $uname, "password" => md5($password)));
        $result = $this->collection->usermaster->find(array("uname" => $uname, "password" => md5($password)));
        foreach ($result as $info) {
            $dataArr = $info->getArrayCopy();
        }
        if (is_array($dataArr))
            return $dataArr;
        else
            return false;
    }

    function currentUserInformation() {
        $curUserId = $this->session->userdata("curUserId");
        $result = $this->collection->usermaster->find(array("_id" => getMongoID($curUserId)));
        foreach ($result as $info) {
            $dataArr = $info->getArrayCopy();
        }
        if (is_array($dataArr))
            return $dataArr;
        else
            return false;
    }

    function getUserInfo($curUserId) {
        $result = $this->collection->usermaster->find(array("_id" => getMongoID($curUserId)));
        foreach ($result as $info) {
            $dataArr = $info->getArrayCopy();
        }
        if (is_array($dataArr))
            return $dataArr;
        else
            return false;
    }

    function updatePassword($userID, $password) {
//        $password = getPostVal("npassword");
        $dataArr["password"] = md5($password);
        $filterArr["_id"] = getMongoID($userID);
        $result = $this->collection->usermaster->updateOne($filterArr, array('$set' => $dataArr), ['upsert' => true]);
        return true;
    }

    function currentAssetCount() {
        $filterArr = array();
        $curUserId = getSessionVal("curUserId");
        $curUserType = getSessionVal("userType");
        if ($curUserType == "organization")
            $filterArr["assetorganizationid"] = $curUserId->__toString();
        return $this->amInstance->count($filterArr);
    }

    function currentOrgCount() {
        $filterArr = array("usertype" => "organization");
        return $this->umInstance->count($filterArr);
    }

    function test() {
        $result = $this->collection->contacts->find(array());
        foreach ($result as $info) {
            $dataArr[] = $info->getArrayCopy();
        }
        pre($dataArr);
    }

    function updateAssets() {
        $timeToCheck = strtotime("-6 months");
        $filterArr["assetlastupdatetime"] = array('$lt' => $timeToCheck);
        $result = $this->amInstance->find($filterArr, array("sort" => array("assetname" => 1)));

        foreach ($result as $info) {
            $dataArr[] = $info->getArrayCopy();
        }

        foreach ($dataArr as $curRec) {
            $dataArr["assetstatus"] = "in-active";
            $curRecId = $curRec["_id"];
            $filterArr["_id"] = $curRecId;
            $result = $this->amInstance->updateOne($filterArr, array('$set' => $dataArr), ['upsert' => true]);
        }
    }

}
