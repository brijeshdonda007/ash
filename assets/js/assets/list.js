function DeleteRec(deleteUrl) {
    if (confirm("Are you sure want to delete record?"))
        window.location.href = deleteUrl;
}


function generalListClick(box) {
    if (box.checked) {
        selectAllList();
    } else {
        unselectAllList();
    }
}

function selectAllList() {
    $(".listChk").each(function () {
        var curCatId = $(this).val();
        $(this).prop('checked', true);
    })
}

function unselectAllList() {
    $(".listChk").each(function () {
        var curCatId = $(this).val();
        $(this).prop('checked', false)
    })
}

function manageCatSelectAll() {
    var isallChecked = true;
    $(".listChk").each(function () {
        if ($(this).prop("checked") == false) {
            isallChecked = false;
        }
    });
    if (isallChecked)
        $("#genListChkBox").prop('checked', true);
    else
        $("#genListChkBox").prop('checked', false);
}
function checkboxClick() {
    manageCatSelectAll();
}

function ChangeStatus(){
    var isanyChecked = false;
    $(".listChk").each(function () {
        if ($(this).prop("checked") == true && isanyChecked === false) {
            isanyChecked = true;
        }
    });
    if (isanyChecked)
        $('#statusPopup').modal('show')
    else
        alert("Please select at least one record to change status.");
}