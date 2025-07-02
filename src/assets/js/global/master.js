/**
 * Master Class
 * ----------------------------------------------
 * Global JS class - master sits in here.
 * Use this class to group shared, reusable utility methods
 * for frontend site-wide behavior (e.g. restrictions, UI controls, etc).
 * 
 * Here for YohPal forever!
 */
class Master {
    constructor() {
        // Any constructor logic applicable
        this.debounceTimer;
        this.overlay = null;
    } 

    /**
     * Creates and appends a reusable overlay element to the given container.
     * If no container is provided, it defaults to document.body.
     *
     * @param {HTMLElement} [container=document.body] - The DOM element to contain the overlay.
     */
    initOverlay(container = document.body) {
        this.overlay = document.createElement('div');
        this.overlay.classList.add('global-overlay');

        __append_html(
            `<div class="loading-message text-center">
                <div class="spinner-border text-danger mb-2" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <div>Loading...</div>
            </div>`, 
            this.overlay
        );

        container.appendChild(this.overlay);
        this.hideOverlay();
    }

    /**
     * Displays the global overlay by adding the 'active' class.
     * Useful for blocking UI and showing a loading state.
     */
    showOverlay() {
        this.overlay = document.querySelector('.global-overlay');
        if (this.overlay) {
            this.overlay.classList.add('active'); 
        }
    }

    /**
     * Hides the global overlay by removing the 'active' class.
     */
    hideOverlay() {
        this.overlay = document.querySelector('.global-overlay');
        if (this.overlay) {
            this.overlay.classList.remove('active');
        }
    }

    /**
     * Parses and handles modal actions triggered from DataTables UI elements.
     * 
     * Typically used when clicking a button/link inside a DataTable row to open a modal
     * (e.g. edit, view, or delete). Supports invoking an action (e.g. AJAX call), then 
     * optionally runs one or more callbacks after the action is completed.
     *
     * @param {Event} event - The event triggered from a DataTable element (e.g. button click).
     * @param {string} action - The URL or route to fetch or post data to (usually tied to the modal's content).
     * @param {string} [method='GET'] - HTTP method to use when performing the action (e.g., 'GET', 'POST').
     * @param {Function[]|undefined} [callbackFuncs=undefined] - Optional array of callback functions to run after action completes.
     * @param {string} [attribute='.target-modal'] - Selector for the modal element to show (default: '.target-modal').
     */
    assistiveModalActionParser(event, action, method='GET', callbackFuncs = undefined, attribute='target-modal') {
        $.ajax({
            type: `${method}`,
            url: `${action}`,
            dataType: 'json', 
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            success: function (response) {
                event.target.disabled = false;
                toggleLoadingOverlay(false);
                
                if (!response) {
                    toast('error', 5000, lang.undefined_error);
                    return;
                }
                
                if (response.status && response.status == 'error') {
                    toast(response.status, 5000, response.message);
                    return;
                }

                let target_modal = event.target.getAttribute(attribute); // .store-view-modal, store-edit-modal, etc...
                
                if (!target_modal?.length) {
                    toast('error', 5000, lang.undefined_error);
                    return;
                }

                let modal = document.querySelector(`${target_modal}`);

                if (!response.modal) {
                    toast('error', 5000, lang.undefined_error);
                    return;
                }

                __append_html(response.modal, modal);
                __show_modal(target_modal); 

                setTimeout(() => { 
                    if (callbackFuncs !== undefined) { 
                        if (Array.isArray(callbackFuncs)) {
                            callbackFuncs.forEach(item => { 
                                if (typeof item === 'function' && item.callback) {
                                    item(...(item.params?.length ? item.params : []));
                                }
                                else if (typeof item === 'object' && item.callback) {
                                    item.callback(...(item.params?.length ? item.params : []));
                                }
                            });
                        }
                    }
                }, 1000); // Avoid Race conditions 
            },
            error: (error) => {
                console.log(error);
                event.target.disabled = false;
                toast('error', 5000, error.message || lang.undefined_error);
            }
        })
    }

    /**
     * Parses and returns an action route from a specifified form
     * 
     * @param {HTMLSelectElement} form 
     * @returns {string|null} Form Route URL
     */
    formRouteParser(form) {
        return form.action || form.getAttribute('route')
    }

    getActiveJobsAssigned() {
        $('.table-active-jobs-assigned').DataTable({
            destroy: true,
            paging: true,
            searching: true,
            ordering: true,
            info: true,
            lengthChange: true
        });
    }

    /**
     * Select every tab element and apply navigation logic
     * Activation is binded by use of 'active' class. 
     * 
     * @param {String} [selector] HTML selector  
     * @param {Object} [callbackFuncs] Callback functions object 
     */
    bindTabClicks(selector, callbackFuncs={}) {
        let subCategoryTabs = document.querySelectorAll(`${selector}`);
        subCategoryTabs.forEach(tab => {
            if (!documentContains(tab)) return;
            tab = cloneNodeElement(tab); 
            tab.addEventListener('click', () => {
                subCategoryTabs = document.querySelectorAll(`${selector}`);
                subCategoryTabs.forEach(sct => sct.classList.remove('active'));
                tab.classList.add('active');

                // Fire up the callback functions here...
                
            });
        }); 
    }
}