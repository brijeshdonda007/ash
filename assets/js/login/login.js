$().ready(function () {
    $("#loginform").validate({
        rules: {
            email: {
                required: true,
                email: true
            },
            password: "required",
        },
        messages: {
            email: {required:"Please enter your E-mail"},
            password: "Please enter your Password",
        }
    });

});