class Web extends Master {
    constructor() {
        super();
        this.getStartedCards = document.querySelectorAll('.get-started-card');
        this.getStartedSubmitBtn = document.querySelector('.get-started-submit-btn');
    }

    setupGetStartedPage() {
        const getStartedCards = this.getStartedCards;
        getStartedCards.forEach(card => {
            if (!documentContains(card)) return;
            card.addEventListener('click', (event) => { 
                const roleRadioBtn = card.querySelector('.role');
                if (documentContains(roleRadioBtn)) {
                    document.querySelectorAll('.role')?.forEach(radioBtn => radioBtn.removeAttribute('checked'));
                    roleRadioBtn.toggleAttribute('checked');
                }
            });
        });
    }

    proceedToSearchEngine() {
        const btn = this.getStartedSubmitBtn;
        if (!documentContains(btn)) return;
        btn.addEventListener('click', (event) => {
            event.preventDefault();
            (new Web()).showOverlay();
            disableElement(btn);
            let form = btn.closest('form');
            let data = serializeFormToArray(form); 

            setTimeout(() => {
                $.ajax({
                    type: "POST",
                    url: form.action,
                    data: JSON.stringify(data),
                    dataType: "json",
                    contentType: false,
                    processData: false,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    success: function (response) {
                        enableElement(btn);
                        (new Web()).hideOverlay();
                        if (response && response.route) {
                            route(response.route);
                        }
                    },
                    error: (jqXHR, textStatus, errorThrown) => {
                        enableElement(btn);
                        (new Web()).hideOverlay();
                    
                        console.error("AJAX Error:", {
                            status: jqXHR.status,
                            statusText: jqXHR.statusText,
                            responseText: jqXHR.responseText,
                            errorThrown: errorThrown,
                            textStatus: textStatus
                        }); 
                    }
                });
            }, 1000);
        });
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const webInstance = new Web();
    webInstance.setupGetStartedPage();
    webInstance.proceedToSearchEngine();
});