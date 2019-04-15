$().ready(function () {
    var organizationAddEdit = {
        rules: {
            uname: {
                required: true,
            },
//            password: "required",
            userfirstname: {
                required: true,
            },
            contactpersonname: {
                required: true,
            },
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
                required: "Please enter organization name.",
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
    $.extend(organizationAddEdit, config.validations);
    $("#dataform").validate(organizationAddEdit);
});