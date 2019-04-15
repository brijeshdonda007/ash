<!doctype html>
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Asset Support Hub</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">                
        <link href="<?php echo base_url("assets/css/vendor.css"); ?>" rel="stylesheet">        
        <link id="theme-style" rel="stylesheet" href="<?php echo base_url("assets/css/app.css"); ?>" >
        <script type="text/javascript">
            //document.write('<link rel="stylesheet" id="theme-style" href="<?php echo base_url("assets/css/app.css"); ?>">');
        </script>       

<!--        <script src="<?php echo base_url("assets/js/jquery.validate.min.js"); ?>"></script>
        <script src="<?php echo base_url("assets/js/additional-methods.min.js"); ?>"></script>
        <script src="<?php echo base_url("assets/js/login/login.js"); ?>"></script>-->
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
        <div class="auth">
            <div class="auth-container">
                <div class="card">
                    <header class="auth-header">
                        <h1 class="auth-title">
                            <div class="logo"> 
                                <span class="l l1"></span> <span class="l l2"></span> <span class="l l3"></span> <span class="l l4"></span> <span class="l l5"></span>                                
                            </div> Asset Support Hub </h1>
                    </header>
                    <div class="auth-content">
                        <p class="text-xs-center">Please Sign In</p>
                        <?php
                        if ($error_msg != "") {
                            ?>
                            <div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <?php echo $error_msg; ?>
                            </div>
                            <?php
                        }
                        ?> 
                        <form role="form" method="post" id="login-form" name="login-form">
                            <div class="form-group"> 
                                <label for="username">Username</label> 
                                <input class="form-control underlined" placeholder="E-mail" name="email" id="email" type="email" autofocus value="<?php echo $email; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input class="form-control underlined" placeholder="Password" name="password" id="password" type="password" value="" required>
                            </div>                            
                            <div class="form-group"> <button type="submit" name="loginBtn" id="loginBtn" class="btn btn-block btn-primary">Login</button> </div>                            
                        </form>
                    </div>
                </div>                
            </div>
        </div>   

    </body>
</html>
