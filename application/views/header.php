<!doctype html>
<html class="no-js" lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Asset Support Hub</title>

        <link href="<?php echo base_url("assets/css/vendor.css"); ?>" rel="stylesheet">        
        <link id="theme-style" rel="stylesheet" href="<?php echo base_url("assets/css/app.css"); ?>" >
    </head>

    <body>
        <!-- Reference block for JS -->
        <div class="ref" id="ref">
            <div class="color-primary"></div>
            <div class="chart">
                <div class="color-primary"></div>
                <div class="color-secondary"></div>
            </div>
        </div>
        <script src="<?php echo base_url("assets/js/vendor.js"); ?>"></script>        
        <script src="<?php echo base_url("assets/js/app.js"); ?>"></script>

        <div id="main-wrapper">
            <div class="app" id="app">
                <header class="header">
                    <div class="header-block header-block-collapse hidden-lg-up"> <button class="collapse-btn" id="sidebar-collapse-btn">
                            <i class="fa fa-bars"></i>
                        </button> </div>

                    <div class="header-block header-block-nav">
                        <ul class="nav-profile">
                            <li class="profile dropdown">
                                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="javascript:;" role="button" aria-haspopup="true" aria-expanded="false">
                                    <span class="name">
                                        Welcome "<?php echo getSessionVal("userfirstname"); ?>"
                                    </span> </a>
                                <div class="dropdown-menu profile-dropdown-menu" aria-labelledby="dropdownMenu1"> 
                                    <a class="dropdown-item" href="<?php echo getCurUserUrl("changepassword"); ?>">
                                        <i class="fa fa-gear icon"></i>
                                        Change Password
                                    </a>
                                    <!--                                    <a class="dropdown-item" href="#">
                                                                            <i class="fa fa-bell icon"></i>
                                                                            Notifications
                                                                        </a>-->
                                    <?php
                                    $isPreviewLogin = getSessionVal('isPreviewLogin');
                                    $curUserType = getSessionVal('userType');
                                    if ($isPreviewLogin && $curUserType != "admin") {
                                        ?>
                                        <a class="dropdown-item" href="<?php echo getCurUserUrl("loginBackAdmin"); ?>">
                                            <i class="fa fa-backward icon"></i>
                                            Back as Admin
                                        </a>                            
                                        <?php
                                    }
                                    ?>
                                    <div class="dropdown-divider"></div> <a class="dropdown-item" href="<?php echo getCurUserUrl("logout"); ?>">
                                        <i class="fa fa-power-off icon"></i>
                                        Logout
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </header>
                <?php $this->load->view("leftmenu"); ?>