// functions sits in here!

/**
 * Function gives room for cleaner approach of toastr lib usage.
 * The function accepts 3 parameters as defined/highlighted below. 
 * 
 * @param {string} status error, info, warning or success as defined by toastr lib 
 * @param {number} time number, to denote seconds for the toast to take to hide.
 * @param {string} message text message to show user, the outcome of a certain event. 
 */
function toast(status, time, message) {
    try {
        if (message != undefined || message != null) {
            toastr.options.newestOnTop = true;
            toastr.options.timeOut = time;
            toastr.options.extendedTimeOut = 0;
            toastr.options.progressBar = true;
            toastr.options.rtl = false;
            toastr.options.closeButton = true;
            toastr.options.closeMethod = 'fadeOut';
            toastr.options.closeDuration = 300;
            toastr.options.closeEasing = 'swing';
            toastr.options.preventDuplicates = true;

            if (status == 'success') {
                toastr.success(message);
                playSuccessAudio();
            } else if (status == 'warning') {
                toastr.warning(message);
                playWarningAudio();
            } else if (status == 'info') {
                toastr.info(message);
            } else if (status == 'error') {
                toastr.error(message);
                playErrorAudio();
            }
        }
    } catch (error) {
        console.log('Toast Error: ' + error);
    }
}

/**
 * Function to play success audio
 * 
 * @returns {void} void
 */
function playSuccessAudio() {
    var successAudio = document.getElementById('success-audio');
    if (documentContains(successAudio)) {
        successAudio.play();
    }
}

/**
 * Function to play error audio
 * 
 * @returns {void} void
 */
function playErrorAudio() {
    var errorAudio = document.getElementById('error-audio');
    if (documentContains(errorAudio)) {
        errorAudio.play();
    }
}

/**
 * Function to play warning audio
 * 
 * @returns {void} void
 */
function playWarningAudio() {
    var warningAudio = document.getElementById('warning-audio');
    if (documentContains(warningAudio)) {
        warningAudio.play();
    }
}

/**
 * Returns back to previous page.
 * 
 * @returns {void} void
 */
function goBack() {
    window.history.back();
}


/**
 * Disables one or multiple HTML elements.
 * Accepts a CSS selector string, an HTMLElement, or a NodeList/array of elements.
 *
 * @param {string | HTMLElement | NodeList | Array} selector - The target element(s) to disable.
 */
function disableElement(selector) {
    let elements;

    if (typeof selector === 'string') {
        elements = document.querySelectorAll(selector);
    } else if (selector instanceof HTMLElement) {
        elements = [selector];
    } else if (selector instanceof NodeList || Array.isArray(selector)) {
        elements = selector;
    } else {
        console.warn('Unsupported selector type:', selector);
        return;
    }

    elements.forEach(element => {
        element.disabled = true;
    });
}

/**
 * Enables one or multiple HTML elements.
 * Accepts a CSS selector string, an HTMLElement, or a NodeList/array of elements.
 *
 * @param {string | HTMLElement | NodeList | Array} selector - The target element(s) to enable.
 */
function enableElement(selector) {
    let elements;

    if (typeof selector === 'string') {
        elements = document.querySelectorAll(selector);
    } else if (selector instanceof HTMLElement) {
        elements = [selector];
    } else if (selector instanceof NodeList || Array.isArray(selector)) {
        elements = selector;
    } else {
        console.warn('Unsupported selector type:', selector);
        return;
    }

    elements.forEach(element => {
        element.disabled = false;
    });
}

/**
 * Checks if any field in the FormData is empty (after trimming).
 *
 * @param {FormData} formData
 * @returns {boolean}
 */
function formDataHasEmptyFields(formData) {
    for (const [key, value] of formData.entries()) {
        if (typeof value === 'string' && !value.trim()) {
            return true;
        }
    }
    return false;
}

/**
 * Temporarily changes button text, & restores original text when revert is true.
 * 
 * @param {HTMLButtonElement} button HTML button element to act on.
 * @param {Text} tempContent Text to apply to the button.
 * @param {Boolean} revet True or false: To Change back to original content or not.
 */
function toggleButtonContent(button, tempContent = 'Please wait...', revert = false) {
    if (!button) return;
  
    if (!revert) {
      // Save original content to data attribute
      button.dataset.originalContent = button.innerHTML;
      button.innerHTML = tempContent; 
    } else {
      // Restore original content
      if (button.dataset.originalContent) {
        button.innerHTML = button.dataset.originalContent;
        delete button.dataset.originalContent;
      } 
    }
}

