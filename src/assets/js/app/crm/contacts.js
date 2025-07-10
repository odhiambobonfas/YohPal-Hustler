class Contacts extends Master {
    constructor() {
        super();
        this.verifyBtn = document.querySelector('.verify-contact-btn');
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
                            (new Contacts()).verifyOtp();
                            (new Contacts()).hideOverlay();
                        }, 1000);
                        return;
                    }

                    if (response && response.status && response.status == 'error') {
                        enableElement(btn);
                        (new Contacts()).hideOverlay();
                        toast(response.status, 5000, response.message || lang.undefined_error);
                        return;
                    }

                    (new Contacts()).hideOverlay();
                    toast('error', 5000, lang.undefined_error);
                },
                error: error => {
                    console.log(error.message || error);
                    toggleButtonContent(btn, '', true);
                    enableElement(btn);
                    (new Contacts()).hideOverlay();
                    toast('error', 5000, lang.undefined_error);
                }
            });
        });
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const contactInstance = new Contacts();
    contactInstance.verifyProfileContacts();
});