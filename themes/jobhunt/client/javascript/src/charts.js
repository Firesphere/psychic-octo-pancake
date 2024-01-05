import {Chart} from 'chart.js/auto';
import {Flow, SankeyController} from 'chartjs-chart-sankey';

Chart.register(SankeyController, Flow,);

const moodchart = document.getElementById('moodchart');
const sankeychart = document.getElementById('sankeychart');
const moods = {
    1: '😖',
    2: '️☹️',
    3: '😐',
    4: '🙂',
    5: '😃'
}
export default () => {
    if (window.chart) {
        let options = {
            type: 'line',
            data: {
                labels: window.chart.labels,
                datasets: [{
                    label: 'Mood',
                    data: window.chart.values,
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        min: 1,
                        max: 5,
                        ticks: {
                            callback: function (value, index, ticks) {
                                return moods[value] ?? '';
                            },
                            font: {
                                size: 25
                            }
                        }
                    }
                }
            }
        };
        new Chart(moodchart, options);
    }

    if (window.sankey) {
        let options = {};
        new Chart(sankeychart, options)
    }
}
