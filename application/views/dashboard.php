<?php
$curUserType = getSessionVal("userType");
?>
<article class="content dashboard-page">
    <section class="section">
        <div class="row sameheight-container">
            <div class="col col-xs-12 col-sm-12 col-md-12 col-xl-5 stats-col">
                <div class="card sameheight-item stats" data-exclude="xs">
                    <div class="card-block">
                        <div class="title-block">
                            <h4 class="title"> Dashboard </h4>
                            <p class="title-description"></p>
                        </div>
                        <div class="row row-sm stats-container">
                            <?php
                            if ($curUserType == "admin" || $curUserType == "controller") {
                                $organizationUrl = getCurUserUrl("mapcontrol");
                                if ($curUserType == "admin")
                                    $organizationUrl = getCurUserUrl("organizationlist");
                                ?>                            
                                <div class="col-xs-12 col-sm-6 stat-col">
                                    <div class="stat-icon"> <i class="fa fa-sitemap"></i> </div>
                                    <div class="stat">
                                        <div class="value"> <?php echo $organizationCount; ?> </div>
                                        <div class="name"> <a href="<?php echo $organizationUrl; ?>">Organisations</a> </div>
                                    </div> <progress class="progress stat-progress" value="100" max="100">
                                        <div class="progress">
                                            <span class="progress-bar" style="width: 100%;"></span>
                                        </div>
                                    </progress> </div>
                                <?php
                            }
                            if ($curUserType == "admin" || $curUserType == "organization")
                                $assetUrl = getCurUserUrl("manageassets");
                            else
                                $assetUrl = getCurUserUrl("mapcontrol");
                            ?>

                            <div class="col-xs-12 col-sm-6 stat-col">
                                <div class="stat-icon"> <i class="fa fa-th"></i> </div>
                                <div class="stat">
                                    <div class="value"> <?php echo $assetsCount; ?> </div>
                                    <div class="name"> <a href="<?php echo $assetUrl; ?>">Assets</a> </div>
                                </div> <progress class="progress stat-progress" value="100" max="100">
                                    <div class="progress">
                                        <span class="progress-bar" style="width: 100%;"></span>
                                    </div>
                                </progress>
                            </div>                            
                        </div>
                    </div>
                </div>
            </div>

            <?php
            if ($curUserType == "controller") {
                ?>
                <div class="col col-xs-12 col-sm-12 col-md-12 col-xl-5 stats-col">
                    <div class="card sameheight-item stats" data-exclude="xs">
                        <div class="card-block">                        
                            <div class="row row-sm stats-container">
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <div class="header-block">
                                            <p class="title"> Emergency Status </p>
                                        </div>
                                    </div>
                                    <div class="card-block">
                                        <?php
                                        foreach ($emergencyContent->item as $curInfo) {
                                            $curTitle = $curInfo->title;
                                            $curDes = $curInfo->description;
                                            $curClass = "left";
                                            if ($i % 2 == 0 && $i > 1) {
                                                $curClass = "right";
                                            }
                                            ?>
                                            <div>
                                                <h4>
                                                    <?php echo $curTitle; ?>
                                                </h4>
                                                <p>
                                                    <?php echo $curDes; ?>
                                                </p>
                                            </div>
                                            <div class="clear" style="clear: both;"></div>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col col-xs-12 col-sm-12 col-md-12 col-xl-5 stats-col">
                    <div class="card stats" data-exclude="xs">
                        <div class="card-block" >
                            <div class="row row-sm stats-container">
                                <a class="twitter-timeline" data-height="550" data-width="550" href="https://twitter.com/NZcivildefence">Tweets by NZcivildefence</a>
                                <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>               
        </div>
    </section>
</article>


