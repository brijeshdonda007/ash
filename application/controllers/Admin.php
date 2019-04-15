<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        isAccessGrant();
        $this->load->model('mdl_login');
    }

    public function index() {
        $curUserType = $this->session->userdata("userType");
        $this->mdl_login->updateAssets();
//        $rssFeedUrl = "http://bopcivildefence.govt.nz/emergency-status/subscribe/rss/";
        $emergencyContent = array();
        if ($curUserType == "controller") {
            $pageContent = simplexml_load_file(EMERGENCY_RSS_URL);
            $emergencyContent = $pageContent->channel;
        }
        $data["emergencyContent"] = $emergencyContent;
        $data["organizationCount"] = $this->mdl_login->currentOrgCount();
        $data["assetsCount"] = $this->mdl_login->currentAssetCount();
        $data["pagecontent"] = "dashboard";
        $this->load->view("layout", $data);
    }

    function changepassword() {
        $this->form_validation->set_rules('opassword', 'Old Password', 'required|callback_validate_passwordinformation');
        $this->form_validation->set_rules('npassword', 'New Password', 'required');
        $this->form_validation->set_rules('cpassword', 'Confirm Password', 'required|matches[npassword]');
        if ($this->form_validation->run() == TRUE) {
            $currentClass = $this->router->fetch_class();
            $curUserId = $this->session->userdata("curUserId");
            $password = getPostVal("npassword");
            $curUserInfo = $this->mdl_login->updatePassword($curUserId, $password);
            setMsg("sucMsg", getMsgList(3));
            redirect(getCurUserUrl("changepassword"));
        }
        foreach ($_POST as $key => $val)
            $data[$key] = $val;
        $data["sucMsg"] = getMsg("sucMsg");
        $data["error_msg"] = getErrorMsg();
        $data["pagecontent"] = "changepassword";
        $this->load->view("layout", $data);
    }

    function validate_passwordinformation() {
        $password = getPostVal("opassword");
        $curUserInfo = $this->mdl_login->currentUserInformation();
        if ($curUserInfo["password"] != md5($password)) {
            $this->form_validation->set_message('validate_passwordinformation', getMsgList(2));
            return FALSE;
        } else
            return true;
    }

    function logout() {
        $this->session->sess_destroy();
        redirect("login");
    }

    function loginPreview($userId) {
        $currentAdminId = getSessionVal('curUserId');
        $curUserInfo = $this->mdl_login->getUserInfo($userId);
        $userInfoArr["curUserId"] = $curUserInfo["_id"];
        $userInfoArr["userType"] = $curUserInfo["usertype"];
        $userInfoArr["userfirstname"] = $curUserInfo["userfirstname"];
        $userInfoArr["initialUserId"] = $currentAdminId;
        $userInfoArr["isPreviewLogin"] = true;
        $this->session->set_userdata($userInfoArr);
        if ($curUserInfo["usertype"] == "organization") {
            redirect("organization/index");
        } else {
            redirect("controller/mapcontrol");
        }
    }

    function loginBackAdmin() {
        $initialUserId = getSessionVal('initialUserId');
        $isPreviewLogin = getSessionVal('isPreviewLogin');
        $curUserInfo = $this->mdl_login->getUserInfo($initialUserId);
        $userInfoArr["curUserId"] = $curUserInfo["_id"];
        $userInfoArr["userType"] = $curUserInfo["usertype"];
        $userInfoArr["userfirstname"] = $curUserInfo["userfirstname"];
        $userInfoArr["initialUserId"] = "";
        $userInfoArr["isPreviewLogin"] = false;
        $this->session->set_userdata($userInfoArr);
        if ($curUserInfo["usertype"] == "admin") {
            redirect("admin/index");
        } else {
            redirect("admin/logout");
        }
    }

}
