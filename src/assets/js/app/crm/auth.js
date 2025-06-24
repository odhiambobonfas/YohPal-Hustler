class AuthCRM extends Master {
    constructor () {
        super();
        // ANY CONSTRUCTOR LOGIC APPLICABLE
    }
    
    /**
     * Ajax function that handles auth logout requests upon users logout requests while inside the crm interface
     * 
     * @returns {JSON} json response which denotes true or success and other associated response needed.
     */
    authLogout() {
        let btns = document.querySelectorAll('.logout-btn');  
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
    const auth_instance = new AuthCRM(); 
    auth_instance.authLogout(); 
});