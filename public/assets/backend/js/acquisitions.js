// bar chart
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
const barChart2 = document.getElementById('barChart2').getContext('2d');
const barChartNextData = {
    labels: ['बैशाख', 'जेठ', 'असार', 'श्रावण', 'भदौ', 'आश्विन', 'कार्तिक', 'मंसिर', 'पुष', 'माघ', 'फाल्गुन', 'चैत्र'],
    datasets: [
        {
            label: 'दर्ता',
            data: [43, 78, 328, 163, 274, 255, 104, 291, 86, 252, 168, 221],
            backgroundColor: 'rgba(233, 1, 22, 1)',
            borderColor: 'rgba(233, 1, 22, 1)',
            borderWidth: 1,
        },
        {
            label: 'चलानी',
            data: [220, 49, 38, 11, 41, 64, 7, 18, 1, 26, 108, 44],
            backgroundColor: 'rgba(0, 145, 62, 1)',
            borderColor: 'rgba(0, 145, 62, 1)',
            borderWidth: 1,
        },
    ],
};

const barChartNextOptions = {
    scales: {
        y: {
            beginAtZero: true,
        },
    },
};

new Chart(barChart2, {
    type: 'bar',
    data: barChartNextData,
    options: barChartNextOptions,
});

// horizontal bar chart

const barChartHorizontal = document.getElementById('barChartHorizontal').getContext('2d');
const barChartDataHorizontal = {
    labels: ['२०७७/०७८', '२०७८/०७९', '२०७९/०८०','२०८०/०८१'],
    datasets: [
        {
            label: 'नक्सा दर्ता',
            data: [101, 120, 150, 50],
            backgroundColor: 'rgba(6, 62, 147, 1)',
            borderColor: 'rgba(6, 62, 147, 1)',
            borderWidth: .5,
            borderRadius: 8,
        },
        {
            label: 'नक्सा प्रमाणीकरण',
            data: [50, 10, 26,5],
            backgroundColor: 'rgba(233, 1, 22, 1)',
            borderColor: 'rgba(233, 1, 22, 1)',
            borderWidth: .5,
            borderRadius: 8,
        },
    ],
    scales: {
        x: {
            grid: {
                display: false, // Remove x-axis gridlines
            },
        },
        y: {
            grid: {
                display: false, // Remove x-axis gridlines
            },
        }
    }
};

const horizontalBarChartOptions = {
    responsive: true,
    maintainAspectRatio: true,
    indexAxis: 'y'
};

new Chart(barChartHorizontal, {
    type: 'bar',
    data: barChartDataHorizontal,
    options: horizontalBarChartOptions,
});


// line chart
const lineChart = document.getElementById('lineChart1').getContext('2d');

const lineChartData = {
    labels: ['२०७७/०७८', '२०७८/०७९', '२०७९/०८०','२०८०/०८१'],
    datasets: [
        {
            label: 'दाता',
            data: [19, 45, 92, 74],
            backgroundColor: 'rgba(6, 62, 147, 1)',
            borderColor: 'rgba(6, 62, 147, 1)',
            borderWidth: 1,
        },
        {
            label: 'नबिकरण',
            data: [5, 16, 42, 30],
            backgroundColor: 'rgba(233, 1, 22, 1)',
            borderColor: 'rgba(233, 1, 22, 1)',
            borderWidth: 1,
        },
    ],
};

const lineChartOptions = {
    scales: {
        y: {
            beginAtZero: true,
        },
    },
};

new Chart(lineChart, {
    type: 'line',
    data: lineChartData,
    options: lineChartOptions,
});

// doughnut chart
const doughnut = document.getElementById('doughNut1').getContext('2d');

const doughnutData = {
    labels: ['नगदी रशिद', 'मालपोत रशिद'],
    datasets: [
        {
            data: [1234, 987],
            backgroundColor: ['rgba(6, 62, 147, 1)', 'rgba(233, 1, 22, 1)'],
            borderColor: ['rgba(6, 62, 147, 1)', 'rgba(233, 1, 22, 1)'],
            borderWidth: 1,
        },
    ],
};

const doughnutOptions = {
    responsive: true,
    maintainAspectRatio: false,
};

new Chart(doughnut, {
    type: 'doughnut',
    data: doughnutData,
    options: doughnutOptions,
});

// pie chart
const pieChart = document.getElementById('pieChart1').getContext('2d');

const pieChartData = {
    labels: ['नगद', 'बैंक'],
    datasets: [
        {
            data: [5000, 2500],
            backgroundColor: ['rgba(6, 62, 147, 1)', 'rgba(233, 1, 22, 1)'],
            borderColor: ['rgba(6, 62, 147, 1)', 'rgba(233, 1, 22, 1)'],
            borderWidth: 1,
        },
    ],
};

const pieChartOptions = {
    responsive: true,
    maintainAspectRatio: false,
};

new Chart(pieChart, {
    type: 'pie',
    data: pieChartData,
    options: pieChartOptions,
});

// pie chart
const polarAreChart = document.getElementById('polarAreaChart1').getContext('2d');

const polarAreChartData = {
    labels: [
        'सिलाई कटाई',
        'पशु रोग बारेमा',
        'च्याउ खेती',
    ],
    datasets: [{
        data: [11, 16, 7],
        backgroundColor: [
            'rgba(6, 62, 147, 1)',
            'rgba(233, 1, 22, 1)',
            'rgba(0, 145, 62, 1)',
        ]
    }]
};

const polarAreChartOptions = {
    responsive: true,
    maintainAspectRatio: false,
};

new Chart(polarAreChart, {
    type: 'polarArea',
    data: polarAreChartData,
    options: polarAreChartOptions,
});

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
// bubble chart
const bubbleChart = document.getElementById('bubbleChart').getContext('2d');
const randomBubbleSizes = Array.from({length: 12}, () => Math.floor(Math.random() * 50) + 10);
const bubbleChartData = {
    datasets: [
        {
            label: 'अपाङ्ग',
            data: [
                {x: 'क वर्ग', y: 63, r: 10},
                {x: 'ख वर्ग', y: 12, r: 10},
                {x: 'ग वर्ग', y: 266, r: 10},
                {x: 'घ वर्ग', y: 274, r: 10},
            ],
            backgroundColor: 'rgba(233, 1, 22, 0.2)',
            borderColor: 'rgba(233, 1, 22, 1)',
        },
    ],
};

const bubbleChartOptions = {
    scales: {
        x: {
            type: 'category', // Specify x-axis type as 'category'
            beginAtZero: true,
        },
        y: {
            beginAtZero: true,
        },
    },
};

new Chart(bubbleChart, {
    type: 'bubble',
    data: bubbleChartData,
    options: bubbleChartOptions,
});

