class Auth extends Master {
    constructor () {
        super();
        // ANY CONSTRUCTOR LOGIC APPLICABLE
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
            let data = {
                username: document.querySelector('.username')?.value,
                password: document.querySelector('.password')?.value
            }

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
            
            let data = {
                email: form.querySelector('.email')?.value, 
            }

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

    /**
     * Ajax function that handles auth logout requests upon users logout requests while inside the crm interface
     * 
     * @returns {JSON} json response which denotes true or success and other associated response needed.
     */
    authLogout() {
        let btns = document.querySelectorAll('.dropdown .logout-btn'); 

        btns.forEach(btn => {
            if (!documentContains(btn)) return; 

            btn = cloneNodeElement(btn);

            btn.addEventListener('click', event => {
                event.preventDefault();
                toggleButtonContent(btn);
                disableElement(btn); 
                console.log(btn);
                $.ajax({
                    type: 'POST',
                    url: '/auth/logout', 
                    dataType: "json", 
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    success: function (response) {
                        console.log(response);
                        toggleButtonContent(btn, '', true);
                        enableElement(btn);

                        if (response && response.status && response.status == 'success') {
                            route('/auth');
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
        });
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const auth_instance = new Auth();
    auth_instance.authLogin();
    auth_instance.authLogout();
    auth_instance.forgotPassword();
});