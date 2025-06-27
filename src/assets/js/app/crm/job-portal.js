class JobPortal extends Master {
    constructor() {
        super();
        // ANY Constructor logic applicable
        this.categoryCards = document.querySelectorAll('.category-card-tag');
        this.categoryListing = document.querySelector('.category-listing');
        this.jobsListing = document.querySelector('.jobs-listing');
    }

    setupPage() {
        this.initOverlay(this.categoryListing);
        this.bindCategoryClicks();
    }

    bindCategoryClicks() {
        this.categoryCards.forEach(card => {
            card.addEventListener('click', () => {
                const categoryId = card.getAttribute('data-id');

                this.showOverlay(); 

                setTimeout(() => {
                    this.categoryListing.classList.add('d-none');
                    this.jobsListing.classList.remove('d-none');
                    $.ajax({
                        type: "GET",
                        url: `/portal/jobs/view/${categoryId}`, 
                        dataType: "json",
                        success: function (response) {
                            let jobsListing = (new JobPortal()).jobsListing;
                            if (!response.htmlContent) return;
                            __append_html(
                                response.htmlContent, 
                                jobsListing
                            );
                            (new JobPortal()).hideOverlay();
                        },
                        error: error => {
                            console.log(error.message || error); 
                            toast('error', 5000, lang.undefined_error);
                        }
                    });
                }, 800);
            });
        });
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const dashboardInstance = new JobPortal();
    dashboardInstance.setupPage();
});