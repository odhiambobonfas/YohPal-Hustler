class Dashboard extends Master {
    constructor() {
        super();
        // ANY CONSTRUCTOR LOGIC AVAILABLE
    }

    getGraphicStatsData() {
        const ctx = document.querySelector('.earningsChart');
        if (!documentContains(ctx)) return;

        $.ajax({
            type: "GET",
            url: "/dashboard/graphical/stats", 
            dataType: "json",
            success: function (response) {
                if (response.status === 'success' && response.data) {
                    (new Dashboard()).graphicalStatsDrawerFunc(response.data);
                } else {
                    toast('error', 5000, response.message || lang.undefined_error);
                }
            },
            error: error => {
                console.log(error.message || error); 
                toast('error', 5000, lang.undefined_error);
            }
        });
    }

    graphicalStatsDrawerFunc(stats) { 
        const ctxs = document.querySelectorAll('.earningsChart');
        ctxs.forEach(ctx => {
            if (!documentContains(ctx)) return;
            ctx = cloneNodeElement(ctx);
            ctx = ctx?.getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: stats.labels,
                    datasets: [{
                        label: 'Earnings',
                        data: stats.earnings,
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
                            suggestedMax: Math.max(...stats.earnings) + 2000
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
    dashboardInstance.getGraphicStatsData();
    dashboardInstance.getActiveJobsAssigned();
});