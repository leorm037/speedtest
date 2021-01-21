function showGraph(urlJson) {
    $.get(urlJson, function (json) {
        var qtd = json['qtd'];
        var percent = json['percent'];

        pie(qtd, percent);
    });
}

function pie(qtd, percent) {
    var config = {
        type: 'pie',
        data: {
            datasets: [{
                    data: percent,
                    value: qtd,
                    backgroundColor: [
                        'rgb(0, 255, 0)',
                        'rgb(77, 255, 77)',
                        'rgb(153, 255, 153)',
                        'rgb(255, 255, 153)',
                        'rgb(255, 255, 77)',
                        'rgb(255, 255, 0)',
                        'rgb(255, 153, 153)',
                        'rgb(255, 77, 77)',
                        'rgb(255, 0, 0)',
                        'rgb(128, 128, 128)'
                    ]
                }],
            labels: ['90 Mbps', '80 Mbps', '70 Mbps', '60 Mbps', '50 Mbps', '40 Mbps', '30 Mbps', '20 Mbps', '10 Mbps', '>10 Mbps']
        },
        options: {
            responsive: true,
            legend: {
                display: true,
                position: 'bottom',
                labels: {
                    fontSize: 24
                }
            },
            title: {
                display: true,
                text: "Velocidade de downloads em Mbps",
                fontFamily: "'Hachi Maru Pop', cursive",
                fontSize: 36,
                padding: 30
            },
            tooltips: {
                bodyFontSize: 18,
                callbacks: {
                    label: function (tooltipItem, data) {
                        var label = data.labels[tooltipItem.index];
                        var value = data.datasets[0].value[tooltipItem.index];
                        var percent = data.datasets[0].data[tooltipItem.index];

                        return "Faixa " + label + " Mbps: " + value + " registros (" + percent + "%)";
                    }
                }
            }
        }
    };

    var ctx = document.getElementById('chart-area').getContext('2d');
    window.myPie = new Chart(ctx, config);
}