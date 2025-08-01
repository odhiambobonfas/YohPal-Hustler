class JobPortal extends Master {
    constructor() {
        super();
        // ANY Constructor logic applicable
        this.stepperSections = document.querySelectorAll('.job-portal-step-section');
        this.categoryCards = document.querySelectorAll('.category-card-tag');
        this.contentSection = document.querySelector('.content-section');
        this.categoryListing = document.querySelector('.category-listing');
        this.jobsListing = document.querySelector('.jobs-listing');
        this.mapSection = document.querySelector('.mapping-section');
        this.backBtns = undefined;
        this.selected_job = undefined;
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
                            enableToggleHighlight('.job-list-group', [(new JobPortal()).createJobDraft]);
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
        this.backBtns = document.querySelectorAll('.backBtn');

        this.backBtns.forEach(backBtn => {
            if (!documentContains(backBtn)) return;

            backBtn.addEventListener('click', () => {
                this.showOverlay();
                setTimeout(() => {
                    this.stepperSections.forEach(section => section.classList.add('d-none'));
                    this.categoryListing.classList.remove('d-none');
                    this.hideOverlay();
                }, 2000);
            });
        });
    }

    filterOutSubCategoriesBodyContentUponTabClicks() {
        // Filter out jobs based on the sub category tab clicked.
    }

    createJobDraft(subCategoryId, extra_params = []) {
        __show_modal('.create-job-modal');
        const createJobForm = document.querySelector('.create-job-modal-form');
        if (!documentContains(createJobForm)) return;
        createJobForm.setAttribute('action', `/job/create/${subCategoryId}`);
        createJobForm.querySelector('.job-title').value = extra_params['job_name'] || '';
        flatpickrUtil();

        let btn = document.querySelector('.create-job-submit-btn');
        if (!documentContains(btn)) return;
        btn = cloneNodeElement(btn);
        btn.addEventListener('click', event => {
            event.preventDefault();
            toggleButtonContent(btn);
            disableElement(btn);
            let form = btn.closest('form');
            let data = serializeFormToArray(form);
            console.log("data", data)

            $.ajax({
                type: 'POST',
                url: `${form.action}/${subCategoryId}`,
                data: data,
                dataType: "json",
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                success: function (response) {
                    console.log(response);
                    toggleButtonContent(btn, '', true);
                    enableElement(btn);

                    if (response && response.status && response.status == 'success') {
                        toast(response.status, 5000, response.message || lang.undefined_error);
                        resetFormAndCloseModal(form);
                        (new JobPortal()).showOverlay();
                        setTimeout(() => {
                            (new JobPortal()).stepperSections.forEach(section => section.classList.add('d-none'));
                            (new JobPortal()).mapSection.classList.remove('d-none');
                            (new JobPortal()).hideOverlay();
                            (new JobPortal()).bindBackBtnClick();
                            (new JobPortal()).getActiveHustlers();
                        }, 1000); // Avoid race condition...
                        return;
                    }

                    if (response && response.status && response.status == 'error') {
                        toast(response.status, 5000, response.message || lang.undefined_error);
                        return;
                    }

                    toast('error', 5000, lang.undefined_error);
                },
                error: error => {
                    console.log(error.message || error);
                    toggleButtonContent(btn, '', true);
                    enableElement(btn);
                    toast('error', 5000, lang.undefined_error);
                }
            });
        });
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const dashboardInstance = new JobPortal();
    dashboardInstance.setupPage();
});

