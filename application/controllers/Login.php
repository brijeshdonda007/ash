<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
        isUserLoggedin();
        $this->load->model('mdl_login');
    }

    public function index() {
//        die(md5("test"));
        $this->form_validation->set_rules('email', 'E-mail', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required|callback_validate_userinformation');
        if ($this->form_validation->run() == TRUE) {
            $uname = getPostVal("email");
            $password = getPostVal("password");
            $curUserInfo = $this->mdl_login->getLoginInformation($uname, $password);
            $userInfoArr["curUserId"] = $curUserInfo["_id"];
            $userInfoArr["userType"] = $curUserInfo["usertype"];
            $userInfoArr["userfirstname"] = $curUserInfo["userfirstname"];
            $this->session->set_userdata($userInfoArr);
            if ($curUserInfo["usertype"] == "admin") {
                redirect("admin/index");
            } else if ($curUserInfo["usertype"] == "organization") {
                redirect("organization/index");
            } else {
                redirect("controller/mapcontrol");
            }
        }
        foreach ($_POST as $key => $val)
            $data[$key] = $val;
        $data["error_msg"] = getErrorMsg();
        $this->load->view("login", $data);
    }

    function validate_userinformation() {
        $uname = getPostVal("email");
        $password = getPostVal("password");
        $isValidUser = $this->mdl_login->isValidLogin($uname,$password);
        if ($isValidUser) {
            $curUserInfo = $this->mdl_login->getLoginInformation($uname, $password);
            if ($curUserInfo["userstatus"] != "active") {
                $this->form_validation->set_message('validate_userinformation', getMsgList(1));
                return FALSE;
            } else
                return true;
        } else {
            $this->form_validation->set_message('validate_userinformation', getMsgList(0));
            return FALSE;
        }
    }

}
