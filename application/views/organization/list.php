<script src="<?php echo base_url("assets/js/organization/list.js"); ?>"></script>
<article class="content static-tables-page">
    <div class="title-block">
        <h1 class="title"> Organisation </h1>
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
                            <input class="form-control" placeholder="Organisation Name" name="filterfirstname" id="filterfirstname" type="text" value="<?php echo $filterfirstname; ?>" />
                        </div>
                        <div class="form-group">
                            <label>Contact Name</label>
                            <input class="form-control" placeholder="Contact Person Name" name="filtercontactperson" id="filtercontactperson" type="text" value="<?php echo $filtercontactperson; ?>" />
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Status</label>
                            <select class="form-control" id="filteruserstatus" name="filteruserstatus">
                                <option value="">Select</option>
                                <option value="active" <?php if ($filteruserstatus == "active") echo 'selected=""'; ?> >Active</option>
                                <option value="in-active" <?php if ($filteruserstatus == "in-active") echo 'selected=""'; ?>>In-Active</option>                                        
                            </select>                            
                        </div>
                        <div class="form-group">
                            <label>Contact Number</label>
                            <input class="form-control" placeholder="Contact Number" name="filtercontactnumber" id="filtercontactnumber" type="text" value="<?php echo $filtercontactnumber; ?>" />
                        </div>
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
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-block">
                    <div class="card-title-block">
                        <h3 class="title"> Organisation List </h3>
                        <div class="pull-right">
                            <a href="<?php echo getCurUserUrl('addeditorganization/0'); ?>"><i class="fa fa-plus fa-fw"></i> Add Organisation</a>
                        </div>
                    </div>
                    <!-- /.panel-heading -->
                    <section class="example">
                        <table width="100%" class="table">
                            <thead>
                                <tr>
                                    <th>Organisation Name</th>                                
                                    <th>Contact Person Detail</th>
                                    <th>User Name</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (count($dataArr) > 0 && $dataArr) {
                                    foreach ($dataArr as $curRec) {
                                        $dispName = $curRec["userfirstname"];
                                        $dispEmail = $curRec["uname"];
                                        $dispStatus = ucfirst($curRec["userstatus"]);
                                        $dispMobNo = ucfirst($curRec["contactpersonname"]) . ' (' . $curRec["contactpersonnumber"] . ')';
                                        $curRecId = $curRec["_id"];
                                        ?>
                                        <tr class="odd">
                                            <td><?php echo ucfirst($dispName); ?></td>                                        
                                            <td><?php echo $dispMobNo; ?></td>
                                            <td><?php echo $dispEmail; ?></td>
                                            <td><?php echo $dispStatus; ?></td>
                                            <td>
                                                <a title="Edit Record" href="<?php echo getCurUserUrl('addeditorganization/' . $curRecId); ?>"><i class="fa fa-edit fa-fw"></i></a>
                                                <a title="Delete Record" href="javascript:DeleteRec('<?php echo getCurUserUrl('deleteorganization/' . $curRecId); ?>');"><i class="fa fa-remove fa-fw"></i></a>
                                                <a title="Preview Login" href="<?php echo getCurUserUrl('loginPreview/' . $curRecId); ?>"><i class="fa fa-unlock fa-fw"></i></a>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="5" style="text-align: center;">Sorry No Record Found.</td>
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
    <!-- /.row -->    
</article>
