let jobs = {}; // Global variable to store fetched jobs data
const userRatings = {};

// Fetch jobs data from external JSON file
async function loadJobsData() {
    try {
        const response = await fetch('../../assets/json/jobs.json');
        if (!response.ok) {
            throw new Error(`Failed to fetch jobs data: ${response.status}`);
        }
        jobs = await response.json();
        // Initialize with the first job after data is loaded
        const firstItem = document.querySelector('#jobs-list li[data-id]');
        if (firstItem) {
            showDetails(parseInt(firstItem.getAttribute('data-id')));
        } else {
            document.getElementById('jobs-details-content').innerHTML = '<p>No jobs available. Please add a new job.</p>';
        }
    } catch (error) {
        console.error('Error loading jobs data:', error);
        document.getElementById('jobs-details-content').innerHTML = '<p>Error loading job data. Please try again later.</p>';
    }
}

function showDetails(id) {
    const details = document.getElementById('jobs-details-content');

    // Check if job exists, otherwise show fallback message
    if (!jobs[id]) {
        details.innerHTML = '<p>No job details available. Please select a job.</p>';
        document.querySelectorAll('#jobs-list li').forEach(item => {
            item.classList.remove('active');
        });
        return;
    }

    const job = jobs[id];
    const userRating = userRatings[id] || null;

    let content = `
                <div class="jobs-details-header">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <img src="../assets/store/images/app/company.png" alt="${job.company || 'Company'}">
                        <div>
                            <div class="jobs-details-title">${job.title || 'N/A'}</div>
                            <div class="jobs-details-subtitle">${job.company || 'N/A'}</div>
                        </div>
                    </div>
                    <a href="./index.php?url=rate&jobId=${id}" target="_self" class="rate-client">Rate Client</a>
                </div>
                <div class="jobs-details-info">
                    <div><span class="label">Posted:</span> ${job.posted || 'N/A'}</div>
                    <div><span class="label">Expires:</span> ${job.expires || 'N/A'}</div>
                    <div><span class="label">Location:</span> ${job.location || 'N/A'}</div>
                    <div><span class="label">Salary:</span> ${job.salary || 'N/A'}</div>
                    <div><span class="label">Hours:</span> ${job.hours || 'N/A'}</div>
                    <span class="jobs-details-status jobs-status ${job.status || ''}">${job.status ? job.status.charAt(0).toUpperCase() + job.status.slice(1) : 'N/A'}</span>
                </div>
                <div class="jobs-description">
                    <h3>Description</h3>
                    <p>${job.description || 'No description available.'}</p>
                    <h3>Responsibilities</h3>
                    <ul>
                        ${(job.responsibilities || []).map(item => `<li>${item}</li>`).join('') || '<li>No responsibilities listed.</li>'}
                    </ul>
                    <h3>Requirements</h3>
                    <ul>
                        ${(job.requirements || []).map(item => `<li>${item}</li>`).join('') || '<li>No requirements listed.</li>'}
                    </ul>
                </div>
                <div class="jobs-feedback">
                    <h3>Client Review</h3>
                    ${job.feedback ? `
                        <div class="feedback-content">${job.feedback.text}</div>
                        <div class="feedback-grid">
                            ${job.feedback.categories.map(category => `
                                <div class="feedback-item">
                                    <span class="feedback-label">${category.label}</span>
                                    <span class="feedback-stars">
                                        ${Array(5).fill().map((_, i) => `
                                            <span class="${i < category.stars ? 'star-active' : 'star-inactive'}">★</span>
                                        `).join('')}
                                    </span>
                                </div>
                            `).join('')}
                        </div>
                        <div class="feedback-total">Overall: <span class="stars">
                            ${Array(5).fill().map((_, i) => `
                                <span class="${i < job.feedback.total ? 'star-active' : 'star-inactive'}">★</span>
                            `).join('')}
                        </span> (${job.feedback.total}/5)</div>
                    ` : '<p>No client review available yet.</p>'}
                    ${userRating ? `
                        <h3>Your Rating</h3>
                        <div class="user-feedback">
                            <div class="feedback-grid">
                                ${userRating.categories.map(category => `
                                    <div class="feedback-item">
                                        <span class="feedback-label">${category.label}</span>
                                        <span class="feedback-stars">
                                            ${Array(5).fill().map((_, i) => `
                                                <span class="${i < category.stars ? 'star-active' : 'star-inactive'}">★</span>
                                            `).join('')}
                                        </span>
                                    </div>
                                `).join('')}
                            </div>
                            <div class="feedback-overall-label">Overall: <span class="stars">
                                ${Array(5).fill().map((_, i) => `
                                    <span class="${i < userRating.total ? 'star-active' : 'star-inactive'}">★</span>
                                `).join('')}
                            </span> (${userRating.total}/5)</div>
                            <p>Comment: ${userRating.comment || 'No comment provided.'}</p>
                        </div>
                    ` : ''}
                </div>
            `;

    details.innerHTML = content;
    // Scroll to top of jobs-details-panel for better visibility
    details.scrollTop = 0;

    // Update active job item
    document.querySelectorAll('#jobs-list li').forEach(item => {
        item.classList.remove('active');
    });
    const activeItem = document.querySelector(`li[data-id="${id}"]`);
    if (activeItem) {
        activeItem.classList.add('active');
    }
}