/**
 * Removes all child elements from the specified HTML element. 
 * The function first checks if the element exists in the document using `documentContains`.
 * If found, it removes all of its child nodes.
 * 
 * @param {string} selector - A valid CSS selector for the target parent element.
 * @returns {void} void
 */
function removeHtmlElementChildren(selector) {
    const parent = document.querySelector(selector);

    if (!documentContains(parent)) {
        console.warn(`No element found for selector: "${selector}"`);
        return;
    }

    while (parent.firstChild) {
        parent.removeChild(parent.firstChild);
    }
}

/**
 * Shows and Hides the navbar search bar - absolute position blocked.
 * Uses animation library for smooth & stable transition effect
 * 
 * @returns {void} void
 */
function handleShowNavbarSearchBarToggler() {
    const searchBox = document.getElementById('search_input_box');
    const closeBtn = document.getElementById('close_search');

    if (!searchBox || !closeBtn) return;

    searchBox.classList.remove('d-none');
    searchBox.classList.add('animate__animated', 'animate__fadeInDown');

    closeBtn.addEventListener('click', () => {
        searchBox.classList.remove('animate__fadeInDown');
        searchBox.classList.add('animate__fadeOutUp');

        searchBox.addEventListener('animationend', () => {
            searchBox.classList.add('d-none');
            searchBox.classList.remove('animate__animated', 'animate__fadeOutUp');
        }, {
            once: true
        });
    });
}

/**
 * Detect screen size in real time and return
 * 
 * @return {string} screen size annotations, xs, sm, md, lg or xl
 */
function detectScreenSize() {
    const width = window.innerWidth;

    if (width < 576) return 'xs';

    if (width >= 576 && width < 768) return 'sm';

    if (width >= 768 && width < 992) return 'md';

    if (width >= 992 && width < 1200) return 'lg';

    return 'xl';
}

/**
 * Checks if the element exists in a specified body/body-element
 * 
 * @returns {Boolean} True|False
 */
function documentContains(target) {
    if (target && document.body.contains(target)) {
        return true;
    }

    return false;
}

/**
 * Appends HTML content to an element without replacing existing content.
 * 
 * @param {string} content - The HTML content to append.
 * @param {HTMLElement} element - The element to which the content will be appended.
 * @param {boolean} element - True|False, whether to append or replace - respectively.
 */
function __append_html(content, element, append = false) {
    if (append) {
        element.innerHTML += content; // Append new content
    } else {
        element.innerHTML = content; // Replace content
    }
}

/**
 * Adds a 'sticky' class to the navbar when the page is scrolled,
 * enabling sticky behavior for elements with 'scrollStickyNav' class.
 */
function stickNavbarOnScroll() {
    window.addEventListener('scroll', function () {
        const nav = document.querySelector('.scrollStickyNav');

        if (!documentContains(nav)) return;

        if (window.scrollY > 0) {
            nav.classList.add('sticky');
        } else {
            nav.classList.remove('sticky');
        }
    });
}

/**
 * Initializes all elements with class 'searchSelect' using Select2,
 * and scoping them to their parent containers.
 */
function searchSelectInitializer() {
    $('.searchSelect').each(function (index) {
        var currentSelect = $(this);
        
        if (!currentSelect.hasClass("select2-hidden-accessible")) {
            currentSelect.select2({
                width: '100%',
                dropdownParent: currentSelect.parent()
            });
        }
    });
}

/**
 * HTML element cloner function. This function prevents 
 * appending multiple listeners and avoiding call conflicts.
 * 
 * @param {HTMLSelectElement} element 
 * @returns {void} void
 */
function cloneNodeElement(element) {
    var newElement = null;
    if (documentContains(element)) {
        newElement = element.cloneNode(true);
        element.replaceWith(newElement);
    }

    return newElement;
}

/**
 * Initialize drag-and-drop file upload support.
 * Supports multiple drop zones and file inputs.
 * 
 * @param {string} [dropZoneSelector='.dropZone'] - CSS selector for drop zones.
 * @param {string} [fileInputSelector='.importFile'] - CSS selector for file inputs.
 */
