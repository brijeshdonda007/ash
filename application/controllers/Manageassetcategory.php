<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Manageassetcategory extends CI_Controller {

    public function __construct() {
        parent::__construct();
        isAccessGrant();
        $this->load->model('mdl_assetcategory');
    }

    public function index() {
        $data["dataArr"] = $this->mdl_assetcategory->getAssetCategoryList();
        $filtercatname = getSessionVal("filtercatname");
        $filterstatus = getSessionVal("filterstatus");
        $data["filtercatname"] = $filtercatname;
        $data["filterstatus"] = $filterstatus;

        $data["sucMsg"] = getMsg("sucMsg");
        $data["pagecontent"] = "assetcategory/list";
        $this->load->view("layout", $data);
    }

    function addeditcategory($commonID = "") {
        $this->form_validation->set_rules('categoryname', 'Category Name', 'required|callback_validate_categoryname');
        $this->form_validation->set_rules('categorystatus', 'Status', 'required');
        if ($this->form_validation->run() == TRUE) {
            $sucMsg = $this->mdl_assetcategory->manageAssetCategoryInfo();
            setMsg("sucMsg", $sucMsg);
            redirect(getCurUserUrl("assetcategory"));
        }
        foreach ($_POST as $key => $val)
            $data[$key] = $val;
        if ($commonID != 0 && $commonID != "")
            $data = $this->mdl_assetcategory->getAssetCategoryInfo($commonID);
        $data["recordId"] = $commonID;
        $data["sucMsg"] = getMsg("sucMsg");
        $data["error_msg"] = getErrorMsg();
        $data["pagecontent"] = "assetcategory/addedit";
        $this->load->view("layout", $data);
    }

    function validate_categoryname() {
//        $uname = getPostVal("uname");
        $curRecId = getPostVal("recordId");
        $curUname = getPostVal("categoryname");
        $isUniqueRec = $this->mdl_assetcategory->validateCatName($curUname, $curRecId);
        if ($isUniqueRec > 0) {
            $this->form_validation->set_message('validate_categoryname', getMsgList(8));
            return FALSE;
        } else
            return true;
    }

    function deletecategory($recordId) {
        $sucMsg = $this->mdl_assetcategory->deleteAssetCategory($recordId);
        setMsg("sucMsg", $sucMsg);
        redirect(getCurUserUrl("assetcategory"));
    }

}
