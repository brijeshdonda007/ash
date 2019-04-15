<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Managecontroller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        isAccessGrant();
        $this->load->model('mdl_controller');
    }

    public function index() {
        $data["dataArr"] = $this->mdl_controller->getControllerList();
        $filterfirstname = getSessionVal("filterfirstname");
//        $filtercontactperson = getSessionVal("filtercontactperson");
        $filteruserstatus = getSessionVal("filteruserstatus");
        $filtercontactnumber = getSessionVal("filtercontactnumber");

        $data["filterfirstname"] = $filterfirstname;
//        $data["filtercontactperson"]    =   $filtercontactperson;
        $data["filteruserstatus"] = $filteruserstatus;
        $data["filtercontactnumber"] = $filtercontactnumber;

        $data["sucMsg"] = getMsg("sucMsg");
        $data["pagecontent"] = "controller/list";
        $this->load->view("layout", $data);
    }

    function addeditcontroller($commonID = "") {
        $this->form_validation->set_rules('uname', 'User Name', 'required|callback_validate_unameinformation');
        if ($commonID == "")
            $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('userfirstname', 'Controller Name', 'required');
//        $this->form_validation->set_rules('contactpersonname', 'Contact Person Name', 'required');
        $this->form_validation->set_rules('contactpersonnumber', 'Contact Number', 'required');
        $this->form_validation->set_rules('userstatus', 'Status', 'required');
        if ($this->form_validation->run() == TRUE) {
            $sucMsg = $this->mdl_controller->manageControllerInfo();
            setMsg("sucMsg", $sucMsg);
            redirect(getCurUserUrl("controllerlist"));
        }
        foreach ($_POST as $key => $val)
            $data[$key] = $val;
        if ($commonID != 0 && $commonID != "")
            $data = $this->mdl_controller->getControllerInfo($commonID);
        $data["recordId"] = $commonID;
        $data["sucMsg"] = getMsg("sucMsg");
        $data["error_msg"] = getErrorMsg();
        $data["pagecontent"] = "controller/addedit";
        $this->load->view("layout", $data);
    }

    function validate_unameinformation() {
        $curRecId = getPostVal("recordId");
        $curUname = getPostVal("uname");
        $isUniqueRec = $this->mdl_controller->validateUname($curUname, $curRecId);
        if ($isUniqueRec > 0) {
            $this->form_validation->set_message('validate_unameinformation', getMsgList(4));
            return FALSE;
        } else
            return true;
    }

    function deletecontroller($recordId) {
        $sucMsg = $this->mdl_controller->deleteController($recordId);
        setMsg("sucMsg", $sucMsg);
        redirect(getCurUserUrl("controllerlist"));
    }

}
