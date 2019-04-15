<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Manageassets extends CI_Controller {

    public function __construct() {
        parent::__construct();
        isAccessGrant();
        $this->load->model('mdl_assets');
    }

    public function index() {
//        pre($_REQUEST);die;
        if(isset($_POST["changeStatus"]) && count($_POST["assetList"])>0){
            $sucMsg = $this->mdl_assets->updateStatus();
            setMsg("sucMsg", $sucMsg);
            redirect(getCurUserUrl("manageassets"));
        }
        $data["dataArr"] = $this->mdl_assets->getAssetsList();
        $filterassetname = getSessionVal("filterassetname");
        $filterstatus = getSessionVal("filterstatus");
        $filterassetlocation = getSessionVal("filterassetlocation");        
        $filterassetorg = getSessionVal("filterassetorg");
        $filterassetcat = getSessionVal("filterassetcat");        
        $data["filterassetname"] = $filterassetname;
        $data["filterstatus"] = $filterstatus;
        $data["filterassetlocation"] = $filterassetlocation;        
        $data["filterassetorg"] = $filterassetorg;
        $data["filterassetcat"] = $filterassetcat;
        $data["assetCatArr"] = $this->mdl_assets->getAssetCategoryList();
        $data["orgListArr"] = $this->mdl_assets->getOrganisationList();        
        $data["sucMsg"] = getMsg("sucMsg");
        $data["pagecontent"] = "assets/list";
        $this->load->view("layout", $data);
    }

    function addeditassets($commonID = "") {        
        $this->form_validation->set_rules('assetname', 'Name', 'required');
        $this->form_validation->set_rules('assetlocation', 'Location', 'required');
        $this->form_validation->set_rules('assetcategory', 'Category', 'required');
        $this->form_validation->set_rules('assetorganizationid', 'Organisation', 'required');
        $this->form_validation->set_rules('assetstatus', 'Status', 'required');
        if ($this->form_validation->run() == TRUE) {
            $sucMsg = $this->mdl_assets->manageAssetsInfo();
            setMsg("sucMsg", $sucMsg);
            redirect(getCurUserUrl("manageassets"));
        }
        foreach ($_POST as $key => $val)
            $data[$key] = $val;
        if ($commonID != 0 && $commonID != "")
            $data = $this->mdl_assets->getAssetsInfo($commonID);
        $data["assetCatArr"] = $this->mdl_assets->getAssetCategoryList();
        $data["orgListArr"] = $this->mdl_assets->getOrganisationList();        
        $data["recordId"] = $commonID;
        $data["sucMsg"] = getMsg("sucMsg");
        $data["error_msg"] = getErrorMsg();
        $data["pagecontent"] = "assets/addedit";
        $this->load->view("layout", $data);
    }

    function deleteassets($recordId) {
        $sucMsg = $this->mdl_assets->deleteAssets($recordId);
        setMsg("sucMsg", $sucMsg);
        redirect(getCurUserUrl("manageassets"));
    }

}
