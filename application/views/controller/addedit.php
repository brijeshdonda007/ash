<script src="<?php echo base_url("assets/js/controller/addedit.js"); ?>"></script>
<article class="content forms-page">
    <div class="title-block">
        <h1 class="page-header">Manage Controller</h1>
    </div>
    <section class="section">
        <div class="row sameheight-container">
            <div class="col-md-12 authcontainer">
                <div class="card card-block sameheight-item">
                    <div class="title-block">
                        <h3 class="title">
                            <?php
                            if ($recordId > 0)
                                echo 'Edit';
                            else
                                echo 'Add';
                            ?> Controller
                        </h3>
                    </div>
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
                    <form role="form" method="post" id="dataform" name="dataform">
                        <div class="form-group">
                            <label class="control-label">User Name</label>
                            <input class="form-control underlined" placeholder="User Name" name="uname" id="uname" type="text" value="<?php echo $uname; ?>" />
                        </div>
                        <div class="form-group">
                            <label class="control-label">Password</label>
                            <input class="form-control underlined" placeholder="Password" name="password" id="password" type="password" value="">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Controller Name</label>
                            <input class="form-control underlined" placeholder="Controller Name" name="userfirstname" id="userfirstname" type="text" value="<?php echo $userfirstname; ?>" />
                        </div>
                        <!--                                <div class="form-group">
                                                            <label class="control-label">Contact Person Name</label>
                                                            <input class="form-control underlined" placeholder="Name" name="contactpersonname" id="contactpersonname" type="text" value="<?php echo $contactpersonname; ?>" />
                                                        </div>-->
                        <div class="form-group">
                            <label class="control-label">Contact Number</label>
                            <input class="form-control underlined" placeholder="Contact Number" name="contactpersonnumber" id="contactpersonnumber" type="text" value="<?php echo $contactpersonnumber; ?>" />
                        </div>
                        <div class="form-group">
                            <label class="control-label">Status</label>
                            <select class="form-control underlined" id="userstatus" name="userstatus">
                                <option value="">Select</option>
                                <option value="active" <?php if ($userstatus == "active") echo 'selected=""'; ?> >Active</option>
                                <option value="in-active" <?php if ($userstatus == "in-active") echo 'selected=""'; ?>>In-Active</option>                                        
                            </select>
                        </div>

                        <button type="submit" class="btn btn-success"><?php
                            if ($recordId > 0)
                                echo 'Update';
                            else
                                echo 'Save';
                            ?></button>
                        <button type="reset" class="btn btn-danger" onclick="javascript:window.location.href = '<?php echo getCurUserUrl("controllerlist"); ?>';">Back</button>
                        <input type="hidden" name="recordId" id="recordId" value="<?php echo $recordId; ?>" >
                    </form>
                </div>
            </div>            
        </div>
    </section>
</article>