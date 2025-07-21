let activities = []; // Global variable to store fetched activities data
const userRatings = {};

// Initialize the modal once
const invoiceModalElement = document.getElementById('invoiceModal');
const invoiceModal = new bootstrap.Modal(invoiceModalElement, {});

// Clean up the modal when it is hidden
invoiceModalElement.addEventListener('hidden.bs.modal', function () {
    console.log('Modal hidden, cleaning up backdrop');
    document.querySelectorAll('.modal-backdrop').forEach(backdrop => backdrop.remove());
    document.body.classList.remove('modal-open');
    invoiceModalElement.removeAttribute('aria-modal');
    invoiceModalElement.style.display = 'none';
});

// Fetch activities data
async function loadActivitiesData() {
    try {
        const response = await fetch('/hustler/job-request');
        if (!response.ok) {
            throw new Error(`Failed to fetch activities data: ${response.status}`);
        }

        const data = await response.json();
        activities = data.jobRequests;
        console.log(JSON.stringify(activities));

        // Populate the sidebar list
        populateActivitiesList();

        // Initialize with the first activity if available and has an id
        if (activities.length > 0 && activities[0].id != null) {
            showDetails(activities[0].id);
        } else {
            document.getElementById('jobs-no-activities').style.display = 'block';
        }
    } catch (error) {
        console.error('Error loading activities:', error);
    }
}

function populateActivitiesList() {
    const jobsList = document.getElementById('jobs-list');
    const noActivitiesMessage = document.getElementById('jobs-no-activities');
    jobsList.innerHTML = ''; // Clear existing items

    if (activities.length === 0) {
        noActivitiesMessage.style.display = 'block';
        return;
    }

    noActivitiesMessage.style.display = 'none';

    activities.forEach((activity, index) => {
        const listItem = document.createElement('li');
        listItem.setAttribute('data-id', activity.id);

        if (index === 0) {
            listItem.classList.add('active');
        }

        listItem.innerHTML = `
                <span>${activity.name} - ${activity.description || 'No description available'}</span>
                <span class="jobs-status ${getStatusClass(activity.status)}">${activity.status}</span>
            `;

        listItem.addEventListener('click', function () {
            showDetails(activity.id);
        });

        jobsList.appendChild(listItem);
    });
}

function getStatusClass(status) {
    const statusMap = {
        'Completed': 'completed',
        'Ongoing': 'ongoing',
        'Pending': 'pending',
        'Cancelled': 'cancelled',
        'Open': 'open'
    };
    return statusMap[status] || '';
}

async function loadInvoiceContent(jobId) {
    const modalBody = document.getElementById('invoiceModalBody');
    const activity = activities.find(a => String(a.id) === String(jobId));
    try {
        // Placeholder: Replace with actual API call
        // const response = await fetch(`/hustler/invoice?jobId=${jobId}`);
        modalBody.innerHTML = `
               <div class="invoice-container">
                    <h1>Job Summary</h1>

                    <div class="job-header">
                        <div class="job-info">
                            <p><strong>Job Title:</strong> ${activity.name}</p>
                            <p><strong>Freelancer Name:</strong> David</p>
                            <p><strong>Email:</strong> kamaudavid60@gmail.com</p>
                            <p><strong>Job ID:</strong> ${activity.id}</p>
                        </div>
                        <div>
                            <p><strong>Job Status:</strong> <span class="job-status">${activity.status}</span></p>
                        </div>
                    </div>

                    <h2>WORK TIMELINE</h2>
                    <div class="timeline">
                        <div class="timeline-item">
                            <span class="timeline-label">Start</span>
                            <span> ${new Date(activity.startTime._seconds * 1000).toLocaleString()}</span>
                        </div>
                        <div class="timeline-item">
                            <span class="timeline-label">End</span>
                            <span>${new Date(activity.endTime._seconds * 1000).toLocaleString()}</span>
                        </div>
                        
                    </div>

                    <div class="payment-section">
                        <h2>Payment Breakdown</h2>

                        <div class="payment-item">
                            <span><input type="checkbox" class="checkbox" disabled> Job Fee</span>
                            <span>KES 2,250</span>
                        </div>
                        <div class="payment-item">
                            <span><input type="checkbox" class="checkbox" checked disabled> Transport Fee</span>
                            <span>KES 250</span>
                        </div>
                        <div class="payment-item">
                            <span><input type="checkbox" class="checkbox" disabled> Tax Fee</span>
                            <span>KES 250</span>
                        </div>

                        <div class="payment-item payment-total">
                            <span><input type="checkbox" class="checkbox" disabled> Total Payment</span>
                            <span>KES 2,750</span>
                        </div>
                    </div>

                    <div class="job-description">
                        <h3>JOB DESCRIPTION</h3>
                        <p>${activity.description}</p>
                    </div>
                </div>
            `;
    } catch (error) {
        console.error('Error loading invoice:', error);
        modalBody.innerHTML = '<p>Error loading invoice details. Please try again.</p>';
    }
}

