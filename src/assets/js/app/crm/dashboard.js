class Dashboard extends Master {
    constructor() {
        super();
        // ANY CONSTRUCTOR LOGIC AVAILABLE
    }

    graphicalStatsDrawerFunc() {
        const ctxs = document.querySelectorAll('.earningsChart');
        ctxs.forEach(ctx => {
            if (!documentContains(ctx)) return;
            ctx = cloneNodeElement(ctx);
            ctx = ctx?.getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['02', '03', '04', '05', '06', '07', '08'],
                    datasets: [{
                        label: 'Earnings',
                        data: [12000, 8000, 16000, 6000, 14000, 10000, 18000],
                        backgroundColor: 'rgba(9,132,227,0.7)',
                        borderRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 20000
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        });
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const dashboardInstance = new Dashboard();
    dashboardInstance.graphicalStatsDrawerFunc();
    dashboardInstance.getActiveJobsAssigned();
});