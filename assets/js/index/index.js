var graphic = null;

function graphicConstruct(speedtests) {
    var labels = [];
    var downloadBandwidth = [];
    var uploadBandwidth = [];
    var id = [];
    
    Array.from(speedtests.results).reverse().map(speed => {
        let data = new Date(speed.timestamp);
        labels.push(data.toLocaleDateString(LOCALE) + " " + data.toLocaleTimeString(LOCALE));
        downloadBandwidth.push(parseFloat(speed.downloadBandwidth * 8 / 1048576).toFixed());
        uploadBandwidth.push(parseFloat(speed.uploadBandwidth * 8 / 1048576).toFixed());
        id.push(speed.id);
    });

    var data = {
        labels: labels,
        datasets: [
            {
                label: 'Download',
                backgroundColor: 'rgba(0,100,255,0.5)',
                borderColor: 'rgb(0,100,255)',
                data: downloadBandwidth
            },
            {
                label: 'Upload',
                backgroundColor: 'rgba(255,99,132,0.5)',
                borderColor: 'rgb(255,99,132)',
                fill: true,
                data: uploadBandwidth
            },
            {
                label: 'id',
                data: id,
                hidden: true
            }
        ]
    };

    const config = {
        type: 'line',
        data: data,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            onClick: function (event, element) {
                const TAG_SPINNER = '<div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden">Carregando...</span></div>';

                modalDateTime = $('#modalDateTime').html(TAG_SPINNER);                          //01
                modalPingJitter = $('#modalPingJitter').html(TAG_SPINNER);                      //02
                modalPingLatency = $('#modalPingLatency').html(TAG_SPINNER);                    //03
                modalDownloadBandwidth = $('#modalDownloadBandwidth').html(TAG_SPINNER);        //04
                modalDownloadBytes = $('#modalDownloadBytes').html(TAG_SPINNER);                //05
                modalDownloadElapsed = $('#modalDownloadElapsed').html(TAG_SPINNER);            //06
                modalUploadBandwidth = $('#modalUploadBandwidth').html(TAG_SPINNER);            //07
                modalUploadBytes = $('#modalUploadBytes').html(TAG_SPINNER);                    //08
                modalUploadElapsed = $('#modalUploadElapsed').html(TAG_SPINNER);                //09
                modalPacketLoss = $('#modalPacketLoss').html(TAG_SPINNER);                      //10
                modalIsp = $('#modalIsp').html(TAG_SPINNER);                                    //11
                modalInterfaceInternalIp = $('#modalInterfaceInternalIp').html(TAG_SPINNER);    //12
                modalInterfaceName = $('#modalInterfaceName').html(TAG_SPINNER);                //13
                modalInterfaceMacAddr = $('#modalInterfaceMacAddr').html(TAG_SPINNER);          //14
                modalInterfaceVpn = $('#modalInterfaceVpn').html(TAG_SPINNER);                  //15
                modalInterfaceExternalIp = $('#modalInterfaceExternalIp').html(TAG_SPINNER);    //16
                modalServerIp = $('#modalServerIp').html(TAG_SPINNER);                          //17
                modalServerName = $('#modalServerName').html(TAG_SPINNER);                      //18
                modalServerLocation = $('#modalServerLocation').html(TAG_SPINNER);              //19
                modalServerCountry = $('#modalServerCountry').html(TAG_SPINNER);                //20
                modalServerSelected = $('#modalServerSelected').html(TAG_SPINNER);              //21
                modalResultUrl = $('#modalResultUrl').html(TAG_SPINNER);                        //22

                $('#modalDetalhe').modal('show');
                
                $.post(URL_JSON_DETALHE, {id: graphic.data.datasets[2].data[element[0].index]})
                        .done(function (data) {                            
                            if (data.message === 'success') {
                                let d = new Date(data.result.timestamp);

                                modalDateTime.text(d.toLocaleDateString(LOCALE) + " " + d.toLocaleTimeString(LOCALE));                                                                                                                          //01
                                modalPingJitter.text(parseFloat(data.result.pingJitter).toLocaleString(LOCALE) + " ms");                                 //02
                                modalPingLatency.text(parseFloat(data.result.pingLatency).toLocaleString(LOCALE) + " ms");                               //03
                                modalDownloadBandwidth.text(parseFloat(data.result.downloadBandwidth * 8 / 1048576).toLocaleString(LOCALE) + " Mbps");   //04
                                modalDownloadBytes.text(parseFloat(data.result.downloadBytes).toLocaleString(LOCALE) + " bytes");                        //05
                                modalDownloadElapsed.text(parseFloat(data.result.downloadElapsed).toLocaleString(LOCALE));                               //06
                                modalUploadBandwidth.text(parseFloat(data.result.uploadBandwidth * 8 / 1048576).toLocaleString(LOCALE) + " Mbps");       //07
                                modalUploadBytes.text(parseFloat(data.result.uploadBytes).toLocaleString(LOCALE) + " bytes");                            //08
                                modalUploadElapsed.text(parseFloat(data.result.uploadElapsed).toLocaleString(LOCALE));                                   //09
                                modalPacketLoss.text(parseFloat(data.result.packetLoss).toLocaleString(LOCALE) + "%");                                   //10
                                modalIsp.text(data.result.isp);                                                                                          //11
                                modalInterfaceInternalIp.text(data.result.interfaceInternalIp);                                                          //12
                                modalInterfaceName.text(data.result.interfaceName);                                                                      //13
                                modalInterfaceMacAddr.text(data.result.interfaceMacAddr);                                                                //14
                                modalInterfaceVpn.text((data.result.interfaceVpn) ? data.result.interfaceVpn : LABEL_NO);                             //15
                                modalInterfaceExternalIp.text(data.result.interfaceExternalIp);                                                          //16
                                modalServerIp.text(data.result.serverIp);                                                                                //17
                                modalServerName.text(data.result.server.name);                                                                  //18
                                modalServerLocation.text(data.result.server.location);                                                          //19
                                modalServerCountry.text(data.result.server.country);                                                            //20
                                modalServerSelected.text((data.result.server.selected) ? LABEL_YES : LABEL_NO);                                 //21
                                modalResultUrl.html("<a href='" + data.result.resultUrl + "' target='_blank'><i class='bi bi-activity'></i> Speedtest report</a>"); //22
                            }
                        }).fail(function(data,status,j){
                            console.log(data,status,j);
                            $('#modalDetalhe').modal('hide');
                            alert("Erro ao tentar recuperar os dados.");
                        });
            },
            scales: {
                y: {
                    grid: {
                        lineWidth: function (context) {
                            if (context.tick.value === MAXSPEEDDOWNLOADMBPS || 
                                    context.tick.value === MAXSPEEDUPLOADMBPS) {
                                return 3;
                            }
                            return 1;
                        },
                        color: function (context) {
                            if (context.tick.value === MAXSPEEDDOWNLOADMBPS) {
                                return 'rgb(0,100,255)';
                            }
                            if (context.tick.value === MAXSPEEDUPLOADMBPS) {
                                return 'rgb(255,99,132)';
                            }
                            return Chart.defaults.borderColor;
                        }
                    },
                    ticks: {
                        stepSize: STEPSPEEDMBPS,
                        callback: function (value, index, ticks) {
                            return value.toLocaleString() + " Mbps";
                        }
                    }
                }
            },
            responsive: true,
            elements: {
                line: {
                    borderWidth: 1
                },
                point: {
                    pointStyle: 'circle',
                    pointRadius: 1,
                    pointHoverRadius: 5
                }
            },
            interaction: {
                mode: 'index',
                intersect: false
            },
            plugins: {
                legend: {
                    position: 'bottom'
                },
                tooltip: {
                    position: 'average',
                    callbacks: {
                        label: function (tooltipItems) {
                            return " " +
                                    tooltipItems.dataset.label +
                                    ": " +
                                    tooltipItems.raw + " Mbps";
                        }
                    }
                }
            }
        }
    };
    if (null === graphic) {
        graphic = new Chart(document.getElementById('speedtest'), config);
    } else {
        graphic.config = config;
        graphic.update;
    }
}

function graphicShow(dias) {
    $.post(
        URL_JSON_DIAS, 
        {
            dias: dias
        }
    ).done(function (data) {
        graphicConstruct(data);
    });
}