function showDetails(id) {
    const activity = activities.find(a => String(a.id) === String(id));
    const details = document.getElementById('jobs-details-content');

    if (!activity) {
        details.innerHTML = '<p>No details available for this activity.</p>';
        return;
    }

    // Build hustler reviews content from the client's perspective
    let hustlersReviewsContent = '';
    if (activity.hustlers) {
        hustlersReviewsContent = `
            <div class="jobs-hustlers-reviews">
                <h3>Hustler Reviews</h3>
                <div class="reviews-section">
                    <h4>Reviews You Gave to Hustlers</h4>
                    ${Object.entries(activity.hustlers)
                .filter(([_, hustler]) => hustler.reviews && hustler.reviews.received)
                .map(([hustlerId, hustler]) => {
                    const received = hustler.reviews.received;
                    const starFields = Object.entries(received)
                        .filter(([key, _]) => key !== 'comment' && received[key].type === 'star');
                    const overallRating = starFields.length > 0
                        ? Math.round(starFields.reduce((sum, [_, value]) => sum + value.value, 0) / starFields.length)
                        : 0;
                    return `
                                <div class="hustler-review">
                                    <div class="jobs-feedback">
                                        <div class="feedback-grid">
                                            ${starFields.map(([key, value]) => `
                                                <div class="feedback-item">
                                                    <span class="feedback-label">${key.charAt(0).toUpperCase() + key.slice(1)}</span>
                                                    <span class="feedback-stars">
                                                        ${Array(5).fill().map((_, i) => `
                                                            <span class="${i < value.value ? 'star-active' : 'star-inactive'}">★</span>
                                                        `).join('')}
                                                    </span>
                                                </div>
                                            `).join('')}
                                        </div>
                                        <div class="feedback-total">Overall: <span class="stars">
                                            ${Array(5).fill().map((_, i) => `
                                                <span class="${i < overallRating ? 'star-active' : 'star-inactive'}">★</span>
                                            `).join('')}
                                        </span> (${overallRating}/5)</div>
                                        ${received.comment ? `
                                            <p>${received.comment.value || 'No comment provided.'}</p>
                                        ` : ''}
                                    </div>
                                </div>
                            `;
                }).join('') || '<p>No reviews given to hustlers.</p>'}
                </div>
                <div class="reviews-section">
                    <h4>Reviews You Received from Hustlers</h4>
                    ${Object.entries(activity.hustlers)
                .filter(([_, hustler]) => hustler.reviews && hustler.reviews.sent)
                .map(([hustlerId, hustler]) => {
                    const sent = hustler.reviews.sent;
                    const starFields = Object.entries(sent)
                        .filter(([key, _]) => key !== 'comment' && sent[key].type === 'star');
                    const overallRating = starFields.length > 0
                        ? Math.round(starFields.reduce((sum, [_, value]) => sum + value.value, 0) / starFields.length)
                        : 0;
                    return `
                                <div class="hustler-review">
                                    <div class="jobs-feedback">
                                        <div class="feedback-grid">
                                            ${starFields.map(([key, value]) => `
                                                <div class="feedback-item">
                                                    <span class="feedback-label">${key.charAt(0).toUpperCase() + key.slice(1)}</span>
                                                    <span class="feedback-stars">
                                                        ${Array(5).fill().map((_, i) => `
                                                            <span class="${i < value.value ? 'star-active' : 'star-inactive'}">★</span>
                                                        `).join('')}
                                                    </span>
                                                </div>
                                            `).join('')}
                                        </div>
                                        <div class="feedback-total">Overall: <span class="stars">
                                            ${Array(5).fill().map((_, i) => `
                                                <span class="${i < overallRating ? 'star-active' : 'star-inactive'}">★</span>
                                            `).join('')}
                                        </span> (${overallRating}/5)</div>
                                        ${sent.comment ? `
                                            <p>${sent.comment.value || 'No comment provided.'}</p>
                                        ` : ''}
                                    </div>
                                </div>
                            `;
                }).join('') || '<p>No reviews received from hustlers.</p>'}
                </div>
            </div>
        `;
    }

    let content = `
        <div class="jobs-details-header">
            <div style="display: flex; align-items: center; gap: 12px;">
                <img src="../assets/store/images/app/company.png" alt="${activity.company || 'Company'}">
                <div>
                    <div class="jobs-details-title">${activity.name}</div>
                    <div class="jobs-details-subtitle">${activity.company || ''}</div>
                </div>
            </div>
            <button class="btn btn-primary rate-client" data-bs-toggle="modal" data-bs-target="#invoiceModal" data-job-id="${id}" style="background: #FF0000; color: white; font-weight: bold; border: none">Invoice</button>
        </div>
        <div class="jobs-details-info">
            <div><span class="label">Posted:</span> ${new Date(activity.createdAt._seconds * 1000).toLocaleString()}</div>
            <div><span class="label">Status:</span> <span class="jobs-status ${getStatusClass(activity.status)}">${activity.status}</span></div>
            <div><span class="label">Location:</span> ${activity.location || ''}</div>
            <div><span class="label">Salary:</span> ${activity.salary || ''}</div>
        </div>
        <div class="jobs-description">
            <h3>Description</h3>
            <p>${activity.description || 'No description available.'}</p>
        </div>
        ${hustlersReviewsContent}
    `;

    details.innerHTML = content;
    details.scrollTop = 0;

    document.querySelectorAll('#jobs-list li').forEach(item => {
        item.classList.remove('active');
    });
    const activeItem = document.querySelector(`li[data-id="${id}"]`);
    if (activeItem) {
        activeItem.classList.add('active');
    }

    // Use event delegation for .rate-client buttons
    document.getElementById('jobs-details-content').addEventListener('click', function (event) {
        if (event.target.classList.contains('rate-client')) {
            const jobId = event.target.getAttribute('data-job-id');
            console.log('Invoice button clicked for job ID:', jobId); // Debug log
            loadInvoiceContent(jobId);
            invoiceModal.show();
        }
    }, {
        once: true
    }); // Ensure the listener is added only once
}

