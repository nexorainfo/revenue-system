    function createChart(targetElement, responseElement) {
        const chart = targetElement.getContext('2d');


        const chartType = $(targetElement).attr('chart-type');
        const chartData = {
            labels: responseElement['labels'],
            datasets: responseElement['dataSets'],
        };
        const chartOptions = responseElement['option']
        new Chart(chart, {
            type: chartType,
            data: chartData,
            options: chartOptions,
        });

    }

    // bar chart
    $(document).ready(() => {
        const url = $('#charts').data('chart-url');
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
                // loading.addClass('d-none');
            },
            error: () => {
                // loading.html('<p class="text-center">डाटा छैन !!!</p>');
            },
        })
    });
/*
const barChart1 = document.getElementById('barChart1').getContext('2d');
const barChartData = {
    labels: ['बैशाख', 'जेठ', 'असार', 'श्रावण', 'भदौ', 'आश्विन', 'कार्तिक', 'मंसिर', 'पुष', 'माघ', 'फाल्गुन', 'चैत्र'],
    datasets: [
        {
            label: 'जम्मा',
            data: [263, 127, 366, 174, 315, 319, 111, 309, 87, 278, 276, 265],
            backgroundColor: 'rgba(6, 62, 147, 1)',
            borderColor: 'rgba(6, 62, 147, 1)',
            borderWidth: 1,
        },
        {
            label: 'समाचार',
            data: [43, 78, 328, 163, 274, 255, 104, 291, 86, 252, 168, 221],
            backgroundColor: 'rgba(233, 1, 22, 1)',
            borderColor: 'rgba(233, 1, 22, 1)',
            borderWidth: 1,
        },
        {
            label: 'सूचना',
            data: [220, 49, 38, 11, 41, 64, 7, 18, 1, 26, 108, 44],
            backgroundColor: 'rgba(0, 145, 62, 1)',
            borderColor: 'rgba(0, 145, 62, 1)',
            borderWidth: 1,
        },
    ],
};

const barChartOptions = {
    scales: {
        y: {
            beginAtZero: true,
        },
    },
};

new Chart(barChart1, {
    type: 'bar',
    data: barChartData,
    options: barChartOptions,
});// bar chart

// horizontal bar chart

// stepped line chart
const steppedlineChart = document.getElementById('steppedlineChart').getContext('2d');
const steppedlineChartData = {
    labels: ['१', '२', '३', '४', '५', '६', '७', '८', '९', '१०', '११', '१२', '१३'],
    datasets: [
        {
            label: 'पुँजीकरण सिफारिस',
            data: [263, 127, 366, 174, 315, 319, 111, 309, 87, 278, 276, 265, 50],
            backgroundColor: 'rgba(6, 62, 147, 0.2)', // Change to transparent
            borderColor: 'rgba(6, 62, 147, 1)',
            borderWidth: 1,
            pointRadius: 0,
            stepped: 'middle', // Use 'middle' for a stepped line chart
        },
        {
            label: 'नागरिकता सिफारिस',
            data: [43, 78, 328, 163, 274, 255, 104, 291, 86, 252, 168, 221, 26],
            backgroundColor: 'rgba(233, 1, 22, 0.2)', // Change to transparent
            borderColor: 'rgba(233, 1, 22, 1)',
            borderWidth: 1,
            pointRadius: 0,
            stepped: 'middle', // Use 'middle' for a stepped line chart
        },
        {
            label: 'नापी मालपोत सिफारिस',
            data: [220, 49, 38, 11, 41, 64, 7, 18, 1, 26, 108, 44, 150],
            backgroundColor: 'rgba(0, 145, 62, 0.2)', // Change to transparent
            borderColor: 'rgba(0, 145, 62, 1)',
            borderWidth: 1,
            pointRadius: 0,
            stepped: 'middle', // Use 'middle' for a stepped line chart
        },
    ],
};

const steppedlineChartOptions = {
    scales: {
        y: {
            beginAtZero: true,
        },
    },
    axis: 'x'
};

new Chart(steppedlineChart, {
    type: 'line',
    data: steppedlineChartData,
    options: steppedlineChartOptions,
});

*/
