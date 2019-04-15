<script src="<?php echo base_url("assets/js/changepassword/changepassword.js"); ?>"></script>
<div id="page-wrapper" style="min-height: 623px;">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Change Password</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Change Password
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <?php
                            if ($sucMsg != "") {
                                ?>
                                <div class="alert alert-success alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <?php echo $sucMsg; ?>
                                </div>
                                <?php
                            }
                            if ($error_msg != "") {
                                ?>
                                <div class="alert alert-danger alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <?php echo $error_msg; ?>
                                </div>
                                <?php
                            }
                            ?> 
                            <form role="form" method="post" id="dataform" name="dataform">
                                <div class="form-group">
                                    <label>Old Password</label>
                                    <input class="form-control" placeholder="Old Password" name="opassword" id="opassword" type="password" value="">
                                </div>
                                <div class="form-group">
                                    <label>New Password</label>
                                    <input class="form-control" placeholder="Password" name="npassword" id="npassword" type="password" value="">
                                </div>
                                <div class="form-group">
                                    <label>Confirm Password</label>
                                    <input class="form-control" placeholder="Confirm Password" name="cpassword" id="cpassword" type="password" value="">
                                </div>

                                <button type="submit" class="btn btn-success">Update</button>
                                <button type="reset" class="btn btn-danger" onclick="javascript:window.location.href='<?php echo getCurUserUrl("index"); ?>';">Back</button>
                            </form>
                        </div>                        
                    </div>
                    <!-- /.row (nested) -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>