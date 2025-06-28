class JobPortal extends Master {
    constructor() {
        super();
        // ANY Constructor logic applicable
        this.categoryCards = document.querySelectorAll('.category-card-tag');
        this.contentSection = document.querySelector('.content-section');
        this.categoryListing = document.querySelector('.category-listing');
        this.jobsListing = document.querySelector('.jobs-listing');
        this.backBtn = document.querySelector('.backBtn');
    }

    setupPage() {
        this.initOverlay(this.contentSection);
        this.bindCategoryClicks();
    }

    bindCategoryClicks() {
        this.categoryCards.forEach(card => {
            card.addEventListener('click', () => {
                const categoryId = card.getAttribute('data-id');

                this.showOverlay();

                setTimeout(() => {
                    $.ajax({
                        type: "GET",
                        url: `/portal/jobs/view/${categoryId}`,
                        dataType: "json",
                        success: function (response) {
                            (new JobPortal()).categoryListing.classList.add('d-none');
                            let jobsListing = (new JobPortal()).jobsListing;
                            if (!response.htmlContent) return;
                            __append_html(
                                response.htmlContent,
                                jobsListing
                            );
                            (new JobPortal()).jobsListing.classList.remove('d-none');
                            (new JobPortal()).hideOverlay();
                            (new JobPortal()).bindBackBtnClick();
                            (new JobPortal()).bindTabClicks('.sub-category-tab');
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

    /**
     * Binds the click event to the back button.
     * When triggered, it hides the jobs listing section
     * and shows the category listing section.
     * 
     * @return {void} void
     */
    bindBackBtnClick() {
        if (!documentContains(this.backBtn)) return;

        this.backBtn.addEventListener('click', () => {
            this.showOverlay();
            setTimeout(() => {
                this.jobsListing.classList.add('d-none');
                this.categoryListing.classList.remove('d-none');
                this.hideOverlay();
            }, 2000);
        });
    }

    filterOutSubCategoriesBodyContentUponTabClicks() {
        // Filter out jobs based on the sub category tab clicked.
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const dashboardInstance = new JobPortal();
    dashboardInstance.setupPage();
});