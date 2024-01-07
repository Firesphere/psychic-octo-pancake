import {Chart} from 'chart.js/auto';
import {Flow, SankeyController} from 'chartjs-chart-sankey';

const moodchart = document.getElementById('moodchart');
const sankeychart = document.getElementById('sankeychart');
const moods = ['😖', '️☹️', '😐', '🙂', '😃']
const colors = {
    1: 'blue',
    2: 'green',
    3: 'lightblue',
    4: 'yellow',
    5: 'green',
    6: 'red',
    7: 'orange',
    8: 'lightgrey',
    9: 'black',
    10: 'lightgrey'
};
const endpoint = `${window.location.href.split('?')[0]}/getChartData`
let moodOptions = {
    type: 'line',
    data: {
        labels: [],
        datasets: [{label: 'Mood', data: [], borderWidth: 1}]
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
            colorMode: 'gradient', // or 'from' or 'to'
            /* optional labels */
            labels: {},
            size: 'max', // or 'min' if flow overlap is preferred
        }]
    },
};


const getColor = (key) => colors[key];

export default () => {
    if (moodchart) {
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
        Chart.register(SankeyController, Flow);
        if (sankeychart)
            fetch(endpoint, {
                method: 'GET',
                headers: {
                    "x-requested-with": "XMLHttpRequest",
                }
            }).then(response => response.json())
                .then(response => {
                    sankeyOptions['data']['datasets'][0]['labels'] = response['labels'];
                    sankeyOptions['data']['datasets'][0]['data'] = response['values'];
                })
                .then(() => {
                    new Chart(sankeychart, sankeyOptions);
                });
    }
}
