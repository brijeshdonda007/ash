<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Apiservice2 extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('mdl_login');
        $this->load->model('mdl_organization');
        $this->load->model('mdl_volunteer');
        $this->load->model('mdl_controller');
        $this->load->model('mdl_assetcategory');
        $this->load->model('mdl_assets');
        $this->load->model('mdl_staffcategory');
        $this->load->model('mdl_staff');
        $this->load->model('mdl_emergencyrequest');
        $this->load->model('mdl_emergencyalert');
//        $method = $_SERVER['REQUEST_METHOD'];
//        echo 'default value';
//        pre($_REQUEST);
//        $temp = $_REQUEST;
//        $this->requestData = json_decode($_REQUEST, true);
//        echo 'after value';
//        $this->requestData = json_decode(json_encode($temp), true);
//        $rawPostData = file_get_contents('php://input');
        $jsonData = $_REQUEST;
        $this->requestData = $jsonData;
//        pre($jsonData);
//        die;
//        pre(json_decode(json_encode($temp),true));die;
//        $this->requestData = $_REQUEST;
    }

    public function index() {
        $requestData = $this->requestData;
//        pre($requestData);
        $actionType = $requestData['action'];

//        die;
        $responceArr = array();
        switch ($actionType) {
            case 'login':
                $responceArr = $this->login();
                break;
            case 'changepassword':
                $responceArr = $this->changePassword();
                break;
            case 'forgotpassword':
                $responceArr = $this->forgotPassword();
                break;
            case 'getOrganizationList':
                $responceArr = $this->getOrganization();
                break;
            case 'getOrganizationInfo':
                $responceArr = $this->getOrganizationInfo();
                break;
            case 'manageOrganization':
                $responceArr = $this->manageOrganization();
                break;
            case 'deleteOrganization':
                $responceArr = $this->deleteOrganization();
                break;
            case 'getControllerList':
                $responceArr = $this->getController();
                break;
            case 'getControllerInfo':
                $responceArr = $this->getControllerInfo();
                break;
            case 'manageController':
                $responceArr = $this->manageController();
                break;
            case 'deleteController':
                $responceArr = $this->deleteController();
                break;
            case 'getAssetcategoryList':
                $responceArr = $this->getAssetcategory();
                break;
            case 'getAssetcategoryInfo':
                $responceArr = $this->getAssetcategoryInfo();
                break;
            case 'manageAssetcategory':
                $responceArr = $this->manageAssetcategory();
                break;
            case 'deleteAssetcategory':
                $responceArr = $this->deleteAssetcategory();
                break;
            case 'getAssetsList':
                $responceArr = $this->getAssets();
                break;
            case 'getAssetsInfo':
                $responceArr = $this->getAssetsInfo();
                break;
            case 'manageAssets':
                $responceArr = $this->manageAssets();
                break;
            case 'deleteAssets':
                $responceArr = $this->deleteAssets();
                break;
            case 'getStaffcategoryList':
                $responceArr = $this->getStaffcategory();
                break;
            case 'getStaffcategoryInfo':
                $responceArr = $this->getStaffcategoryInfo();
                break;
            case 'manageStaffcategory':
                $responceArr = $this->manageStaffcategory();
                break;
            case 'deleteStaffcategory':
                $responceArr = $this->deleteStaffcategory();
                break;
            case 'getStaffList':
                $responceArr = $this->getStaff();
                break;
            case 'getStaffInfo':
                $responceArr = $this->getStaffInfo();
                break;
            case 'manageStaff':
                $responceArr = $this->manageStaff();
                break;
            case 'deleteStaff':
                $responceArr = $this->deleteStaff();
                break;

            case 'getEmergencyRequestList':
                $responceArr = $this->getEmergencyRequest();
                break;
            case 'getEmergencyRequestInfo':
                $responceArr = $this->getEmergencyRequestInfo();
                break;
            case 'manageEmergencyRequest':
                $responceArr = $this->manageEmergencyRequest();
                break;
            case 'processEmergencyRequest':
                $responceArr = $this->processEmergencyRequest();
                break;
            case 'deleteEmergencyRequest':
                $responceArr = $this->deleteEmergencyRequest();
                break;
            case 'getMapDisplayInformation':
                $responceArr = $this->getMapDisplayInformation();
                break;

            case 'getVolunteerList':
                $responceArr = $this->getVolunteer();
                break;
            case 'getVolunteerInfo':
                $responceArr = $this->getVolunteerInfo();
                break;
            case 'manageVolunteer':
                $responceArr = $this->manageVolunteer();
                break;
            case 'deleteVolunteer':
                $responceArr = $this->deleteVolunteer();
                break;

            case 'getEmergencyAlertList':
                $responceArr = $this->getEmergencyAlert();
                break;
            case 'getEmergencyAlertInfo':
                $responceArr = $this->getEmergencyAlertInfo();
                break;
            case 'manageEmergencyAlert':
                $responceArr = $this->manageEmergencyAlert();
                break;
            case 'deleteEmergencyAlert':
                $responceArr = $this->deleteEmergencyAlert();
                break;

            case 'dashboardContent':
                $responceArr = $this->dashboardContent();
                break;

            case 'createNewUser':
                $responceArr = $this->createNewUser();
                break;

            default:
                $returnArr["errorMessage"] = "testing case";
                $returnArr["error"] = true;
                break;
        }
        echo json_encode($responceArr);
//        pre($responceArr);
    }

    function login() {
        $requestData = $this->requestData;
        $validateParam = array("email", "password");
        $isError = $this->validateInput($validateParam, $requestData);
        $returnArr = array();
        $returnArr["errorMessage"] = "";
        $returnArr["error"] = false;
        if ($isError['error']) {
            $returnArr["errorMessage"] = $isError["errorMsg"];
            $returnArr["error"] = true;
        } else {
            $uname = $requestData["email"];
            $password = $requestData["password"];
            $isValidUser = $this->mdl_login->isValidLogin($uname, $password);
            if ($isValidUser) {
                $curUserInfo = $this->mdl_login->getLoginInformation($uname, $password);
                $curUserInfo['userID'] = $curUserInfo["_id"]->__toString();
                if (isset($curUserInfo["_id"])) {
                    $returnArr["userInfo"] = $curUserInfo;
                } else {
                    $returnArr["errorMessage"] = getMsgList(1);
                    $returnArr["error"] = true;
                }
            } else {
                $returnArr["errorMessage"] = getMsgList(0);
                $returnArr["error"] = true;
            }
        }
        return $returnArr;
    }

    function changePassword() {
        $requestData = $this->requestData;
        $validateParam = array("userAuthId", "password");
        $isError = $this->validateInput($validateParam, $requestData);
        $returnArr = array();
        $returnArr["errorMessage"] = "";
        $returnArr["error"] = false;
        if ($isError['error']) {
            $returnArr["errorMessage"] = $isError["errorMsg"];
            $returnArr["error"] = true;
        } else {
            $curUserId = $requestData["userAuthId"];
            $password = $requestData["password"];
            $curUserInfo = $this->mdl_login->updatePassword($curUserId, $password);
            $returnArr["errorMessage"] = "information updated successfully.";
            $returnArr["error"] = false;
        }
        return $returnArr;
    }

    function forgotPassword() {
        $requestData = $this->requestData;
        $validateParam = array("email");
        $isError = $this->validateInput($validateParam, $requestData);
        $returnArr = array();
        $returnArr["errorMessage"] = "";
        $returnArr["error"] = false;
        if ($isError['error']) {
            $returnArr["errorMessage"] = $isError["errorMsg"];
            $returnArr["error"] = true;
        } else {
            $uname = $requestData["email"];
            $isValidUser = $this->mdl_login->isValidEmail($uname);
            if ($isValidUser > 0) {
                $returnArr["errorMessage"] = getMsgList(10);
                $returnArr["error"] = true;
            } else {
                $returnArr["errorMessage"] = getMsgList(9);
                $returnArr["error"] = true;
            }
        }
        return $returnArr;
    }

    function getOrganization() {
        $requestData = $this->requestData;
        $data["organizationArr"] = $this->mdl_organization->getApiOrganisationList($requestData);
        return $data;
    }

    function getOrganizationInfo() {
        $requestData = $this->requestData;
        $validateParam = array("userAuthId", "recordId");
        $isError = $this->validateInput($validateParam, $requestData);
        $returnArr = array();
        $returnArr["errorMessage"] = "";
        $returnArr["error"] = false;
        if ($isError['error']) {
            $returnArr["errorMessage"] = $isError["errorMsg"];
            $returnArr["error"] = true;
        } else {
            $curRecId = $requestData["recordId"];
            $sucMsg = $this->mdl_organization->getOrganisationInfo($curRecId);
            $returnArr["recordInfo"] = $sucMsg;
            $returnArr["error"] = false;
        }
        return $returnArr;
    }

    function manageOrganization() {
        $requestData = $this->requestData;
        $validateParam = array("userAuthId", "uname", 'userfirstname', 'contactpersonname', 'contactpersonnumber', 'userstatus');
        if ($requestData['recordId'] == "")
            $validateParam[] = 'password';
        $isError = $this->validateInput($validateParam, $requestData);
        $returnArr = array();
        $returnArr["errorMessage"] = "";
        $returnArr["error"] = false;
        if ($isError['error']) {
            $returnArr["errorMessage"] = $isError["errorMsg"];
            $returnArr["error"] = true;
        } else {
            $curRecId = $requestData["recordId"];
            $curUname = $requestData["uname"];
            $isUniqueRec = $this->mdl_organization->validateUname($curUname, $curRecId);
            if ($isUniqueRec > 0) {
                $returnArr["errorMessage"] = getMsgList(4);
                $returnArr["error"] = true;
            } else {
                $sucMsg = $this->mdl_organization->manageApiOrganisationInfo($requestData);
                $returnArr["errorMessage"] = $sucMsg;
                $returnArr["error"] = false;
            }
        }
        return $returnArr;
    }

    function deleteOrganization() {
        $requestData = $this->requestData;
        $validateParam = array("userAuthId", "recordId");
        $isError = $this->validateInput($validateParam, $requestData);
        $returnArr = array();
        $returnArr["errorMessage"] = "";
        $returnArr["error"] = false;
        if ($isError['error']) {
            $returnArr["errorMessage"] = $isError["errorMsg"];
            $returnArr["error"] = true;
        } else {
            $curRecId = $requestData["recordId"];
            $curUname = $requestData["uname"];
            $sucMsg = $this->mdl_organization->deleteOrganisation($curRecId);
            $returnArr["errorMessage"] = $sucMsg;
            $returnArr["error"] = false;
        }
        return $returnArr;
    }

    function getController() {
        $requestData = $this->requestData;
        $data["controllerArr"] = $this->mdl_controller->getApiControllerList($requestData);
        return $data;
    }

    function getControllerInfo() {
        $requestData = $this->requestData;
        $validateParam = array("userAuthId", "recordId");
        $isError = $this->validateInput($validateParam, $requestData);
        $returnArr = array();
        $returnArr["errorMessage"] = "";
        $returnArr["error"] = false;
        if ($isError['error']) {
            $returnArr["errorMessage"] = $isError["errorMsg"];
            $returnArr["error"] = true;
        } else {
            $curRecId = $requestData["recordId"];
            $sucMsg = $this->mdl_controller->getControllerInfo($curRecId);
            $returnArr["recordInfo"] = $sucMsg;
            $returnArr["error"] = false;
        }
        return $returnArr;
    }

    function manageController() {
        $requestData = $this->requestData;
        $validateParam = array("userAuthId", "uname", 'userfirstname', 'contactpersonnumber', 'userstatus');
        if ($requestData['recordId'] == "")
            $validateParam[] = 'password';
        $isError = $this->validateInput($validateParam, $requestData);
        $returnArr = array();
        $returnArr["errorMessage"] = "";
        $returnArr["error"] = false;
        if ($isError['error']) {
            $returnArr["errorMessage"] = $isError["errorMsg"];
            $returnArr["error"] = true;
        } else {
            $curRecId = $requestData["recordId"];
            $curUname = $requestData["uname"];
            $isUniqueRec = $this->mdl_controller->validateUname($curUname, $curRecId);
            if ($isUniqueRec > 0) {
                $returnArr["errorMessage"] = getMsgList(4);
                $returnArr["error"] = true;
            } else {
                $sucMsg = $this->mdl_controller->manageApiControllerInfo($requestData);
                $returnArr["errorMessage"] = $sucMsg;
                $returnArr["error"] = false;
            }
        }
        return $returnArr;
    }

    function deleteController() {
        $requestData = $this->requestData;
        $validateParam = array("userAuthId", "recordId");
        $isError = $this->validateInput($validateParam, $requestData);
        $returnArr = array();
        $returnArr["errorMessage"] = "";
        $returnArr["error"] = false;
        if ($isError['error']) {
            $returnArr["errorMessage"] = $isError["errorMsg"];
            $returnArr["error"] = true;
        } else {
            $curRecId = $requestData["recordId"];
            $curUname = $requestData["uname"];
            $sucMsg = $this->mdl_controller->deleteController($curRecId);
            $returnArr["errorMessage"] = $sucMsg;
            $returnArr["error"] = false;
        }
        return $returnArr;
    }

    function getAssetcategory() {
        $requestData = $this->requestData;
        $data["recordArr"] = $this->mdl_assetcategory->getApiAssetcategoryList($requestData);
        return $data;
    }

    function getAssetcategoryInfo() {
        $requestData = $this->requestData;
        $validateParam = array("userAuthId", "recordId");
        $isError = $this->validateInput($validateParam, $requestData);
        $returnArr = array();
        $returnArr["errorMessage"] = "";
        $returnArr["error"] = false;
        if ($isError['error']) {
            $returnArr["errorMessage"] = $isError["errorMsg"];
            $returnArr["error"] = true;
        } else {
            $curRecId = $requestData["recordId"];
            $sucMsg = $this->mdl_assetcategory->getAssetCategoryInfo($curRecId);
            $returnArr["recordInfo"] = $sucMsg;
            $returnArr["error"] = false;
        }
        return $returnArr;
    }

    function manageAssetcategory() {
        $requestData = $this->requestData;
        $validateParam = array("userAuthId", "categoryname", 'categorystatus', 'createAction');
        $isError = $this->validateInput($validateParam, $requestData);
        $returnArr = array();
        $returnArr["errorMessage"] = "";
        $returnArr["error"] = false;
        if ($isError['error']) {
            $returnArr["errorMessage"] = $isError["errorMsg"];
            $returnArr["error"] = true;
        } else {
            $curRecId = $requestData["recordId"];
            $curUname = $requestData["categoryname"];
            $isUniqueRec = $this->mdl_assetcategory->validateCatName($curUname, $curRecId);
            if ($isUniqueRec > 0) {
                $returnArr["errorMessage"] = getMsgList(8);
                $returnArr["error"] = true;
            } else {
                $sucMsg = $this->mdl_assetcategory->manageApiAssetcategoryInfo($requestData);
                $returnArr["errorMessage"] = $sucMsg;
                $returnArr["error"] = false;
            }
        }
        return $returnArr;
    }

    function deleteAssetcategory() {
        $requestData = $this->requestData;
        $validateParam = array("userAuthId", "recordId");
        $isError = $this->validateInput($validateParam, $requestData);
        $returnArr = array();
        $returnArr["errorMessage"] = "";
        $returnArr["error"] = false;
        if ($isError['error']) {
            $returnArr["errorMessage"] = $isError["errorMsg"];
            $returnArr["error"] = true;
        } else {
            $curRecId = $requestData["recordId"];
            $curUname = $requestData["uname"];
            $sucMsg = $this->mdl_assetcategory->deleteAssetCategory($curRecId);
            $returnArr["errorMessage"] = $sucMsg;
            $returnArr["error"] = false;
        }
        return $returnArr;
    }

    function getAssets() {
        $requestData = $this->requestData;
        $validateParam = array("userAuthId", "userType");
        $isError = $this->validateInput($validateParam, $requestData);
        $returnArr = array();
        $returnArr["errorMessage"] = "";
        $returnArr["error"] = false;
        if ($isError['error']) {
            $returnArr["errorMessage"] = $isError["errorMsg"];
            $returnArr["error"] = true;
        } else {
            $returnArr["assetCatArr"] = $this->mdl_assets->getAssetCategoryList();
            $returnArr["orgListArr"] = $this->mdl_assets->getOrganisationList($requestData);
            $returnArr["recordArr"] = $this->mdl_assets->getApiAssetsList($requestData);
        }
        return $returnArr;
    }

    function getAssetsInfo() {
        $requestData = $this->requestData;
        $validateParam = array("userAuthId", "recordId");
        $isError = $this->validateInput($validateParam, $requestData);
        $returnArr = array();
        $returnArr["errorMessage"] = "";
        $returnArr["error"] = false;
        if ($isError['error']) {
            $returnArr["errorMessage"] = $isError["errorMsg"];
            $returnArr["error"] = true;
        } else {
            $curRecId = $requestData["recordId"];
            $sucMsg = $this->mdl_assets->getAssetsInfo($curRecId);
            $returnArr["assetCatArr"] = $this->mdl_assets->getAssetCategoryList();
            $returnArr["orgListArr"] = $this->mdl_assets->getOrganisationList();
            $returnArr["recordInfo"] = $sucMsg;
            $returnArr["error"] = false;
        }
        return $returnArr;
    }

    function manageAssets() {
        $requestData = $this->requestData;
        $validateParam = array("userAuthId", "assetname", 'assetlocation', 'assetcategory', 'assetorganizationid', 'assetstatus', 'assetlatitude', 'assetlongitude', 'assetdescription');
        $isError = $this->validateInput($validateParam, $requestData);
        $returnArr = array();
        $returnArr["errorMessage"] = "";
        $returnArr["error"] = false;
        if ($isError['error']) {
            $returnArr["errorMessage"] = $isError["errorMsg"];
            $returnArr["error"] = true;
        } else {
            $sucMsg = $this->mdl_assets->manageApiAssetsInfo($requestData);
            $returnArr["errorMessage"] = $sucMsg;
            $returnArr["error"] = false;
        }
        return $returnArr;
    }

    function deleteAssets() {
        $requestData = $this->requestData;
        $validateParam = array("userAuthId", "recordId");
        $isError = $this->validateInput($validateParam, $requestData);
        $returnArr = array();
        $returnArr["errorMessage"] = "";
        $returnArr["error"] = false;
        if ($isError['error']) {
            $returnArr["errorMessage"] = $isError["errorMsg"];
            $returnArr["error"] = true;
        } else {
            $curRecId = $requestData["recordId"];
            $curUname = $requestData["uname"];
            $sucMsg = $this->mdl_assets->deleteAssets($curRecId);
            $returnArr["errorMessage"] = $sucMsg;
            $returnArr["error"] = false;
        }
        return $returnArr;
    }

    function getStaffcategory() {
        $requestData = $this->requestData;
        $data["recordArr"] = $this->mdl_staffcategory->getApiStaffCategoryList($requestData);
        return $data;
    }

    function getStaffcategoryInfo() {
        $requestData = $this->requestData;
        $validateParam = array("userAuthId", "recordId");
        $isError = $this->validateInput($validateParam, $requestData);
        $returnArr = array();
        $returnArr["errorMessage"] = "";
        $returnArr["error"] = false;
        if ($isError['error']) {
            $returnArr["errorMessage"] = $isError["errorMsg"];
            $returnArr["error"] = true;
        } else {
            $curRecId = $requestData["recordId"];
            $sucMsg = $this->mdl_staffcategory->getStaffCategoryInfo($curRecId);
            $returnArr["recordInfo"] = $sucMsg;
            $returnArr["error"] = false;
        }
        return $returnArr;
    }

    function manageStaffcategory() {
        $requestData = $this->requestData;
        $validateParam = array("userAuthId", "categoryname", 'categorystatus', 'createAction');
        $isError = $this->validateInput($validateParam, $requestData);
        $returnArr = array();
        $returnArr["errorMessage"] = "";
        $returnArr["error"] = false;
        if ($isError['error']) {
            $returnArr["errorMessage"] = $isError["errorMsg"];
            $returnArr["error"] = true;
        } else {
            $curRecId = $requestData["recordId"];
            $curUname = $requestData["categoryname"];
            $isUniqueRec = $this->mdl_staffcategory->validateCatName($curUname, $curRecId);
            if ($isUniqueRec > 0) {
                $returnArr["errorMessage"] = getMsgList(8);
                $returnArr["error"] = true;
            } else {
                $sucMsg = $this->mdl_staffcategory->manageApiStaffcategoryInfo($requestData);
                $returnArr["errorMessage"] = $sucMsg;
                $returnArr["error"] = false;
            }
        }
        return $returnArr;
    }

    function deleteStaffcategory() {
        $requestData = $this->requestData;
        $validateParam = array("userAuthId", "recordId");
        $isError = $this->validateInput($validateParam, $requestData);
        $returnArr = array();
        $returnArr["errorMessage"] = "";
        $returnArr["error"] = false;
        if ($isError['error']) {
            $returnArr["errorMessage"] = $isError["errorMsg"];
            $returnArr["error"] = true;
        } else {
            $curRecId = $requestData["recordId"];
            $curUname = $requestData["uname"];
            $sucMsg = $this->mdl_staffcategory->deleteStaffCategory($curRecId);
            $returnArr["errorMessage"] = $sucMsg;
            $returnArr["error"] = false;
        }
        return $returnArr;
    }

    function getStaff() {
        $requestData = $this->requestData;
        $data["staffArr"] = $this->mdl_staff->getApiStaffList($requestData);
        $data["organizationArr"] = $this->mdl_staff->getOrgList($requestData);
        $data["staffCatArr"] = $this->mdl_staff->getStaffCategoryList();
        return $data;
    }

    function getStaffInfo() {
        $requestData = $this->requestData;
        $validateParam = array("userAuthId", "recordId");
        $isError = $this->validateInput($validateParam, $requestData);
        $returnArr = array();
        $returnArr["errorMessage"] = "";
        $returnArr["error"] = false;
        if ($isError['error']) {
            $returnArr["errorMessage"] = $isError["errorMsg"];
            $returnArr["error"] = true;
        } else {
            $curRecId = $requestData["recordId"];
            $sucMsg = $this->mdl_staff->getStaffInfo($curRecId);
            $returnArr["recordInfo"] = $sucMsg;
            $data["assetArr"] = $this->mdl_staff->getAssetList($requestData);
            $data["staffCatArr"] = $this->mdl_staff->getStaffCategoryList();
            $returnArr["error"] = false;
        }
        return $returnArr;
    }

    function manageStaff() {
        $requestData = $this->requestData;
        $validateParam = array("userAuthId", "uname", 'userfirstname', 'staffcategoryid', 'contactpersonnumber', 'userstatus', 'createAction', 'stafforganizationid', 'staffassetid');
        if ($requestData['createAction'] == "add")
            $validateParam[] = 'password';
        $isError = $this->validateInput($validateParam, $requestData);
        $returnArr = array();
        $returnArr["errorMessage"] = "";
        $returnArr["error"] = false;
        if ($isError['error']) {
            $returnArr["errorMessage"] = $isError["errorMsg"];
            $returnArr["error"] = true;
        } else {
            $curRecId = $requestData["recordId"];
            $curUname = $requestData["uname"];
            $isUniqueRec = $this->mdl_staff->validateUname($curUname, $curRecId);
            if ($isUniqueRec > 0) {
                $returnArr["errorMessage"] = getMsgList(4);
                $returnArr["error"] = true;
            } else {
                $sucMsg = $this->mdl_staff->manageApiStaffInfo($requestData);
                $returnArr["errorMessage"] = $sucMsg;
                $returnArr["error"] = false;
            }
        }
        return $returnArr;
    }

    function deleteStaff() {
        $requestData = $this->requestData;
        $validateParam = array("userAuthId", "recordId");
        $isError = $this->validateInput($validateParam, $requestData);
        $returnArr = array();
        $returnArr["errorMessage"] = "";
        $returnArr["error"] = false;
        if ($isError['error']) {
            $returnArr["errorMessage"] = $isError["errorMsg"];
            $returnArr["error"] = true;
        } else {
            $curRecId = $requestData["recordId"];
            $curUname = $requestData["uname"];
            $sucMsg = $this->mdl_staff->deleteStaff($curRecId);
            $returnArr["errorMessage"] = $sucMsg;
            $returnArr["error"] = false;
        }
        return $returnArr;
    }

    function getEmergencyRequest() {
        $requestData = $this->requestData;
        $validateParam = array("userAuthId", "userType");
        $isError = $this->validateInput($validateParam, $requestData);
        $returnArr = array();
        $returnArr["errorMessage"] = "";
        $returnArr["error"] = false;
        if ($isError['error']) {
            $returnArr["errorMessage"] = $isError["errorMsg"];
            $returnArr["error"] = true;
        } else {
            $returnArr["recordArr"] = $this->mdl_emergencyrequest->getApiEmergencyRequestList();
        }
        return $returnArr;
    }

    function getEmergencyRequestInfo() {
        $requestData = $this->requestData;
        $validateParam = array("userAuthId", "recordId");
        $isError = $this->validateInput($validateParam, $requestData);
        $returnArr = array();
        $returnArr["errorMessage"] = "";
        $returnArr["error"] = false;
        if ($isError['error']) {
            $returnArr["errorMessage"] = $isError["errorMsg"];
            $returnArr["error"] = true;
        } else {
            $curRecId = $requestData["recordId"];
            $sucMsg = $this->mdl_emergencyrequest->getEmergencyRequestInfo($curRecId);
            $returnArr["recordInfo"] = $sucMsg;
            $returnArr["error"] = false;
        }
        return $returnArr;
    }

    function manageEmergencyRequest() {
        $requestData = $this->requestData;
        $validateParam = array("requestname", 'requestcontactnumber', 'requestlocation', 'placelatitude', 'placelongitude', 'requestdescription');
//        'requeststatus',
        $isError = $this->validateInput($validateParam, $requestData);
        $returnArr = array();
        $returnArr["errorMessage"] = "";
        $returnArr["error"] = false;
        if ($isError['error']) {
            $returnArr["errorMessage"] = $isError["errorMsg"];
            $returnArr["error"] = true;
        } else {
            $sucMsg = $this->mdl_emergencyrequest->manageApiEmergencyRequestInfo($requestData);
            $returnArr["errorMessage"] = $sucMsg;
            $returnArr["error"] = false;
        }
        return $returnArr;
    }

    function processEmergencyRequest() {
        $requestData = $this->requestData;
        $validateParam = array("userAuthId", "recordId", "processType");
        if ($requestData["processType"] == "reject")
            $validateParam[] = "requestreason";
        $isError = $this->validateInput($validateParam, $requestData);
        $returnArr = array();
        $returnArr["errorMessage"] = "";
        $returnArr["error"] = false;
        if ($isError['error']) {
            $returnArr["errorMessage"] = $isError["errorMsg"];
            $returnArr["error"] = true;
        } else {
            $sucMsg = $this->mdl_emergencyrequest->processEmergencyRequestInfo($requestData);
            $returnArr["errorMessage"] = $sucMsg;
            $returnArr["error"] = false;
        }
        return $returnArr;
    }

    function deleteEmergencyRequest() {
        $requestData = $this->requestData;
        $validateParam = array("userAuthId", "recordId");
        $isError = $this->validateInput($validateParam, $requestData);
        $returnArr = array();
        $returnArr["errorMessage"] = "";
        $returnArr["error"] = false;
        if ($isError['error']) {
            $returnArr["errorMessage"] = $isError["errorMsg"];
            $returnArr["error"] = true;
        } else {
            $curRecId = $requestData["recordId"];
            $curUname = $requestData["uname"];
            $sucMsg = $this->mdl_emergencyrequest->deleteEmergencyRequest($curRecId);
            $returnArr["errorMessage"] = $sucMsg;
            $returnArr["error"] = false;
        }
        return $returnArr;
    }

    function getMapDisplayInformation() {
        $requestData = $this->requestData;
        $returnArr["organizationArr"] = $this->mdl_organization->getApiOrganisationList($requestData);
        $returnArr["assetCategoryArr"] = $this->mdl_assetcategory->getApiAssetcategoryList($requestData);
        $returnArr["assetArr"] = $this->mdl_assets->getApiAssetsList($requestData);
        return $returnArr;
    }

    function getVolunteer() {
        $requestData = $this->requestData;
        $data["recordArr"] = $this->mdl_volunteer->getApiVolunteerList($requestData);
        return $data;
    }

    function getVolunteerInfo() {
        $requestData = $this->requestData;
        $validateParam = array("userAuthId", "recordId");
        $isError = $this->validateInput($validateParam, $requestData);
        $returnArr = array();
        $returnArr["errorMessage"] = "";
        $returnArr["error"] = false;
        if ($isError['error']) {
            $returnArr["errorMessage"] = $isError["errorMsg"];
            $returnArr["error"] = true;
        } else {
            $curRecId = $requestData["recordId"];
            $sucMsg = $this->mdl_volunteer->getVolunteerInfo($curRecId);
            $returnArr["recordInfo"] = $sucMsg;
            $returnArr["error"] = false;
        }
        return $returnArr;
    }

    function manageVolunteer() {
        $requestData = $this->requestData;
        $validateParam = array("userAuthId", "uname", 'userfirstname', 'contactpersonname', 'contactpersonnumber', 'userstatus');
        if ($requestData['recordId'] == "")
            $validateParam[] = 'password';
        $isError = $this->validateInput($validateParam, $requestData);
        $returnArr = array();
        $returnArr["errorMessage"] = "";
        $returnArr["error"] = false;
        if ($isError['error']) {
            $returnArr["errorMessage"] = $isError["errorMsg"];
            $returnArr["error"] = true;
        } else {
            $curRecId = $requestData["recordId"];
            $curUname = $requestData["uname"];
            $isUniqueRec = $this->mdl_volunteer->validateUname($curUname, $curRecId);
            if ($isUniqueRec > 0) {
                $returnArr["errorMessage"] = getMsgList(4);
                $returnArr["error"] = true;
            } else {
                $sucMsg = $this->mdl_volunteer->manageApiVolunteerInfo($requestData);
                $returnArr["errorMessage"] = $sucMsg;
                $returnArr["error"] = false;
            }
        }
        return $returnArr;
    }

    function deleteVolunteer() {
        $requestData = $this->requestData;
        $validateParam = array("userAuthId", "recordId");
        $isError = $this->validateInput($validateParam, $requestData);
        $returnArr = array();
        $returnArr["errorMessage"] = "";
        $returnArr["error"] = false;
        if ($isError['error']) {
            $returnArr["errorMessage"] = $isError["errorMsg"];
            $returnArr["error"] = true;
        } else {
            $curRecId = $requestData["recordId"];
            $curUname = $requestData["uname"];
            $sucMsg = $this->mdl_volunteer->deleteVolunteer($curRecId);
            $returnArr["errorMessage"] = $sucMsg;
            $returnArr["error"] = false;
        }
        return $returnArr;
    }

    function getEmergencyAlert() {
        $requestData = $this->requestData;
        $validateParam = array("userAuthId", "userType");
        $isError = $this->validateInput($validateParam, $requestData);
        $returnArr = array();
        $returnArr["errorMessage"] = "";
        $returnArr["error"] = false;
        if ($isError['error']) {
            $returnArr["errorMessage"] = $isError["errorMsg"];
            $returnArr["error"] = true;
        } else {
            $returnArr["recordArr"] = $this->mdl_emergencyalert->getApiEmergencyAlertList();
        }
        return $returnArr;
    }

    function getEmergencyAlertInfo() {
        $requestData = $this->requestData;
        $validateParam = array("userAuthId", "recordId");
        $isError = $this->validateInput($validateParam, $requestData);
        $returnArr = array();
        $returnArr["errorMessage"] = "";
        $returnArr["error"] = false;
        if ($isError['error']) {
            $returnArr["errorMessage"] = $isError["errorMsg"];
            $returnArr["error"] = true;
        } else {
            $curRecId = $requestData["recordId"];
            $sucMsg = $this->mdl_emergencyalert->getEmergencyAlertInfo($curRecId);
            $returnArr["recordInfo"] = $sucMsg;
            $returnArr["error"] = false;
        }
        return $returnArr;
    }

    function manageEmergencyAlert() {
        $requestData = $this->requestData;
        $validateParam = array("requestname", 'requestcontactnumber', 'requestlocation', 'placelatitude', 'placelongitude', 'requestdescription');
//        'requeststatus',
        $isError = $this->validateInput($validateParam, $requestData);
        $returnArr = array();
        $returnArr["errorMessage"] = "";
        $returnArr["error"] = false;
        if ($isError['error']) {
            $returnArr["errorMessage"] = $isError["errorMsg"];
            $returnArr["error"] = true;
        } else {
            $sucMsg = $this->mdl_emergencyalert->manageApiEmergencyAlertInfo($requestData);
            $returnArr["errorMessage"] = $sucMsg;
            $returnArr["error"] = false;
        }
        return $returnArr;
    }

    function deleteEmergencyAlert() {
        $requestData = $this->requestData;
        $validateParam = array("userAuthId", "recordId");
        $isError = $this->validateInput($validateParam, $requestData);
        $returnArr = array();
        $returnArr["errorMessage"] = "";
        $returnArr["error"] = false;
        if ($isError['error']) {
            $returnArr["errorMessage"] = $isError["errorMsg"];
            $returnArr["error"] = true;
        } else {
            $curRecId = $requestData["recordId"];
            $curUname = $requestData["uname"];
            $sucMsg = $this->mdl_emergencyalert->deleteEmergencyAlert($curRecId);
            $returnArr["errorMessage"] = $sucMsg;
            $returnArr["error"] = false;
        }
        return $returnArr;
    }

    function dashboardContent() {
        $returnArr["title"] = "New Zealand Defence Alert";
        $returnArr["content"] = "";
        return $returnArr;
    }

    function createNewUser() {
        $requestData = $this->requestData;
        $validateParam = array("uname", 'userfirstname', 'contactpersonname', 'contactpersonnumber', 'userstatus', 'usertype');
        $validateParam[] = 'password';
        $isError = $this->validateInput($validateParam, $requestData);
        $returnArr = array();
        $returnArr["errorMessage"] = "";
        $returnArr["error"] = false;
        if ($isError['error']) {
            $returnArr["errorMessage"] = $isError["errorMsg"];
            $returnArr["error"] = true;
        } else {
            $curRecId = $requestData["recordId"];
            $curUname = $requestData["uname"];
            $isUniqueRec = $this->mdl_organization->validateUname($curUname, $curRecId);
            if ($isUniqueRec > 0) {
                $returnArr["errorMessage"] = getMsgList(4);
                $returnArr["error"] = true;
            } else {
                $sucMsg = $this->mdl_organization->manageApiNewInfo($requestData);
                $returnArr["errorMessage"] = $sucMsg;
                $returnArr["error"] = false;
            }
        }
        return $returnArr;
    }

    function validateInput($requiredParam, $receivedArr) {
        $missingArr = array();
        foreach ($requiredParam as $key => $val) {
            if (isset($receivedArr[$val])) {
                if ($receivedArr[$val] == "")
                    $missingArr[] = $val;
            } else
                $missingArr[] = $val;
        }
        $returnArr['errorMsg'] = "";
        $returnArr['error'] = false;
        if (count($missingArr) > 0) {
            $returnArr['errorMsg'] = "Please enter " . implode(',', $missingArr);
            $returnArr['error'] = true;
        }

        return $returnArr;
    }

}