const selectAllCheckbox = document.getElementById('jobs-select-all-checkbox');
const jobListContainer = document.getElementById('jobs-list');
const deleteButton = document.getElementById('jobs-delete-button');

function updateDeleteButton() {
    const checkboxes = jobListContainer.querySelectorAll('.jobs-checkbox');
    deleteButton.disabled = !Array.from(checkboxes).some(cb => cb.checked);
}

function updateSelectAllState() {
    const checkboxes = jobListContainer.querySelectorAll('.jobs-checkbox');
    const allChecked = Array.from(checkboxes).every(cb => cb.checked);
    const someChecked = Array.from(checkboxes).some(cb => cb.checked);

    selectAllCheckbox.checked = allChecked;
    selectAllCheckbox.indeterminate = someChecked && !allChecked;
    updateDeleteButton();
}

function initializeCheckboxes() {
    const checkboxes = jobListContainer.querySelectorAll('.jobs-checkbox');
    checkboxes.forEach(checkbox => {
        // Prevent checkbox click from triggering job selection
        checkbox.removeEventListener('click', stopPropagation);
        checkbox.addEventListener('click', stopPropagation);
        checkbox.removeEventListener('change', updateSelectAllState);
        checkbox.addEventListener('change', updateSelectAllState);
    });
}

// Prevent checkbox click from triggering list item click
function stopPropagation(e) {
    e.stopPropagation();
}

initializeCheckboxes();

selectAllCheckbox.addEventListener('change', function () {
    const checkboxes = jobListContainer.querySelectorAll('.jobs-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = selectAllCheckbox.checked;
    });
    updateDeleteButton();
});

deleteButton.addEventListener('click', function () {
    if (confirm('Are you sure you want to delete the selected jobs?')) {
        const checkboxes = jobListContainer.querySelectorAll('.jobs-checkbox:checked');
        const selectedIds = Array.from(checkboxes).map(checkbox =>
            checkbox.parentElement.getAttribute('data-id')
        );

        selectedIds.forEach(id => {
            const listItem = jobListContainer.querySelector(`li[data-id="${id}"]`);
            if (listItem) {
                listItem.remove();
                delete userRatings[id];
                delete jobs[id]; // Remove from jobs object
            }
        });

        selectAllCheckbox.checked = false;
        selectAllCheckbox.indeterminate = false;
        updateDeleteButton();

        if (jobListContainer.children.length === 0) {
            jobListContainer.innerHTML = '<li>No jobs available.</li>';
            document.getElementById('jobs-details-content').innerHTML = '<p>No jobs available. Please add a new job.</p>';
        } else {
            const firstRemainingItem = jobListContainer.querySelector('li[data-id]');
            if (firstRemainingItem) {
                showDetails(parseInt(firstRemainingItem.getAttribute('data-id')));
            } else {
                document.getElementById('jobs-details-content').innerHTML = '<p>No jobs selected.</p>';
            }
        }

        initializeCheckboxes();
    }
});

function initializeListItems() {
    document.querySelectorAll('#jobs-list li').forEach(item => {
        item.removeEventListener('click', handleListItemClick);
        item.addEventListener('click', handleListItemClick);
    });
}

function handleListItemClick(e) {
    // Only trigger if the click is not on the checkbox
    if (e.target !== this.querySelector('input[type="checkbox"]')) {
        const id = parseInt(this.getAttribute('data-id'));
        showDetails(id);
    }
}

initializeListItems();

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
        if (activeItem && parseInt(activeItem.getAttribute('data-id')) === jobId) {
            showDetails(jobId);
        }
    }
});

// Load jobs data on page load
loadJobsData();