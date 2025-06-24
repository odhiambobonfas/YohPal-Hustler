class AuthWeb extends Master {
    constructor() {
        super();
        // ANY CONSTRUCTOR LOGIC AVAILABLE
    }

    /**
     * Set up page by firing toggling functionalities and such
     * 
     * @returns {void} void
     */
    setUpPage() {
        let toggleBtns = document.querySelectorAll('.auth-toggle-btn'); 
        toggleBtns.forEach(btn => {
            if (!documentContains(btn)) return;
            btn = cloneNodeElement(btn);
            btn.addEventListener('click', (event) => {
                const container = document.querySelector('.container');
                
                if (!documentContains(container)) return;
                
                if (event.target.classList.contains('sign-up-btn')) {
                    container.classList.add('sign-up-mode');
                    return;
                }  

                container.classList.remove('sign-up-mode');
            });
        });
    }

    /**
     * Ajax function that handles authentication requests upon users login requests on web interface
     * 
     * @returns {JSON} json response which denotes true or success and other associated response needed.
     */
    authLogin() {
        let btn = document.querySelector('.login-submit-btn');
        if (!documentContains(btn)) return; 
        btn = cloneNodeElement(btn);
        btn.addEventListener('click', event => {
            event.preventDefault();
            toggleButtonContent(btn);
            disableElement(btn);
            let form = btn.closest('form'); 
            let data = serializeFormToArray(form);

            console.log(data);

            $.ajax({
                type: form.method,
                url: '/auth/login',
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
                        route(response.route);
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
     * Ajax function that handles forgot password requests upon users forgot password requests on web interface
     * 
     * @returns {JSON} json response which denotes true or success and other associated response needed.
     */
    forgotPassword() {
        let btn = document.querySelector('.forgot-pass-submit-btn');
        if (!documentContains(btn)) return; 
        btn = cloneNodeElement(btn);
        btn.addEventListener('click', event => {
            event.preventDefault();
            toggleButtonContent(btn);
            disableElement(btn);
            let form = btn.closest('form'); 
            
            let data = serializeFormToArray(form);

            $.ajax({
                type: form.method,
                url: '/auth/forgot-password',
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
    const authUiInstance = new AuthWeb();
    authUiInstance.setUpPage();
    authUiInstance.authLogin();
    authUiInstance.forgotPassword();
});