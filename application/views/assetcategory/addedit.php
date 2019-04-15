<script src="<?php echo base_url("assets/js/assetcategory/addedit.js"); ?>"></script>
<article class="content forms-page">
    <div class="title-block">
        <h3 class="title"> Manage Asset Category </h3>
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
                            ?> Asset Category
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
                            <label class="control-label">Asset Category Name</label>
                            <input class="form-control underlined" placeholder="Asset Category Name" name="categoryname" id="categoryname" type="text" value="<?php echo $categoryname; ?>" />
                        </div>
                        <div class="form-group">
                            <label class="control-label">Status</label>
                            <select class="form-control underlined" id="categorystatus" name="categorystatus">
                                <option value="">Select</option>
                                <option value="active" <?php if ($categorystatus == "active") echo 'selected=""'; ?> >Active</option>
                                <option value="in-active" <?php if ($categorystatus == "in-active") echo 'selected=""'; ?>>In-Active</option>                                        
                            </select>
                        </div>

                        <button type="submit" class="btn btn-success"><?php
                            if ($recordId > 0)
                                echo 'Update';
                            else
                                echo 'Save';
                            ?></button>
                        <button type="reset" class="btn btn-danger" onclick="javascript:window.location.href = '<?php echo getCurUserUrl("assetcategory"); ?>';">Back</button>
                        <input type="hidden" name="recordId" id="recordId" value="<?php echo $recordId; ?>" >
                    </form>
                </div>
            </div>            
        </div>
    </section>
</article>