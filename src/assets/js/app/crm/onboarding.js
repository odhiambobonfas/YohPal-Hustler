class Onboarding extends Master {
    constructor() {
        super();
        // Any applicable logic 
        this.stepperOne = document.querySelector('.stepper-one');
        this.stepperTwo = document.querySelector('.stepper-two');
        this.stepperThree = document.querySelector('.stepper-three');
        this.updateDetailBtn = document.querySelector('.update-details-btn');
        this.verifyBtn = document.querySelector('.verify-contact-btn');
        this.confirmDetails = document.querySelectorAll('.confirm-detail-btn');
        this.dropZones = document.querySelectorAll('.drop-zone');
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
            this.updateDetails();
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
     * Verify the profile details for authenticity
     * 
     * @returns {void} No response
     */
    verifyProfileDetails() {
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
                            (new Onboarding()).verifyProfileInfo();
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

    verifyProfileInfo() {
        let btns = this.confirmDetails;

        btns.forEach(btn => {
            if (!documentContains(btn)) return;
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
                        (new Onboarding()).verifyProfileInfo();

                        if (response && response.status && response.status == 'success') {
                            disableElement(btn);
                            resetFormAndCloseModal(form);
                            (new Onboarding()).navigateStepper('next');
                            toast(response.status, 5000, response.message || lang.undefined_error);
                            return;
                        }

                        if (response && response.status && response.status == 'error') {
                            enableElement(btn);
                            toast(response.status, 5000, response.message || lang.undefined_error);
                            return;
                        }

                        enableElement(btn);
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

    setupUploadSection() {
        this.dropZones.forEach(zone => {
            const input = zone.querySelector('input'); 

            zone.addEventListener('click', () => input.click());

            zone.addEventListener('dragover', e => {
                e.preventDefault();
                zone.classList.add('dragover');
            });

            zone.addEventListener('dragleave', () => {
                zone.classList.remove('dragover');
            });

            zone.addEventListener('drop', e => {
                e.preventDefault();
                zone.classList.remove('dragover');

                const file = e.dataTransfer.files[0];
                if (file && file.type.startsWith('image/')) {
                    input.files = e.dataTransfer.files;
                    previewImage(zone, file);
                }
            });

            // File preview
            input.addEventListener('change', () => {
                const file = input.files[0];
                if (file) previewImage(zone, file);
            });

            function previewImage(zone, file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    zone.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
                };
                reader.readAsDataURL(file);
            }
        });
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const onboardingInstance = new Onboarding();
    onboardingInstance.initOverlay();
    onboardingInstance.setupUploadSection();
});