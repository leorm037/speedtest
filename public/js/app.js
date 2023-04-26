$(document).ajaxStart(function () {
    $.LoadingOverlaySetup({
        background: "rgba(218, 223, 225, 0.8)"
    });
    $.LoadingOverlay("show");
});

$(document).ajaxStop(function () {
    $.LoadingOverlay("hide");
});

$.Loading.setDefaults({
    message: LOADING_MESSAGE,
    stoppable: false,
    onStart: function (loading) {
        loading.overlay.slideDown(400);
    },
    onStop: function (loading) {
        loading.overlay.slideUp(400);
    }
});

$('a[data-loading],button[data-loading]').each(function () {
    $(this).click(function () {
        $('body').loading('start');
    });
});