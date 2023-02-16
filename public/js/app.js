$(document).ajaxStart(function () {
    $.LoadingOverlaySetup({
        background: "rgba(218, 223, 225, 0.8)"
    });
    $.LoadingOverlay("show");
});

$(document).ajaxStop(function () {
    $.LoadingOverlay("hide");
});