class Onboarding extends Master {
    constructor() {
        super();
        // Any applicable logic 
        this.stepperOne = document.querySelector('.stepper-one');
        this.stepperTwo = document.querySelector('.stepper-two');
        this.stepperThree = document.querySelector('.stepper-three');
        this.updateDetailBtn = document.querySelector('.update-details-btn');
        this.verifyBtn = document.querySelector('.verify-contact-btn');
        this.verifyOtpBtn = document.querySelectorAll('.verify-otp-submit-btn');
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
     * Update the profile details for authenticity
     * 
     * @returns {void} No response
     */
    updateDetails() {
        let btn = this.updateDetailBtn;
        if (!documentContains(btn)) return;

        btn.addEventListener('click', event => {
            event.preventDefault();
            toggleButtonContent(btn);
            disableElement(btn);

            let form = btn.closest('form');
            let data = serializeFormToArray(form);

            $.ajax({
                type: 'POST',
                url: form.action,
                data: data,
                dataType: "json",
                success: function (response) {
                    toggleButtonContent(btn, '', true);
                    enableElement(btn);

                    if (response && response.status && response.status == 'success') {
                        toast(response.status, 5000, response.message || lang.undefined_error);
                        setTimeout(() => {
                            (new Onboarding()).navigateStepper('next');
                            (new Onboarding()).verifyProfileDetails();
                        }, 1000);
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

    /**
     * Verify the profile's contacts for authenticity
     * 
     * @returns {void} No response
     */
    verifyProfileContacts() {
        let btn = this.verifyBtn; 
        if (!documentContains(btn)) return;
        btn = cloneNodeElement(btn); // hey young man, prevent race condition
        btn.addEventListener('click', event => {
            event.preventDefault();
            toggleButtonContent(btn);
            disableElement(btn);

            let form = btn.closest('form');
            let data = serializeFormToArray(form); 
            this.showOverlay();

            $.ajax({
                type: 'POST',
                url: form.action,
                data: data,
                dataType: "json",
                success: function (response) {
                    toggleButtonContent(btn, '', true);

                    if (response && response.status && response.status == 'success') {
                        toast(response.status, 5000, response.message || lang.undefined_error);
                        disableElement(btn);
                        setTimeout(() => {
                            const modalSelector = document.querySelector('.verify-profile-details-modal');
                            __append_html(response.modal_body, modalSelector);
                            __show_modal('.verify-profile-details-modal');
                            setup2FAInterface();
                            (new Onboarding()).verifyOtp();
                            (new Onboarding()).hideOverlay();
                        }, 1000);
                        return;
                    }

                    if (response && response.status && response.status == 'error') {
                        enableElement(btn);
                        (new Onboarding()).hideOverlay();
                        toast(response.status, 5000, response.message || lang.undefined_error);
                        return;
                    }

                    (new Onboarding()).hideOverlay();
                    toast('error', 5000, lang.undefined_error);
                },
                error: error => {
                    console.log(error.message || error);
                    toggleButtonContent(btn, '', true);
                    enableElement(btn);
                    (new Onboarding()).hideOverlay();
                    toast('error', 5000, lang.undefined_error);
                }
            });
        });
    }

    /**
     * Verify OTP received to the given contact: email or phone
     * 
     * @returns {void} void
     */
    verifyOtp() {
        let btns = this.verifyOtpBtn;

        btns.forEach(btn => {
            if (!documentContains(btn)) return;
            btn = cloneNodeElement(btn); // counter race conditions
            btn.addEventListener('click', event => {
                event.preventDefault();
                toggleButtonContent(btn);
                disableElement(btn);

                let form = btn.closest('form');
                let data = serializeFormToArray(form);

                $.ajax({
                    type: form.getAttribute('method'),
                    url: form.action,
                    data: data,
                    dataType: "json",
                    success: function (response) {
                        toggleButtonContent(btn, '', true);
                        (new Onboarding()).verifyOtp();
                        enableElement(btn);

                        if (response && response.status && response.status == 'success') {
                            disableElement(btn);
                            resetFormAndCloseModal(form);

                            if (response.client) {
                                window.location.reload();
                            }
                            
                            if (!response.client) {
                                (new Onboarding()).navigateStepper('next');
                                (new Onboarding()).activateAccount();
                            } 

                            toast(response.status, 5000, response.message || lang.undefined_error);
                            return;
                        }

                        if (response && response.status && response.status == 'error') {
                            enableElement(btn);
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
    onboardingInstance.verifyProfileContacts();
    onboardingInstance.addNewUploadSection('.add-certificate-btn');
    onboardingInstance.activateAccount();
    setupUploadSection(); 
});