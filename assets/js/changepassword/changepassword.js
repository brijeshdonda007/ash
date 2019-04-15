$().ready(function () {
    $("#dataform").validate({
        rules: {
            opassword: {
                required: true,
            },
            npassword: "required",
            cpassword: {
                required: true,
                equalTo: "#npassword"
            },
        },
        messages: {
            opassword: {required: "Please enter your old password"},
            npassword: "Please enter your new password",
            cpassword: {
                required: "Please enter your confirm password",
                equalTo: "Please enter the same password as above"
            },
        }
    });

});