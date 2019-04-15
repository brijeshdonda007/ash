var gmarkers = [];
var gicons = [];
var map = null;
var infowindow;
var iconImage;
var iconShadow;

function getMarkerImage(iconColor) {
    if ((typeof (iconColor) == "undefined") || (iconColor == null)) {
        iconColor = "red";
    }
    if (!gicons[iconColor]) {
        gicons[iconColor] = new google.maps.MarkerImage("mapIcons/marker_" + iconColor + ".png",
                // This marker is 20 pixels wide by 34 pixels tall.
                new google.maps.Size(20, 34),
                // The origin for this image is 0,0.
                new google.maps.Point(0, 0),
                // The anchor for this image is at 6,20.
                new google.maps.Point(9, 34));
    }
    return gicons[iconColor];

}

function category2color(category) {
    var myArray = ['red', 'blue', 'green', 'yellow', 'ping', 'black', 'white'];
    return myArray[Math.floor(Math.random() * myArray.length)];
}


// A function to create the marker and set up the event window
function createMarker(latlng, name, html, category, organizationid, labelVal, curStatus) {
    var imgname =   'red.png';
    if(curStatus == "active")
        imgname =   'green.png';
    var image = {
          url: baseUrl + imgname,
          // This marker is 20 pixels wide by 32 pixels high.
          size: new google.maps.Size(32, 32),
          // The origin for this image is (0, 0).
          origin: new google.maps.Point(0, 0),
          // The anchor for this image is the base of the flagpole at (0, 32).
          anchor: new google.maps.Point(0, 32)
        };
        //console.log(image);
    var contentString = html;
    var marker = new google.maps.Marker({
        position: latlng,
        icon: image,
//        shadow: iconShadow,
        map: map,
        title: name,
        zIndex: Math.round(latlng.lat() * -100000) << 5,
        label: labelVal
    });
    // === Store the category and name info as a marker properties ===
    marker.mycategory = category;
    marker.myname = name;
    marker.myorganizationid = organizationid;
    gmarkers.push(marker);
    google.maps.event.addListener(marker, 'click', function () {
        infowindow.setContent(contentString);
        infowindow.open(map, marker);
    });
}

// == shows all markers of a particular category, and ensures the checkbox is checked ==
function showCategory(category) {
    for (var i = 0; i < gmarkers.length; i++) {
        if (gmarkers[i].mycategory == category) {
            gmarkers[i].setVisible(true);
//            var curOrgId    =   gmarkers[i].myorganizationid;
//            document.getElementById(curOrgId + "orgbox").checked = true;
        }
    }
    document.getElementById(category + "catbox").checked = true;
}

// == hides all markers of a particular category, and ensures the checkbox is cleared ==
function hideCategory(category) {
    for (var i = 0; i < gmarkers.length; i++) {
        if (gmarkers[i].mycategory == category) {
            gmarkers[i].setVisible(false);
//            var curOrgId    =   gmarkers[i].myorganizationid;
//            document.getElementById(curOrgId + "orgbox").checked = false;
        }
    }
    document.getElementById(category + "catbox").checked = false;
    infowindow.close();
}

// == a checkbox has been clicked ==
function categoryClick(box, categoryID) {
    if (box.checked) {
        showCategory(categoryID);
    } else {
        hideCategory(categoryID);
    }
    manageCatSelectAll();
}

// == shows all markers of a particular organizationid, and ensures the checkbox is checked ==
function showOrganisation(organizationid) {
    for (var i = 0; i < gmarkers.length; i++) {
        if (gmarkers[i].myorganizationid == organizationid) {
            gmarkers[i].setVisible(true);
        }
    }
    document.getElementById(organizationid + "orgbox").checked = true;
}

// == hides all markers of a particular organizationid, and ensures the checkbox is cleared ==
function hideOrganisation(organizationid) {
    for (var i = 0; i < gmarkers.length; i++) {
        if (gmarkers[i].myorganizationid == organizationid) {
            gmarkers[i].setVisible(false);
        }
    }
    document.getElementById(organizationid + "orgbox").checked = false;
    infowindow.close();
}

// == a checkbox has been clicked ==
function organizationClick(box, orgId) {
    if (box.checked) {
        showOrganisation(orgId);
    } else {
        hideOrganisation(orgId);
    }
    manageOrgSelectAll();
}

function generalCatClick(box) {
    if (box.checked) {
        selectAllCat();
    } else {
        unselectAllCat();
    }
}

function selectAllCat() {
    $(".categoryChk").each(function () {
        var curCatId = $(this).val();
        $(this).prop('checked', true);
        showCategory(curCatId);
    })
}

