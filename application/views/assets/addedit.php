<?php
$curUserType = getSessionVal("userType");
$curUserId = getSessionVal("curUserId");
?>
<script src="<?php echo base_url("assets/js/assets/addedit.js"); ?>"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBYD_Wl5R8IZPOZRbzn3AHbV76RLsd8m54&libraries=places&callback=initAutocomplete"
async defer></script>
<article class="content forms-page">
    <div class="title-block">
        <h3 class="title"> Manage Asset </h3>
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
                            ?> Asset
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
                        <div class="row">
                            <div class="col-lg-6"><div class="form-group">
                                    <label class="control-label">Name</label>
                                    <input class="form-control underlined" placeholder="Asset Name" name="assetname" id="assetname" type="text" value="<?php echo $assetname; ?>" />
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Quantity</label>
                                    <input class="form-control underlined" placeholder="Quantity" name="assetqty" id="assetqty" type="text" value="<?php echo $assetqty; ?>" />
                                </div>                                
                                <div class="form-group">
                                    <label class="control-label">Location</label>
                                    <input class="form-control underlined" placeholder="Location" name="assetlocation" id="assetlocation" type="text" value="<?php echo $assetlocation; ?>" onFocus="javascript:geolocate();" />
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Status</label>
                                    <select class="form-control underlined" id="assetstatus" name="assetstatus">
                                        <option value="">Select</option>
                                        <option value="active" <?php if ($assetstatus == "active") echo 'selected=""'; ?> >Active</option>
                                        <option value="in-active" <?php if ($assetstatus == "in-active") echo 'selected=""'; ?>>In-Active</option>                                        
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6"><div class="form-group">
                                    <label class="control-label">Category</label>
                                    <select class="form-control underlined" id="assetcategory" name="assetcategory">
                                        <option value="">Select</option>
                                        <?php
                                        foreach ($assetCatArr as $key => $val) {
                                            ?>
                                            <option value="<?php echo $val["_id"]; ?>" <?php echo ($val["_id"] == $assetcategory) ? 'selected=""' : ''; ?>><?php echo $val["categoryname"]; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>                            
                                </div>
                                <?php
                                if ($curUserType == "admin") {
                                    ?>
                                    <div class="form-group">
                                        <label class="control-label">Organisation</label>
                                        <select class="form-control underlined" id="assetorganizationid" name="assetorganizationid">
                                            <option value="">Select</option>
                                            <?php
                                            foreach ($orgListArr as $key => $val) {
                                                ?>
                                                <option value="<?php echo $val["_id"]; ?>" <?php echo ($val["_id"] == $assetorganizationid) ? 'selected=""' : ''; ?>><?php echo $val["userfirstname"]; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>                            
                                    </div>
                                    <?php
                                } else {
                                    ?>
                                    <input type="hidden" name="assetorganizationid" id="assetorganizationid" value="<?php echo $curUserId; ?>" >
                                    <?php
                                }
                                ?>
                                <div class="form-group">
                                    <label class="control-label">Description</label>
                                    <textarea class="form-control underlined" name="assetdescription" id="assetdescription"><?php echo $assetdescription ?></textarea>                                    
                                </div>                                        
                            </div>
                        </div>
                        <div class="pull-right">
                            <button type="submit" class="btn btn-success"><?php
                                if ($recordId > 0)
                                    echo 'Update';
                                else
                                    echo 'Save';
                                ?></button>
                            <button type="reset" class="btn btn-danger" onclick="javascript:window.location.href = '<?php echo getCurUserUrl("manageassets"); ?>';">Back</button>
                            <input type="hidden" name="recordId" id="recordId" value="<?php echo $recordId; ?>" >
                            <input type="hidden" name="assetlatitude" id="assetlatitude" value="<?php echo $assetlatitude ?>" >
                            <input type="hidden" name="assetlongitude" id="assetlongitude" value="<?php echo $assetlongitude ?>" >                                    
                        </div>
                    </form>
                </div>
            </div>            
        </div>
    </section>
</article>