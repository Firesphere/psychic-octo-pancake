const ctx = document.getElementById('moodchart');

export default () => {
    window.chart = window.chart || [];
    if (typeof(window.chart)) {

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
                    }
                }
            }
        };
        console.log(options);
        new Chart(ctx, options);
    }
}
