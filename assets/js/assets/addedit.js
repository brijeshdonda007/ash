$().ready(function () {
    var assetAddEdit    =   {
        rules: {
            assetname: {
                required: true,
            },
            assetqty: {
                required: true,
                digits: true
            },
            assetlocation: {
                required: true,
            },
            assetcategory: {
                required: true,
            },
            assetorganizationid: {
                required: true,
            },
            assetstatus: {
                required: true,
            },
        },
        messages: {
            assetname: {
                required: "Please enter name.",
            },
            assetlocation: {
                required: "Please enter location.",
            },
            assetcategory: {
                required: "Please select category.",
            },
            assetorganizationid: {
                required: "Please select organization.",
            },
            assetstatus: {
                required: "Please select status.",
            },
        },
        invalidHandler: function () {
            animate({
                name: 'shake',
                selector: '.authcontainer > .card'
            });
        }
    };
    $.extend(assetAddEdit, config.validations);
    $("#dataform").validate(assetAddEdit);
});

var placeSearch, assetlocation;
function initAutocomplete() {
    assetlocation = new google.maps.places.Autocomplete((document.getElementById('assetlocation')),
            {types: ['geocode']});
    assetlocation.addListener('place_changed', fillInAddress);
}

function fillInAddress() {
    var place = assetlocation.getPlace();
    var latitude    =   place.geometry.location.lat();
    var longitude   =   place.geometry.location.lng();
    $("#assetlatitude").val(latitude);
    $("#assetlongitude").val(longitude);
}

// Bias the assetlocation object to the user's geographical location,
// as supplied by the browser's 'navigator.geolocation' object.
function geolocate() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            var geolocation = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };
            var circle = new google.maps.Circle({
                center: geolocation,
                radius: position.coords.accuracy
            });
            assetlocation.setBounds(circle.getBounds());
        });
    }
}