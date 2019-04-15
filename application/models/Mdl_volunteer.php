<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mdl_volunteer extends CI_Model {

    public function __construct() {
        parent::__construct();
        $collection = mongoDbInstance();
        $this->umInstance = $collection->usermaster;
        $this->amInstance = $collection->assets;
    }

    function getVolunteerList() {
        $filterArr = array("usertype" => "volunteer");
//        pre($_POST);
        if ($_POST["resetSearch"] == "resetSearch") {
            $filterfirstname = "";
            $filtercontactperson = "";
            $filteruserstatus = "";
            $filtercontactnumber = "";
            $this->session->set_userdata("filterfirstname", $filterfirstname);
            $this->session->set_userdata("filtercontactperson", $filtercontactperson);
            $this->session->set_userdata("filteruserstatus", $filteruserstatus);
            $this->session->set_userdata("filtercontactnumber", $filtercontactnumber);
        } else if ($_POST["searchResult"] == "Search") {
            $filterfirstname = getPostVal("filterfirstname");
            $filtercontactperson = getPostVal("filtercontactperson");
            $filteruserstatus = getPostVal("filteruserstatus");
            $filtercontactnumber = getPostVal("filtercontactnumber");
            $this->session->set_userdata("filterfirstname", $filterfirstname);
            $this->session->set_userdata("filtercontactperson", $filtercontactperson);
            $this->session->set_userdata("filteruserstatus", $filteruserstatus);
            $this->session->set_userdata("filtercontactnumber", $filtercontactnumber);
        } else {
            $filterfirstname = getSessionVal("filterfirstname");
            $filtercontactperson = getSessionVal("filtercontactperson");
            $filteruserstatus = getSessionVal("filteruserstatus");
            $filtercontactnumber = getSessionVal("filtercontactnumber");
        }
        if ($filterfirstname != "")
            $filterArr["userfirstname"] = array('$regex' => $filterfirstname, '$options' => 'i');
        if ($filtercontactperson != "")
            $filterArr["contactpersonname"] = array('$regex' => $filtercontactperson, '$options' => 'i');
        if ($filteruserstatus != "")
            $filterArr["userstatus"] = "$filteruserstatus";
        if ($filtercontactnumber != "")
            $filterArr["contactpersonnumber"] = array('$regex' => $filtercontactnumber, '$options' => 'i');
//        pre($this->session->userdata());
//        pre($filterArr);
        $dataArr = [];
        $result = $this->umInstance->find($filterArr, array("sort" => array("userfirstname" => 1)));
        foreach ($result as $info) {
            $dataArr[] = $info->getArrayCopy();
        }
//        pre($dataArr);
        if (count($dataArr) > 0)
            return $dataArr;
        else
            return false;
    }

    function validateUname($curUname, $curRecId) {
        if ($curRecId != "" && $curRecId != 0)
            $filterArr["_id"] = array('$ne' => getMongoID($curRecId));
        $filterArr["uname"] = $curUname;
        return $this->umInstance->count($filterArr);
    }

    function manageVolunteerInfo() {
        $uname = getPostVal("uname");
        $password = getPostVal("password");
        $userfirstname = getPostVal("userfirstname");
        $contactpersonname = getPostVal("contactpersonname");
        $contactpersonnumber = getPostVal("contactpersonnumber");
        $userstatus = getPostVal("userstatus");
        $curRecId = getPostVal("recordId");
        $dataArr["uname"] = $uname;
        $dataArr["userfirstname"] = $userfirstname;
        $dataArr["contactpersonname"] = $contactpersonname;
        $dataArr["contactpersonnumber"] = $contactpersonnumber;
        $dataArr["userstatus"] = $userstatus;
        if ($password != "")
            $dataArr["password"] = md5($password);
        $dataArr["usertype"] = "volunteer";
pre($dataArr);die;
        if ($curRecId != "" && $curRecId != 0) {
            $filterArr["_id"] = getMongoID($curRecId);
            $result = $this->umInstance->updateOne($filterArr, array('$set' => $dataArr), ['upsert' => true]);
            $sucMsg = getMsgList(6);
        } else {
            $result = $this->umInstance->insertOne($dataArr);
            $sucMsg = getMsgList(5);
        }
        return $sucMsg;
    }

    function getVolunteerInfo($curRecId) {
        $filterArr["_id"] = getMongoID($curRecId);
        return $this->umInstance->findOne($filterArr)->getArrayCopy();
    }

    function deleteVolunteer($curRecId) {
        $filterArr2["assetorganizationid"] = $curRecId;
        $deleteResult = $this->amInstance->deleteMany($filterArr2);

        $filterArr3["stafforganizationid"] = getMongoID($curRecId);
        $deleteResult = $this->umInstance->deleteMany($filterArr3);

        $filterArr["_id"] = getMongoID($curRecId);
        $deleteResult = $this->umInstance->deleteOne($filterArr);
        return getMsgList(7);
    }

    function getApiVolunteerList($filterParam) {
        $filterArr = array("usertype" => "volunteer");
        $filterfirstname = $filterParam["filterfirstname"];
        $filtercontactperson = $filterParam["filtercontactperson"];
        $filteruserstatus = $filterParam["filteruserstatus"];
        $filtercontactnumber = $filterParam["filtercontactnumber"];

        if ($filterfirstname != "")
            $filterArr["userfirstname"] = array('$regex' => $filterfirstname, '$options' => 'i');
        if ($filtercontactperson != "")
            $filterArr["contactpersonname"] = array('$regex' => $filtercontactperson, '$options' => 'i');
        if ($filteruserstatus != "")
            $filterArr["userstatus"] = "$filteruserstatus";
        if ($filtercontactnumber != "")
            $filterArr["contactpersonnumber"] = array('$regex' => $filtercontactnumber, '$options' => 'i');
        $dataArr = [];
        $result = $this->umInstance->find($filterArr, array("sort" => array("userfirstname" => 1)));
        foreach ($result as $info) {
            $dataArr[] = $info->getArrayCopy();
        }
        if (count($dataArr) > 0)
            return $dataArr;
        else
            return false;
    }

    function manageApiVolunteerInfo($filterParam) {
        $uname = $filterParam["uname"];
        $password = $filterParam["password"];
        $userfirstname = $filterParam["userfirstname"];
        $contactpersonname = $filterParam["contactpersonname"];
        $contactpersonnumber = $filterParam["contactpersonnumber"];
        $userstatus = $filterParam["userstatus"];
        $curRecId = $filterParam["recordId"];
        $dataArr["uname"] = $uname;
        $dataArr["userfirstname"] = $userfirstname;
        $dataArr["contactpersonname"] = $contactpersonname;
        $dataArr["contactpersonnumber"] = $contactpersonnumber;
        $dataArr["userstatus"] = $userstatus;
        if ($password != "")
            $dataArr["password"] = md5($password);
        $dataArr["usertype"] = "volunteer";

        if ($curRecId != "" && $curRecId != 0) {
            $filterArr["_id"] = getMongoID($curRecId);
            $result = $this->umInstance->updateOne($filterArr, array('$set' => $dataArr), ['upsert' => true]);
            $sucMsg = getMsgList(6);
        } else {
            $result = $this->umInstance->insertOne($dataArr);
            $sucMsg = getMsgList(5);
        }
        return $sucMsg;
    }

}