// Event listeners for modal buttons
document.getElementById('reportIssueBtn').addEventListener('click', function () {
    console.log('Report Issue button clicked');
    // Add your logic for reporting an issue
    bootstrap.Modal.getInstance(invoiceModalElement).hide();
});

document.getElementById('downloadReceiptBtn').addEventListener('click', function () {
    console.log('Download Receipt button clicked');
    // Add your logic for downloading the receipt
    bootstrap.Modal.getInstance(invoiceModalElement).hide();
});

document.addEventListener('DOMContentLoaded', function () {
    loadActivitiesData();

    window.addEventListener('message', function (event) {
        if (event.data.type === 'submitRating') {
            const {
                jobId,
                ratings,
                comment
            } = event.data;
            const total = Math.round(
                (ratings.Competence + ratings.Quality + ratings.Timeliness + ratings.Reliability) / 4
            );
            userRatings[jobId] = {
                categories: [{
                    label: 'Competence',
                    stars: ratings.Competence
                },
                {
                    label: 'Quality',
                    stars: ratings.Quality
                },
                {
                    label: 'Timeliness',
                    stars: ratings.Timeliness
                },
                {
                    label: 'Reliability',
                    stars: ratings.Reliability
                }
                ],
                total,
                comment
            };

            const activeItem = document.querySelector('li.active');
            if (activeItem && String(activeItem.getAttribute('data-id')) === String(jobId)) {
                showDetails(jobId);
            }
        }
    });
});