<?php
$curUserId = $this->session->userdata("curUserId");
$curUserType = $this->session->userdata("userType");
$currentClass = $this->router->fetch_class();
$currentMethod = $this->router->fetch_method();
$currentMenu = "";
if ($currentClass == "admin" && $currentMethod != "changepassword")
    $currentMenu = "dashboard";
?>
<aside class="sidebar">
    <div class="sidebar-container">
        <div class="sidebar-header">
            <div class="brand">
                <div class="logo"> 
                    <span class="l l1"></span> <span class="l l2"></span> <span class="l l3"></span> <span class="l l4"></span> <span class="l l5"></span>
<!--                    <img src="<?php echo base_url("assets/image/logo.png") ?>" title="Asset Support Hub" style="max-height: 75px;" />-->
<!--                    <img src="<?php echo base_url("assets/image/logo.png") ?>" title="Asset Support Hub" />-->
                </div> Asset Support Hub 
            </div>
        </div>
        <nav class="menu">
            <ul class="nav metismenu" id="sidebar-menu">
                <li class="<?php if ($currentMenu == "dashboard") echo 'active'; ?>">
                    <a href="<?php echo getCurUserUrl("index"); ?>" ><i class="fa fa-home"></i> Dashboard</a>
                </li>
                <?php
                if ($curUserType == "admin") {
                    ?>
                    <li class="<?php if ($currentClass == "manageorganization") echo 'active'; ?>" >
                        <a href="<?php echo getCurUserUrl("organizationlist"); ?>"><i class="fa fa-sitemap"></i> Manage Organisation</a>
                    </li>                
                    <li  class="<?php if ($currentClass == "managecontroller") echo 'active'; ?>">
                        <a href="<?php echo getCurUserUrl("controllerlist"); ?>"><i class="fa fa-qq"></i> Manage Controller</a>
                    </li>
                    <li  class="<?php if ($currentClass == "manageassetcategory") echo 'active'; ?>">
                        <a href="<?php echo getCurUserUrl("assetcategory"); ?>" ><i class="fa fa-th-large"></i> Manage Asset Category</a>
                    </li>
                    <?php
                }
                if ($curUserType == "organization" || $curUserType == "admin") {
                    ?>
                    <li class="<?php if ($currentMenu == "manageassets") echo 'active'; ?>" >
                        <a href="<?php echo getCurUserUrl("manageassets"); ?>" ><i class="fa fa-th"></i> Manage Assets</a>
                    </li>
                    <?php
                }
                if ($curUserType == "controller" || $curUserType == "admin") {
                    ?>
                    <li  class="<?php if ($currentClass == "mapcontrol") echo 'active'; ?>">
                        <a href="<?php echo getCurUserUrl("mapcontrol"); ?>"><i class="fa fa-map-marker"></i> Map View</a>
                    </li>
                    <?php
                }
                ?>
            </ul>
        </nav>
    </div>    
</aside>
<div class="sidebar-overlay" id="sidebar-overlay"></div>