function initDragAndDropFileUpload(dropZoneSelector = '.dropZone', fileInputSelector = '.importFile') {
    const dropZones = document.querySelectorAll(dropZoneSelector);

    if (!dropZones.length) return;

    dropZones.forEach(dropZone => {  
        dropZone.addEventListener('click', () => {
            const fileInput = dropZone.querySelector(fileInputSelector);
            let fileListDisplay = document.createElement('ul');
            fileListDisplay.className = 'file-list mt-2 list-unstyled small text-start text-muted';
            dropZone.parentNode.insertBefore(fileListDisplay, dropZone.nextSibling);
    
            const highlight = () => dropZone.classList.add('border-primary');
            const unhighlight = () => dropZone.classList.remove('border-primary');
    
            const updateFileList = () => {
                fileListDisplay.innerHTML = '';
                if (fileInput.files.length > 0) {
                    [...fileInput.files].forEach(file => {
                        const li = document.createElement('li');
                        li.textContent = `${file.name} (${Math.round(file.size / 1024)} KB)`;
                        fileListDisplay.appendChild(li);
                    });
                }
            };

            dropZone.addEventListener('click', () => fileInput.click());
            dropZone.addEventListener('dragover', (e) => {
                e.preventDefault();
                highlight();
            });
    
            dropZone.addEventListener('dragleave', unhighlight);
            dropZone.addEventListener('dragend', unhighlight);
    
            dropZone.addEventListener('drop', (e) => {
                e.preventDefault();
                unhighlight();
    
                if (e.dataTransfer.files?.length > 0) {
                    fileInput.files = e.dataTransfer.files;
                    fileInput.dispatchEvent(new Event('change', { bubbles: true }));
                }
            });

            fileInput.addEventListener('change', updateFileList);
        }); 
    });
}

/**
 * Serializes and captures form data to return as an array.
 * 
 * @param {HTMLFormElement} form 
 * @returns {Object} Objectified data
 */
function serializeFormToArray(form) {
    const formData = new FormData(form);
    const result = {};

    for (const [name, value] of formData.entries()) { 
        if (result.hasOwnProperty(name)) { 
            if (Array.isArray(result[name])) {
                result[name].push(value);
            } else { 
                result[name] = [result[name], value];
            }
        } else {
            result[name] = value;
        }
    }

    return result;
}


/**
 * Hide bootstrap offcanvas gracefully.
 * 
 * @param {HTMLSelectElement} selector 
 * @return {void} void
 */
function hideCanvas(selector) {
    const bsCanvas = bootstrap.Offcanvas.getInstance(selector);
    if (bsCanvas) bsCanvas.hide();
}

/**
 * Get DataTables language configuration with optional customizations.
 *
 * @param {Object} overrides Optional overrides for the language strings.
 * @returns {Object} Language configuration object for DataTables.
 */
function getDataTableLanguage(overrides = {}) {
    const defaultLanguage = {
        emptyTable: 'No data found.',
        processing: '<i class="fa fa-spinner fa-spin fa-2x fa-fw"></i><span class="sr-only">Loading...</span>',
        search: 'Search:',
        searchPlaceholder: '',
        lengthMenu: 'Show _MENU_ entries',
        info: 'Showing _START_ to _END_ of _TOTAL_ entries',
        infoEmpty: 'Showing 0 to 0 of 0 entries',
        infoFiltered: '(filtered from _MAX_ total entries)',
        paginate: {
            first: '<i class="fa fa-angle-double-left"></i> First',
            last: 'Last <i class="fa fa-angle-double-right"></i>',
            previous: '<i class="fa fa-angle-left"></i> Previous',
            next: 'Next <i class="fa fa-angle-right"></i>'
        }
    };

    // Deep merge for nested `paginate` object
    if (overrides.paginate) {
        overrides.paginate = {
            ...defaultLanguage.paginate,
            ...overrides.paginate
        };
    }

    return {
        ...defaultLanguage,
        ...overrides
    };
}

/**
 * Accepts a route string and navigates 
 * the browser to the given route.
 * 
 * @param {string} endpoint - The URL or route to navigate to
 */
function route(endpoint) {
    if (typeof endpoint !== 'string' || !endpoint.trim()) {
        console.error('Invalid route: must be a non-empty string.');
        toast('error', 5000, lang.nav_route_error)
        return;
    }

    // Trim and normalize the endpoint
    const cleanedEndpoint = endpoint.trim().replace(/^\/+/, '/');

    // Navigate to the new route
    window.location.href = cleanedEndpoint;
}

/**
 * Parses filters from a given container selector.
 * 
 * @param {string} selector - The CSS selector for the filters container.
 * @returns {Object} An object with filter name/value pairs.
 */
function filtersParser(selector) {
    const container = document.querySelector(selector);
    if (!documentContains(container)) return {};

    const filters = {};
    const inputs = container.querySelectorAll('input, select, textarea');

    inputs.forEach(input => {
        input = cloneNodeElement(input);
        const name = input.name;
        const value = input.value;

        if (name) {
            filters[name] = value;
        }
    });

    return filters;
}

