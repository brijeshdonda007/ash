<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mapcontrol extends CI_Controller {

    public function __construct() {
        parent::__construct();
        isAccessGrant();
        $this->load->model('mdl_mapcontrol');
    }

    public function index() {
        $data["dataArr"] = $this->mdl_mapcontrol->getAssetsList();        
        $data["assetCatArr"] = $this->mdl_mapcontrol->getAssetCategoryList();
        $data["orgListArr"] = $this->mdl_mapcontrol->getOrganisationList();        
//        pre($data);die;
        $data["sucMsg"] = getMsg("sucMsg");
        $data["pagecontent"] = "mapview";
        $this->load->view("layout", $data);
    }
    
}
