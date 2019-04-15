<?php

//  to get instace of mongodb
function mongoDbInstance() {
    $mongoUrl = "mongodb://localhost:27017";
    require APPPATH . '..\mongodb\vendor\autoload.php'; // include Composer's autoloader
    $client = new MongoDB\Client($mongoUrl);
    return $client->assetsupporthub;
}

//to get mongodb id
function getMongoID($idVal) {
    return new MongoDB\BSON\ObjectID($idVal);
}

//  to print array
function pre($arr) {
    echo '<pre>';
    print_r($arr);
}

//  to get all general error msg
function getErrorMsg() {
    $CI = & get_instance();
    $tempArr = $CI->form_validation->error_array();
    if (count($tempArr) > 0) {
        foreach ($tempArr as $key => $val) {
            return $val;
            break;
        }
    }
}

// to get the post value
function getPostVal($key) {
    $CI = & get_instance();
    $val = $CI->input->post($key);
    if ($val != "")
        return $val;
    else
        return false;
}

// to get the session value
function getSessionVal($key) {
    $CI = & get_instance();
    $val = $CI->session->userdata($key);
    if ($val != "")
        return $val;
    else
        return false;
}

function setMsg($key, $val) {
    $CI = & get_instance();
    $CI->session->set_flashdata($key, $val);
    return true;
}

function getMsg($keyval) {
    $CI = & get_instance();
    return $CI->session->flashdata($keyval);
}

//  general array to manage all msgs in system
function getMsgList($key = "") {
    $msgListArr = array(
        0 => "Invalid email and password combination.",
        1 => "Your account is not active.Please contact administrator.",
        2 => "Invalid old password. Please enter correct password.",
        3 => "Password updated Successfully.",
        4 => "Please select another Username.",
        5 => "Record Added Sucessfully.",
        6 => "Record Updated Sucessfully.",
        7 => "Record Removed Sucessfully.",
        8   =>  "Please select another category name.",
        9   =>  "Invalid email address.",
        10   =>  "Error in sending email.",
    );
    if (isset($msgListArr[$key]))
        return $msgListArr[$key];
    else
        return $msgListArr;
}

//to check if user is logged in or not
function isUserLoggedin() {
    $CI = & get_instance();
    $currentClass = $CI->router->fetch_class();
    if ($currentClass == "admin" && $CI->session->userdata("adminId") != "")
        redirect("admin/index");
    else if ($currentClass == "organization" && $CI->session->userdata("orgId") != "")
        redirect("organization/index");
    else if ($currentClass == "controller" && $CI->session->userdata("controllerId") != "")
        redirect("controller/index");
    else
        return false;
}

function isAccessGrant() {
    $CI = & get_instance();
    $currentClass = $CI->router->fetch_class();
    $curUserType    =   $CI->session->userdata("userType");
    
    if ($CI->session->userdata("curUserId") == "")
        redirect("login");
//        die("if");    
//    else if ($curUserType == "organization" && $CI->session->userdata("curUserId") == "")
//        redirect("login");
//        die("else if");
//    else if ($curUserType == "controller" && $CI->session->userdata("curUserId") == "")
//        redirect("login");
//        die("else if 2");
    else
        return false;
}

function getCurUserUrl($backurl = "") {    
    $CI = & get_instance();
    $curUserType    =   $CI->session->userdata("userType");
    $currentClass = $CI->router->fetch_class();
    if ($curUserType == "admin")
        return site_url("admin/" . $backurl);
    else if ($curUserType == "organization")
        return site_url("organization/" . $backurl);
    else
        return site_url("controller/" . $backurl);
}
