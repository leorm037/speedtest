$('input[data-server]').each(function () {
    $(this).click(function () {
        var id = $(this).attr('data-server');
        var selected = $(this).prop("checked");
        
        console.log(URL_SERVER_SELECTED);

        $.post(URL_SERVER_SELECTED, {id: id, selected: selected})
                .done(function () {
                    location.reload();
                })
                .fail(function (data, textStatus, jqXHR) {
                    console.log(data);
                    console.log(textStatus);
                    console.log(jqXHR);
                    alert("Erro ao tentar atualizar.");
                });
    });
});