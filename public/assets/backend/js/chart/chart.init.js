/*
$(document).ready(() => {
    const url = $('#charts').data('chart-url');
    const loading = $(".loading");
    $.ajax({
        method: 'GET',
        url,
        success: (response) => {
            Object.keys(response).forEach((key) => {
                const targetElement = document.getElementById(key);
                if (targetElement) {
                    createChart(targetElement, response[key]);
                }
            })
            loading.addClass('d-none');
        },
        error: () => {
            loading.html('<p class="text-center">डाटा छैन !!!</p>');
        },
    })

    function createChart(element, data) {
        const chartType = $(element).attr('chart-type');

        if (chartType === 'pie' || chartType === 'donut') {
            if (Array.isArray(data)) {
                const pieData = data.map(function (val) {
                    return {name: val.name, y: val.data};
                });
                setPieChart(element, chartType, pieData);
            } else {
                toastMessage('error', 'Invalid pie chart data format.');
            }
        } else {
            if (typeof data === 'object' && Array.isArray(data.dataSets) && Array.isArray(data.labels)) {
                const chartDatasets = data.dataSets.map(function (dataset) {
                    return {name: dataset.label, data: dataset.data};
                });
                setBarChart(element, chartType, data.labels, chartDatasets);
            } else {
                toastMessage('error', 'Invalid bar chart data format.');
            }
        }
    }

    function setBarChart(element, charType, labels, datasets) {
        const title = $(element).attr('chart-title');
        Highcharts.chart(element, {
            chart: {type: charType},
            title: {text: title, align: 'left', style: {fontFamily: 'Mukta'}},
            xAxis: {categories: labels, crosshair: true},
            yAxis: {min: 0, title: {text: null}},
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td><td style="padding:0"><b>{point.y}</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {column: {pointPadding: 0.2, borderWidth: 0}},
            series: datasets
        });
    }

    function setPieChart(element, chartType, data) {
        const title = $(element).attr('chart-title');
        const isDonut = chartType === 'donut' ? '60%' : '0%';
        Highcharts.chart(element, {
            chart: {type: 'pie'},
            title: {text: title, align: 'left', style: {fontFamily: 'Mukta'}},
            tooltip: {pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'},
            accessibility: {point: {valueSuffix: '%'}},
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    innerSize: isDonut,
                    dataLabels: {enabled: true},
                    // showInLegend: true
                }
            },
            series: [{name: 'डाटा', colorByPoint: true, data: data}]
        });
    }
})
*/

function toastMessage(type, title) {
    swal.fire({
        title: title,
        toast: true,
        position: 'top-right',
        showConfirmButton: false,
        width: 450,
        timer: 3000,
        timerProgressBar: true,
        icon: type,
    });
}
