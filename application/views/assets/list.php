<?php
$curUserType = getSessionVal("userType");
?>
<script src="<?php echo base_url("assets/js/assets/list.js"); ?>"></script>
<article class="content static-tables-page">
    <div class="title-block">
        <h1 class="title"> Asset </h1>
    </div>
    <?php
    if ($sucMsg != "") {
        ?>
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <?php echo $sucMsg; ?>
        </div>
        <?php
    }
    ?>    
    <form role="form" method="post" id="dataform" name="dataform">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Name</label>
                            <input class="form-control" placeholder="Asset Name" name="filterassetname" id="filterassetname" type="text" value="<?php echo $filterassetname; ?>" />
                        </div>
                        <div class="form-group">
                            <label>Location</label>
                            <input class="form-control" placeholder="Location" name="filterassetlocation" id="filterassetlocation" type="text" value="<?php echo $filterassetlocation; ?>" />
                        </div>
                        <div class="form-group">
                            <label>Category</label>
                            <select class="form-control" id="filterassetcat" name="filterassetcat">
                                <option value="">Select</option>
                                <?php
                                foreach ($assetCatArr as $key => $val) {
                                    ?>
                                    <option value="<?php echo $val["_id"]; ?>" <?php echo ($val["_id"] == $filterassetcat) ? 'selected=""' : ''; ?>><?php echo $val["categoryname"]; ?></option>
                                    <?php
                                }
                                ?>
                            </select>                            
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Status</label>
                            <select class="form-control" id="filterstatus" name="filterstatus">
                                <option value="">Select</option>
                                <option value="active" <?php if ($filterstatus == "active") echo 'selected=""'; ?> >Active</option>
                                <option value="in-active" <?php if ($filterstatus == "in-active") echo 'selected=""'; ?>>In-Active</option>                                        
                            </select>                            
                        </div>
                        <?php
                        if ($curUserType == "admin") {
                            ?>
                            <div class="form-group">
                                <label>Organisation</label>
                                <select class="form-control" id="filterassetorg" name="filterassetorg">
                                    <option value="">Select</option>
                                    <?php
                                    foreach ($orgListArr as $key => $val) {
                                        ?>
                                        <option value="<?php echo $val["_id"]; ?>" <?php echo ($val["_id"] == $filterassetorg) ? 'selected=""' : ''; ?>><?php echo $val["userfirstname"]; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>                            
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="pull-right">
                    <button type="submit" name="searchResult" id="searchResult" value="Search" class="btn btn-primary">Search</button>
                    <button type="submit" name="resetSearch" id="resetSearch" value="resetSearch" class="btn btn-danger">Reset Search</button>
                </div>                
            </div>
        </div>
    </form>
    <br />
    <!-- /.row -->
    <form role="form" method="post" id="dataform" name="dataform">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-block">
                        <div class="card-title-block">
                            <h3 class="title"> Asset List </h3>
                            <div class="pull-right">
                                <a href="<?php echo getCurUserUrl('addeditassets/0'); ?>"><i class="fa fa-plus fa-fw"></i> Add Asset</a>
                                | <a href="javascript:ChangeStatus();"><i class="fa fa-recycle fa-fw"></i> Change Status</a>
                            </div>
                        </div>
                        <!-- /.panel-heading -->
                        <section class="example">
                            <table width="100%" class="table">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" value="" onclick="javascript:generalListClick(this)" id="genListChkBox"></th>
                                        <th>Name</th>
                                        <?php
                                        if ($curUserType == "admin") {
                                            ?>
                                            <th>Organisation</th>
                                            <?php
                                        }
                                        ?>
                                        <th>Quantity</th>
                                        <th>Location</th>
                                        <th>Category</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (count($dataArr) > 0 && $dataArr) {
                                        foreach ($dataArr as $curRec) {
                                            $dispName = $curRec["assetname"];
                                            $dispQty = $curRec["assetqty"];
                                            $dispLocation = $curRec["assetlocation"];
                                            $dispCategory = $curRec["assetcategory"];
                                            $dispStatus = ucfirst($curRec["assetstatus"]);
                                            $curRecId = $curRec["_id"];
                                            $dispOrganisation = $curRec["assetorganizationid"];
                                            foreach ($orgListArr as $key => $val) {
                                                if ($dispOrganisation == $val["_id"])
                                                    $dispOrganisation = $val["userfirstname"];
                                            }
                                            foreach ($assetCatArr as $key => $val) {
                                                if ($dispCategory == $val["_id"])
                                                    $dispCategory = $val["categoryname"];
                                            }
                                            ?>
                                            <tr class="odd gradeX">
                                                <td><input type="checkbox" value="<?php echo $curRecId; ?>" onclick="javascript:checkboxClick(this)" name="assetList[]" id="<?php echo $curRecId ?>catbox" class="listChk"></td>
                                                <td><?php echo ucfirst($dispName); ?></td>
                                                <?php
                                                if ($curUserType == "admin") {
                                                    ?>
                                                    <td><?php echo $dispOrganisation; ?></td>
                                                    <?php
                                                }
                                                ?>
                                                <td><?php echo $dispQty; ?></td>
                                                <td><?php echo $dispLocation; ?></td>
                                                <td><?php echo $dispCategory; ?></td>
                                                <td><?php echo $dispStatus; ?></td>
                                                <td>
                                                    <a title="Edit Record" href="<?php echo getCurUserUrl('addeditassets/' . $curRecId); ?>"><i class="fa fa-edit fa-fw"></i></a>
                                                    <a title="Delete Record" href="javascript:DeleteRec('<?php echo getCurUserUrl('deleteassets/' . $curRecId); ?>');"><i class="fa fa-remove fa-fw"></i></a>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    } else {
                                        ?>
                                        <tr>
                                            <td colspan="6" style="text-align: center;">Sorry No Record Found.</td>
                                        </tr>
                                        <?php
                                    }
                                    ?>                            
                                </tbody>
                            </table>
                        </section>                                    
                        <!-- /.panel-body -->
                    </div>                
                </div>
                <!-- /.panel -->
            </div>
            <!-- /.col-lg-12 -->
        </div>    
        <div class="modal fade" id="statusPopup">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Change Status</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Status</label>
                            <select class="form-control" id="assetstatus" name="assetstatus">
                                <option value="active" selected="" >Active</option>
                                <option value="in-active" >In-Active</option>                                        
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" value="changeStatus" name="changeStatus">Change Status</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- /.row -->    

</article>
