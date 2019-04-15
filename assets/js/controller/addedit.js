$().ready(function () {
    var controllerAddEdit   =   {
        rules: {
            uname: {
                required: true,
            },
//            password: "required",
            userfirstname: {
                required: true,
            },
//            contactpersonname: {
//                required: true,
//            },
            contactpersonnumber: {
                required: true,
            },
            userstatus: {
                required: true,
            },
        },
        messages: {
            uname: {required: "Please enter your User Name."},
//            password: "Please enter your password",
            userfirstname: {
                required: "Please enter contact person name.",
            },
            contactpersonnumber: {
                required: "Please enter contact number.",
            },
            userstatus: {
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
    $.extend(controllerAddEdit, config.validations);
    $("#dataform").validate(controllerAddEdit);

});