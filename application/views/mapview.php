<?php
$configLat = $this->config->item('defaultLat');
$configLng = $this->config->item('defaultLng');
$tempArr = array();
foreach ($orgListArr as $orgInfo) {
    $curID = $orgInfo["_id"]->__toString();
    $tempArr[$curID] = $orgInfo["userfirstname"];
}
$orgInfoArr = $tempArr;
$tempArr = array();

foreach ($dataArr as $assetInfo) {
    $tempVal = $assetInfo;
    $tempVal["orgName"] = ucfirst($orgInfoArr[$assetInfo["assetorganizationid"]]);
    $tempVal["labelVal"] = substr($tempVal["orgName"], 0, 2);
    $tempArr[] = $tempVal;
}
$dataArr = $tempArr;
//pre($dataArr);die;
?>
<script type="text/javascript">
    var configLat = <?php echo $configLat ?>;
    var configLng = <?php echo $configLng ?>;
    var assetArr = <?php echo json_encode($dataArr); ?>;
    var baseUrl = '<?php echo base_url("assets/image/"); ?>';
    console.log(baseUrl);
</script>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBYD_Wl5R8IZPOZRbzn3AHbV76RLsd8m54&callback=initialize">
</script>
<script src="<?php echo base_url("assets/js/map.js"); ?>"></script>

<article class="content cards-page">
    <div class="title-block">
        <h3 class="title"> Map </h3>
    </div>
    <section class="section">
        <div class="row">
            <div class="col-xl-2">
                <div class="card card-primary">
                    <div class="card-header">
                        <div class="header-block">
                            <p class="title"> Category </p>
                        </div>
                    </div>
                    <div class="card-block">
                        <?php
                        if (count($assetCatArr) > 0) {
                            ?>
                            <div>
                                <label>
                                    <input class="checkbox" type="checkbox" value="" onclick="javascript:generalCatClick(this)" checked="" id="genCatbox">
                                    <span>Select All</span>
                                </label>
                            </div>
                            <?php
                        }
                        foreach ($assetCatArr as $key => $val) {
                            ?>
                            <div>
                                <label>
                                    <input class="checkbox categoryChk" type="checkbox" value="<?php echo $val["_id"]; ?>" onclick="javascript:categoryClick(this, '<?php echo $val["_id"] ?>')" checked="" id="<?php echo $val["_id"] ?>catbox">
                                    <span><?php echo $val["categoryname"]; ?></span>
                                </label>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="card card-info">
                    <div class="card-header">
                        <div class="header-block">
                            <p class="title"> Organisation </p>
                        </div>
                    </div>
                    <div class="card-block">
                        <?php
                        if (count($orgListArr) > 0) {
                            ?>
                            <div>
                                <label>
                                    <input class="checkbox" type="checkbox" value="" onclick="javascript:generalOrgClick(this)" checked="" id="genOrgbox">
                                    <span>Select All</span>
                                </label>
                            </div>                            
                            <?php
                        }
                        foreach ($orgListArr as $key => $val) {
                            ?>
                            <div>
                                <label>
                                    <input class="checkbox organizationChk" type="checkbox" value="<?php echo $val["_id"]; ?>" onclick="javascript:organizationClick(this, '<?php echo $val["_id"] ?>')" checked="" id="<?php echo $val["_id"] ?>orgbox">
                                    <span><?php echo $val["userfirstname"]; ?></span>
                                </label>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-xl-10">
                <div class="card card-success">
                    <div class="card-header">
                        <div class="header-block">
                            <p class="title"> Map View </p>
                        </div>
                    </div>
                    <div class="card-block">
                        <div id="mapcontrol" style="height: 550px;"></div>                
                    </div>
                </div>
            </div>                        
        </div>
    </section>    
</article>