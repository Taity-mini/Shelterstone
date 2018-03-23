$(document).ready(function () {
    $("#revealEmails").click(function () {
        $(".emailHider").toggle();
    });
});

$(function() {
    $('[type="date"]').datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat:'yy-mm-dd',
    });
});

function toggle_visibility(id) {
    var e = document.getElementById(id);
    if(e.style.display == 'block')
        e.style.display = 'none';
    else
        e.style.display = 'block';
}