/**
 * Watches inputs in a container and triggers a callback on change.
 * 
 * @param {string} selector - The CSS selector for the filters container.
 * @param {Function} callback - The function to call when any input changes.
 */
function watchFilterChanges(selector, callback) {
    const container = document.querySelector(selector); 
    if (!documentContains(container)) return;

    const inputs = container.querySelectorAll('input, select, textarea');
    inputs.forEach(input => {
        input = cloneNodeElement(input);
        input.addEventListener('change', (event) => {
            console.log(event.target);
            callback();
        });
    });
}

function ajaxDtParser(method, url, data={}) {
    return {
        type: method,
        url: url,
        data: data,
        dataType: 'json',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        },
        dataSrc: function (response) {
            return response.data;
        },
        error: (err) => {
            console.log(err.message || err);
            toast('error', 3000, lang.undefined_error);
        }
    }
}

/**
 * Accepts form dom and parses the form on reset functioN, and 
 * closes the modal if modal appears to be the parent container of the form.
 * 
 * @param {HTMLSelectElement} form 
 */
function resetFormAndCloseModal(form) {  
    if (!documentContains(form)) return;
    
    // Clear all input, textarea, and select fields
    form.querySelectorAll('input, textarea, select').forEach(element => {
        switch (element.type) {
            case 'checkbox':
            case 'radio':
                element.checked = false;
                break;
            case 'select-one':
            case 'select-multiple':
                element.selectedIndex = -1;
                break;
            default:
                element.value = '';
        }
    });

    // clear validation or dynamic inputs...
    form.querySelectorAll('.is-valid, .is-invalid').forEach(element => {
        element.classList.remove('is-valid', 'is-invalid');
    }); 

    // Check if the form is inside a modal
    let modal = form.closest('.modal');
    if (modal) {
        let modalInstance = bootstrap.Modal.getInstance(modal);
        if (modalInstance) {
            modalInstance.hide();
        }
    } 
}

/**
 * Checks if the given HTML element has the specified class.
 *
 * @param {Element} element - Any valid DOM element.
 * @param {string} className - The class name to check for.
 * @returns {boolean} - True if the element has the class, & false otherwise.
 */
function containsClass(element, className) {
    if (!(element instanceof Element)) {
        console.warn('Argument parsed is not a valid DOM element.');
        return false;
    }

    return element.classList.contains(className);
}

/**
 * Accepts the modal HTML element selector (class name) and shows the modal.
 * Uses both versions of bootstrap, 4 and 5 if applicable.
 * 
 * @param {string} modal - Class name or selector (e.g. 'myModal' or '.myModal').
 * @returns {void}
 */
function __show_modal(modal) {
    let selector = modal.startsWith('.') ? modal : `.${modal}`;
    let modalElement = document.querySelector(selector);

    if (!modalElement) {
        console.warn(`Modal not found: ${modal}`);
        return;
    }

    const isBootstrap5 = typeof bootstrap !== 'undefined' && typeof bootstrap.Modal !== 'undefined';

    if (isBootstrap5) { 
        let bsModal = bootstrap.Modal.getOrCreateInstance(modalElement);

        if (modalElement.classList.contains('show')) {
            bsModal.hide();
            modalElement.addEventListener('hidden.bs.modal', function handler() {
                modalElement.removeEventListener('hidden.bs.modal', handler);
                bsModal.show();
            });
        } else {
            bsModal.show();
        }
    } else if (typeof $ === 'function' && typeof $(modalElement).modal === 'function') { 
        let $modal = $(modalElement);

        if ($modal.hasClass('show')) {
            $modal.modal('hide');
            $modal.on('hidden.bs.modal', function handler() {
                $modal.off('hidden.bs.modal', handler);
                $modal.modal('show');
            });
        } else {
            $modal.modal('show');
        }
    } else {
        console.warn('No supported Bootstrap version detected.');
    }
} 

function mapCollapseToggles() { 
    const collapseElems = document.querySelectorAll('[data-bs-toggle="collapse"]');
    collapseElems.forEach(button => {
        if (!documentContains(button)) return;
        button = cloneNodeElement(button);
        button.addEventListener('click', function() {
            const icon = this.querySelector('.collapse-icon');
            if (!documentContains(icon)) return;
            icon.style.transform = this.getAttribute('aria-expanded') === 'true' 
                ? 'rotate(0deg)' 
                : 'rotate(180deg)'; 
        });
    });
}

// Call functions Below.
document.addEventListener('DOMContentLoaded', async () => {
    const masterClassInstance = new Master(); 
    stickNavbarOnScroll();
    mapCollapseToggles();
});