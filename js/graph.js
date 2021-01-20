$(function(){
        showGraph();
});

function showGraph(){
        {
                $.post(
                        "http://localhost/speedtest/json/dias/3",
                        function(data){
                                var timestamp = [];
                                var download_velocidade = [];
                                var upload_velocidade = [];

                                for(var i in data){
                                        timestamp.push(moment(data[i][0]).format("DD/MM/YYYY HH:mm:ss"));
                                        download_velocidade.push(numeral(data[i][1]/1000000).format('0,0.00'));
                                        upload_velocidade.push(numeral(data[i][2]/1000000).format('0,0.00'));
                                }

                                var chartdata = {
                                        labels: timestamp,
                                        datasets: [
                                                {
                                                        label: "Download (Mbps)",
                                                        backgroundColor: 'rgb(255,99,132)',
                                                        borderColor: 'rgb(255,99,132)',
                                                        fill: true,
                                                        data: download_velocidade
                                                },
                                                {
                                                        label: "Upload (Mbps)",
                                                        backgroundColor: 'rgb(54,162,235)',
                                                        borderColor: 'rgb(54,162,235)',
                                                        fill: false,
                                                        data: upload_velocidade

                                                                        },
                                                                ],
                                                        };

                                                        var graphTarget = $("#graphCanvas");

                                                        var barGraph = new Chart(
                                                                graphTarget,
                                                                {
                                                                        type: 'line',
                                                                        data: chartdata,
                                                                        options: {
                                                                                responsive: true,
                                                                                title: {
                                                                                        display: true,
                                                                                        text: 'Link Internet Claro 240Mbps',
                                                                                        fontSize: 24,
                                                                                },
                                                                                tooltips: {
                                                                                        callbacks: {
                                                                                                label: function(tooltipItem, data){
                                                                                                        numeral.locale('pt-br');
                                                                                                        return ' ' + numeral(tooltipItem.yLabel).format('0,0.00') + ' Mbps';
                                                                                                }
                                                                                        },
                                                                                        mode: 'index',
                                                                                        intersect: false,
                                                                                },
                                                                                hover: {
                                                                                        mode: 'nearest',
                                                                                        intersect: true
                                                                                },
                                                                                scales: {
                                                                                        xAxes: [{
                                                                                                display: true,
                                                                                                scaleLabel: {
                                                                                                        display: true,
                                                                                                        labelString: 'Data'
                                                                                                }
                                                                                        }],
                                                                                        yAxes: [{
                                                                                                ticks: {
                                                                                                        callback: function(value) {
                                                                                                                numeral.locale('pt-br');
                                                                                        return numeral(value).format('0,0.00');

                                                                                }
                                                                        },
                                                                display: true,
                                                                        scaleLabel: {
                                                                                display: true,
                                                                                labelString: 'Velocidade (Mbps)'
                                                                        }
                                                                }]
                                                        }
		                                },
                                        }
		                );
                        }
                );
        }
}