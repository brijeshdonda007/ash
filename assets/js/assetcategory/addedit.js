$().ready(function () {
    var assetCatAddEdit = {
        rules: {
            categoryname: {
                required: true,
            },
            categorystatus: {
                required: true,
            },
        },
        messages: {
            categoryname: {
                required: "Please enter category name.",
            },
            categorystatus: {
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
    $.extend(assetCatAddEdit, config.validations);
    $("#dataform").validate(assetCatAddEdit);
});