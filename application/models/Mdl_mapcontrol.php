<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mdl_mapcontrol extends CI_Model {

    public function __construct() {
        parent::__construct();
        $collection = mongoDbInstance();
        $this->amInstance = $collection->assets;
        $this->ascInstance = $collection->assetcategory;
        $this->orgInstance = $collection->usermaster;
    }

    function getAssetsList() {
        $filterArr = array();        
        $dataArr = [];
        $result = $this->amInstance->find($filterArr, array("sort" => array("assetname" => 1)));
        foreach ($result as $info) {
            $dataArr[] = $info->getArrayCopy();
        }

        if (count($dataArr) > 0)
            return $dataArr;
        else
            return false;
    }

    function getAssetCategoryList() {
        $filterArr = $dataArr = [];
        $result = $this->ascInstance->find($filterArr, array("sort" => array("assetname" => 1)));
        foreach ($result as $info) {
            $dataArr[] = $info->getArrayCopy();
        }
        return $dataArr;
    }

    function getOrganisationList() {
        $filterArr = array("usertype" => "organization");
        $dataArr = [];
        $result = $this->orgInstance->find($filterArr, array("sort" => array("userfirstname" => 1)));
        foreach ($result as $info) {
            $dataArr[] = $info->getArrayCopy();
        }
        return $dataArr;
    }

}
