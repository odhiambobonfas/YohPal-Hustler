class Onboarding extends Master {
    constructor() {
        super();
        // Any applicable logic 
        this.stepperOne = document.querySelector('.stepper-one');
        this.stepperTwo = document.querySelector('.stepper-two');
        this.stepperThree = document.querySelector('.stepper-three');
        this.updateDetailBtn = document.querySelector('.update-details-btn');
        this.activateAccountBtn = document.querySelector('.activate-account');
    }

    /**
     * Initiate the onboarding process...
     * 
     * @returns {void} No response
     */
    init() {
        if (!documentContains(this.proceedNextBtn)) return;

        this.proceedNextBtn.addEventListener('click', event => {
            event.preventDefault();
            disableElement(this.proceedNextBtn);
            this.navigateStepper('next');
            this.hideOverlay();
        });
    }

    /**
     * Activate account and unlock it for portal access
     * 
     * @returns {void} void
     */
    activateAccount() {
        let btn = this.activateAccountBtn;
        
        if (!documentContains(btn)) return;  
        btn.addEventListener('click', event => {
            event.preventDefault();
            toggleButtonContent(btn);
            disableElement(btn);

            let form = btn.closest('form');
            let data = new FormData(form); 

            $.ajax({
                type: form.getAttribute('method'),
                url: form.action,
                data: data,
                dataType: "json", 
                contentType: false,
                processData: false,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                success: function (response) { 
                    toggleButtonContent(btn, '', true);
                    enableElement(btn);

                    if (response && response.status && response.status == 'success') { 
                        resetFormAndCloseModal(form); 
                        toast(response.status, 5000, response.message || lang.undefined_error);
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
    const onboardingInstance = new Onboarding();
    onboardingInstance.initOverlay();  
    onboardingInstance.addNewUploadSection('.add-certificate-btn');
    onboardingInstance.activateAccount();
    setupUploadSection(); 
});