function unselectAllCat() {
    $(".categoryChk").each(function () {
        var curCatId = $(this).val();
        $(this).prop('checked', false);
        hideCategory(curCatId);
    })
}

function generalOrgClick(box) {    
    if (box.checked) {
        selectAllOrg();
    } else {
        unselectAllOrg();
    }
}

function selectAllOrg() {
    $(".organizationChk").each(function () {
        var curOrgId = $(this).val();
        $(this).prop('checked', true);
        showOrganisation(curOrgId);
    })
}

function unselectAllOrg() {
    $(".organizationChk").each(function () {
        var curOrgId = $(this).val();
        $(this).prop('checked', false);
        hideOrganisation(curOrgId);
    })
}

function manageOrgSelectAll() {
    var isallChecked = true;
    $(".organizationChk").each(function () {
        if ($(this).prop("checked") == false) {
            isallChecked = false;
        }
    });
    if (isallChecked)
        $("#genOrgbox").prop('checked', true);
    else
        $("#genOrgbox").prop('checked', false);
}

function manageCatSelectAll() {
    var isallChecked = true;
    $(".categoryChk").each(function () {
        if ($(this).prop("checked") == false) {
            isallChecked = false;
        }
    });
    if (isallChecked)
        $("#genCatbox").prop('checked', true);
    else
        $("#genCatbox").prop('checked', false);
}

function initialize() {
    var myOptions = {
        zoom: 8,
        center: new google.maps.LatLng(configLat, configLng),
        mapTypeId: google.maps.MapTypeId.ROADMAP
    }
    map = new google.maps.Map(document.getElementById("mapcontrol"), myOptions);
    infowindow = new google.maps.InfoWindow(
            {
                size: new google.maps.Size(150, 50)
            });

    google.maps.event.addListener(map, 'click', function () {
        infowindow.close();
    });
    gicons["in-active"] = new google.maps.MarkerImage("mapIcons/marker_red.png",
            // This marker is 20 pixels wide by 34 pixels tall.
            new google.maps.Size(20, 34),
            // The origin for this image is 0,0.
            new google.maps.Point(0, 0),
            // The anchor for this image is at 9,34.
            new google.maps.Point(9, 34));
    gicons["active"] = new google.maps.MarkerImage("mapIcons/marker_green.png",
            // This marker is 20 pixels wide by 34 pixels tall.
            new google.maps.Size(20, 34),
            // The origin for this image is 0,0.
            new google.maps.Point(0, 0),
            // The anchor for this image is at 9,34.
            new google.maps.Point(9, 34));
    gicons["blue"] = new google.maps.MarkerImage("mapIcons/marker_blue.png",
            // This marker is 20 pixels wide by 34 pixels tall.
            new google.maps.Size(20, 34),
            // The origin for this image is 0,0.
            new google.maps.Point(0, 0),
            // The anchor for this image is at 9,34.
            new google.maps.Point(9, 34));
    iconImage = new google.maps.MarkerImage('mapIcons/marker_red.png',
            // This marker is 20 pixels wide by 34 pixels tall.
            new google.maps.Size(20, 34),
            // The origin for this image is 0,0.
            new google.maps.Point(0, 0),
            // The anchor for this image is at 9,34.
            new google.maps.Point(9, 34));
    iconShadow = new google.maps.MarkerImage('http://www.google.com/mapfiles/shadow50.png',
            // The shadow image is larger in the horizontal dimension
            // while the position and offset are the same as for the main image.
            new google.maps.Size(37, 34),
            new google.maps.Point(0, 0),
            new google.maps.Point(9, 34));

    for (var i = 0; i < assetArr.length; i++) {
        var lat = parseFloat(assetArr[i].assetlatitude);
        var lng = parseFloat(assetArr[i].assetlongitude);
        var point = new google.maps.LatLng(lat, lng);
        var address = assetArr[i].assetlocation;
        var name = assetArr[i].assetname;
        var qty = assetArr[i].assetqty;
        var description = assetArr[i].assetdescription;
        var orgName = assetArr[i].orgName;
        var organizationid = assetArr[i].assetorganizationid;
        var labelVal = assetArr[i].labelVal;
        var html = "<b>" + name + " (" + orgName + ") <\/b><p>" + qty + "- " + description + "<\/br> " + address + "<\/p> ";
        var category = assetArr[i].assetcategory;
        var curStatus = assetArr[i].assetstatus;
        var marker = createMarker(point, name, html, category, organizationid, labelVal, curStatus);
    }
}

