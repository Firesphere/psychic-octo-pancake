import {Chart} from 'chart.js/auto';

const doughnut = document.getElementById('doughnut');
const config = {
    type: 'doughnut',
    data: {
        labels: [],
        datasets: [{
            label: "Application status"
        }]
    }
};
export default () => {
    fetch('/home/getDoughnut', {
        method: 'GET',
        headers: {
            "x-requested-with": "XMLHttpRequest",
        }
    }).then(response => response.json())
        .then(response => {
            config['data']['datasets'][0] = response;
            config['data']['labels'] = response['labels'];
        }).then(() => {
        new Chart(doughnut, config);
    });

}
