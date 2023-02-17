function graphicConstruct(speedtests) {
    var labels = [];
    var downloadBandwidth = [];
    var uploadBandwidth = [];

    Array.from(speedtests.result).reverse().map(speed => {
        console.log(speed);
        
        let data = new Date(speed.datetime.date);
        labels.push(data.toLocaleDateString() + " " + data.toLocaleTimeString());
        downloadBandwidth.push(parseFloat(speed.downloadBandwidth * 8 / 1048576).toFixed());
        uploadBandwidth.push(parseFloat(speed.uploadBandwidth * 8 / 1048576).toFixed());
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
            }
        ]
    };

    const config = {
        type: 'line',
        data: data,
        options: {
            responsive: true,
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

                $.post(URL_JSON_DETAIL, {dateTime: graphic.data.labels[element[0].index]})
                        .done(function (data) {
                            if (data.message === 'success') {
                                let d = new Date(data.speedtest.dateTime.date);

                                modalDateTime.text(
                                        d.getDay().toString().padStart(2, '0') + "/" +
                                        d.getMonth().toString().padStart(2, '0') + "/" +
                                        d.getFullYear() + " " +
                                        d.getHours().toString().padStart(2, '0') + ":" +
                                        d.getMinutes().toString().padStart(2, '0') + ":" +
                                        d.getSeconds());                                                                                                        //01
                                modalPingJitter = $('#modalPingJitter').text(parseFloat(data.speedtest.pingJitter).toLocaleString(LOCALE) + " ms");              //02
                                modalPingLatency = $('#modalPingLatency').text(parseFloat(data.speedtest.pingLatency).toLocaleString(LOCALE) + " ms");           //03
                                modalDownloadBandwidth = $('#modalDownloadBandwidth').text(parseFloat(data.speedtest.downloadBandwidth * 8 / 1048576).toLocaleString(LOCALE) + " Mbps");                      //04
                                modalDownloadBytes = $('#modalDownloadBytes').text(parseFloat(data.speedtest.downloadBytes).toLocaleString(LOCALE) + " bytes"); //05
                                modalDownloadElapsed = $('#modalDownloadElapsed').text(parseFloat(data.speedtest.downloadElapsed).toLocaleString(LOCALE));      //06
                                modalUploadBandwidth = $('#modalUploadBandwidth').text(parseFloat(data.speedtest.uploadBandwidth * 8 / 1048576).toLocaleString(LOCALE) + " Mbps");                            //07
                                modalUploadBytes = $('#modalUploadBytes').text(parseFloat(data.speedtest.uploadBytes).toLocaleString(LOCALE) + " bytes");       //08
                                modalUploadElapsed = $('#modalUploadElapsed').text(parseFloat(data.speedtest.uploadElapsed).toLocaleString(LOCALE));            //09
                                modalPacketLoss = $('#modalPacketLoss').text(parseFloat(data.speedtest.packetLoss).toLocaleString(LOCALE) + "%");               //10
                                modalIsp = $('#modalIsp').text(data.speedtest.isp);                                                                             //11
                                modalInterfaceInternalIp = $('#modalInterfaceInternalIp').text(data.speedtest.interfaceInternalIp);                             //12
                                modalInterfaceName = $('#modalInterfaceName').text(data.speedtest.interfaceName);                                               //13
                                modalInterfaceMacAddr = $('#modalInterfaceMacAddr').text(data.speedtest.interfaceMacAddr);                                      //14
                                modalInterfaceVpn = $('#modalInterfaceVpn').text((data.speedtest.interfaceVpn) ? data.speedtest.interfaceVpn : LABEL_NO);       //15
                                modalInterfaceExternalIp = $('#modalInterfaceExternalIp').text(data.speedtest.interfaceExternalIp);                             //16
                                modalServerIp = $('#modalServerIp').text(data.speedtest.serverIp);                                                              //17
                                modalServerName = $('#modalServerName').text(data.speedtestServer.name);                                                        //18
                                modalServerLocation = $('#modalServerLocation').text(data.speedtestServer.location);                                            //19
                                modalServerCountry = $('#modalServerCountry').text(data.speedtestServer.country);                                               //20
                                modalServerSelected = $('#modalServerSelected').text((data.speedtestServer.selected) ? LABEL_YES : LABEL_NO);                   //21
                                modalResultUrl = $('#modalResultUrl').html("<a href='" + data.speedtest.resultUrl +
                                        "' target='_blank'><i class='bi bi-activity'></i> Speedtest report</a>");                                               //22
                            }
                        });
            },
            scales: {
                y: {
                    grid: {
                        lineWidth: function (context) {
                            console.log();

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
    const graphic = new Chart(document.getElementById('speedtest'), config);
}

function graphicShow(url) {
    $.get({
        url: url
    }).done(function (data) {
        graphicConstruct(data);
    });
}