<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Manageorganization extends CI_Controller {

    public function __construct() {
        parent::__construct();
        isAccessGrant();
        $this->load->model('mdl_organization');
    }

    public function index() {
        $data["dataArr"] = $this->mdl_organization->getOrganisationList();
        $filterfirstname = getSessionVal("filterfirstname");
        $filtercontactperson = getSessionVal("filtercontactperson");
        $filteruserstatus = getSessionVal("filteruserstatus");
        $filtercontactnumber = getSessionVal("filtercontactnumber");
        $data["filterfirstname"] = $filterfirstname;
        $data["filtercontactperson"] = $filtercontactperson;
        $data["filteruserstatus"] = $filteruserstatus;
        $data["filtercontactnumber"] = $filtercontactnumber;

        $data["sucMsg"] = getMsg("sucMsg");
        $data["pagecontent"] = "organization/list";
        $this->load->view("layout", $data);
    }

    function addeditorganization($commonID = "") {
        $this->form_validation->set_rules('uname', 'User Name', 'required|callback_validate_unameinformation');
        if ($commonID == "")
            $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('userfirstname', 'Organisation Name', 'required');
        $this->form_validation->set_rules('contactpersonname', 'Contact Person Name', 'required');
        $this->form_validation->set_rules('contactpersonnumber', 'Contact Number', 'required');
        $this->form_validation->set_rules('userstatus', 'Status', 'required');
        if ($this->form_validation->run() == TRUE) {
            $sucMsg = $this->mdl_organization->manageOrganisationInfo();
            setMsg("sucMsg", $sucMsg);
            redirect(getCurUserUrl("organizationlist"));
        }
        foreach ($_POST as $key => $val)
            $data[$key] = $val;
        if ($commonID != 0 && $commonID != "")
            $data = $this->mdl_organization->getOrganisationInfo($commonID);
        $data["recordId"] = $commonID;
        $data["sucMsg"] = getMsg("sucMsg");
        $data["error_msg"] = getErrorMsg();
        $data["pagecontent"] = "organization/addedit";
        $this->load->view("layout", $data);
    }

    function validate_unameinformation() {
//        $uname = getPostVal("uname");
        $curRecId = getPostVal("recordId");
        $curUname = getPostVal("uname");
        $isUniqueRec = $this->mdl_organization->validateUname($curUname, $curRecId);
        if ($isUniqueRec > 0) {
            $this->form_validation->set_message('validate_unameinformation', getMsgList(4));
            return FALSE;
        } else
            return true;
    }

    function deleteorganization($recordId) {
        $sucMsg = $this->mdl_organization->deleteOrganisation($recordId);
        setMsg("sucMsg", $sucMsg);
        redirect(getCurUserUrl("organizationlist"));
    }

}
