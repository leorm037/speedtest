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

setInterval(function(){
   var d = new Date();
   var MinSeg = d.getMinutes().toString().padStart(2,"0")+":"+d.getSeconds().toString().padStart(2,"0");
   
   if(MinSeg == "01:00") {
       location.reload();
   }
}, 1000);
