import {Chart} from 'chart.js/auto';
import {Flow, SankeyController} from 'chartjs-chart-sankey';

const moodchart = document.getElementById('moodchart');
const sankeychart = document.getElementById('sankeychart');
const applicationchart = document.getElementById('applicationchart');
const responsechart = document.getElementById('responsechart');

const moods = ['😖', '️☹️', '😐', '🙂', '😃']
// Some sort of sane defaults for the colours
let colors = {
    1: 'blue',
    2: 'green',
    3: 'lightblue',
    4: 'yellow',
    5: 'green',
    6: 'red',
    7: 'orange',
    8: 'lightgrey',
    9: 'black',
    10: 'lightgrey',
    11: 'purple',
    12: 'darkgrey'
};
let URL = window.location.href.split('?')[0];
URL = (URL.slice(-1) === '/') ? `${URL}home` : URL;
let moodOptions = {
    type: 'line',
    data: {
        labels: [],
        datasets: [{
            label: 'Mood',
            data: [],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                min: 1, max: 5, ticks: {
                    callback: function (value, index, ticks) {
                        return moods[value - 1] ?? '';
                    },
                    font: {size: 25}
                }
            }
        }
    }
};

let sankeyOptions = {
    type: 'sankey',
    data: {
        datasets: [{
            label: 'My sankey',
            data: [],
            colorFrom: (c) => getColor(c.dataset.data[c.dataIndex].from),
            colorTo: (c) => getColor(c.dataset.data[c.dataIndex].to),
            colorMode: 'flow', // or 'from' or 'to'
            /* optional labels */
            labels: {},
            size: 'max', // or 'min' if flow overlap is preferred
        }]
    },
};

let barOptions = {
    data: {
        labels: [],
        datasets: [
            {
                type: 'bar',
                label: 'Applications made this week',
                data: {},
                backgroundColor: ''
            },
            {
                type: 'bar',
                label: 'Interviews this week',
                data: {},
                backgroundColor: '',
            },
            {
                type: 'bar',
                label: 'Closed from this week',
                data: {},
                backgroundColor: ''
            },
            {
                type: 'line',
                label: 'Total open this week',
                data: {},
                backgroundColor: ''
            }
        ]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    },
};


const getColor = (key) => {
    key = `${key}.`.split('.');
    return colors[key[0]];
}

export default () => {
    if (moodchart) {
        const attr = moodchart.getAttribute('data-name') ?? 'getChartData';
        const endpoint = `${URL}/${attr}`

        fetch(endpoint, {
            method: 'GET',
            headers: {
                "x-requested-with": "XMLHttpRequest",
            }
        }).then(response => response.json())
            .then(response => {
                moodOptions['data']['labels'] = response['labels'];
                moodOptions['data']['datasets'][0]['data'] = response['values'];
            })
            .then(() => {
                new Chart(moodchart, moodOptions);
            });
    }
    if (sankeychart) {
        const attr = sankeychart.getAttribute('data-name') ?? 'getChartData';
        const endpoint = `${URL}/${attr}`

        Chart.register(SankeyController, Flow);
        fetch(endpoint, {
            method: 'GET',
            headers: {
                "x-requested-with": "XMLHttpRequest",
            }
        }).then(response => response.json())
            .then(response => {
                colors = response['colours'];
                sankeyOptions['data']['datasets'][0]['labels'] = response['labels'];
                sankeyOptions['data']['datasets'][0]['data'] = response['values'];
            })
            .then(() => {
                new Chart(sankeychart, sankeyOptions);
            });
    }
    if (applicationchart) {
        const attr = applicationchart.getAttribute('data-name') ?? 'getOtherCharts';
        const endpoint = `${URL}/${attr}`

        fetch (endpoint, {
            method: 'GET',
            headers: {
                'x-requested-with': 'XMLHttpRequest'
            }
        }).then(response => response.json())
            .then(response => {
                barOptions['data']['datasets'][0]['data'] = response['data']['applications']['data']
                barOptions['data']['datasets'][0]['backgroundColor'] = response['data']['applications']['backgroundColor']
                barOptions['data']['datasets'][1]['data'] = response['data']['interviews']['data']
                barOptions['data']['datasets'][1]['backgroundColor'] = response['data']['interviews']['backgroundColor']
                barOptions['data']['datasets'][2]['data'] = response['data']['closed']['data']
                barOptions['data']['datasets'][2]['backgroundColor'] = response['data']['closed']['backgroundColor']
                barOptions['data']['datasets'][3]['data'] = response['data']['outstanding']['data']
                barOptions['data']['datasets'][3]['backgroundColor'] = response['data']['outstanding']['backgroundColor']
                barOptions['data']['labels'] = response['labels'];
            })
            .then(() => {
                new Chart(applicationchart, barOptions);
            });
    }
    if (responsechart) {
        let base = window.location.href.split('?')[0];

        console.log(base);
        fetch (`${base}/getstats`, {
            method: 'GET',
            headers: {
                'x-requested-with': 'XMLHttpRequest'
            }
        }).then(response => response.json())
            .then(response => {
                response['options'] = {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
                console.log(response);
                new Chart(responsechart, response);
            });
        }
}
