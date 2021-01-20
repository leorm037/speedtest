$(function () {
    $("#measure").click(function () {
        var load = $(".ajax_load");
        var a = $("#measure");
        var url = a.prop("href");

        load.fadeIn(200).css("display", "flex");

        $.get(url).done(function(){
            load.fadeOut(200);
            location.reload();
        }).fail(function(){
            alert("Não foi possível medir a velocidade");
            load.fadeOut(200);
        });
    });
});

setTimeout(function(){
   var d = new Date();
   
   if(d.getMinutes() == 0) {
       location.reload();
   }
}, 1000);

