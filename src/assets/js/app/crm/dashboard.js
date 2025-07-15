class Dashboard extends Master {
    constructor() {
        super();
        // ANY CONSTRUCTOR LOGIC AVAILABLE
        this.pending_users = document.querySelector('.pending_users_count');
        this.active_users = document.querySelector('.active_users_count');
        this.dormant_users = document.querySelector('.dormant_users_count');
        this.deleted_users = document.querySelector('.deleted_users_count');
        this.tjs_stat = document.querySelector('.total-job-seekers-count');
        this.tjp_stat = document.querySelector('.total-job-providers-count');
        this.active_listing_stat = document.querySelector('.active-listings-count');
    }

    initOnboardingProcess() { 
        if (typeof Onboarding === 'undefined') return;
        const onboardingInstance = new Onboarding();
        onboardingInstance.init();
    } 

    getUsersCountStats() {
        const usersCountSection = document.querySelector('.users-count-stats');
        if (!documentContains(usersCountSection)) return;

        $.ajax({
            type: "GET",
            url: "/users/count/stats",
            data: "data",
            dataType: "json",
            success: function (response) {
                if (response.status === 'success' && response.data) {
                    let data = response.data;
                    (new Dashboard()).pending_users = __append_html(data.pending_users || 0, (new Dashboard()).pending_users);
                    (new Dashboard()).active_users = __append_html(data.active_users || 0, (new Dashboard()).active_users);
                    (new Dashboard()).dormant_users = __append_html(data.dormant_users || 0, (new Dashboard()).dormant_users);
                    (new Dashboard()).deleted_users = __append_html(data.deleted_users || 0, (new Dashboard()).deleted_users);
                    (new Dashboard()).tjs_stat = __append_html(data.total_job_seekers || 0, (new Dashboard()).tjs_stat);
                    (new Dashboard()).tjp_stat = __append_html(data.total_job_providers || 0, (new Dashboard()).tjp_stat);
                    (new Dashboard()).active_listing_stat = __append_html(data.active_listings || 0, (new Dashboard()).active_listing_stat);
                }
            },
            error: error => {
                console.log(error.message || error); 
                toast('error', 5000, lang.undefined_error);
            }
        });
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
            if (typeof Chart === 'undefined') return;
            
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
    dashboardInstance.initOnboardingProcess();
    dashboardInstance.getUsersCountStats();
    dashboardInstance.getGraphicStatsData();
    dashboardInstance.getActiveJobsAssigned();
    dashboardInstance.setMapOnPage();
});