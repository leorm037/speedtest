$(function () {
    $("#measure").click(function () {
        var load = $(".ajax_load");
        var a = $("#measure");
        var url = a.prop("href");
        
        load.fadeIn(200).css("display", "flex");
        $.get(url);
        load.fadeOut(200);
        location.reload();
    });
});
