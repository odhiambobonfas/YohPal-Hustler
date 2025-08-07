<div class="modal fade" id="editHProfileModal" tabindex="-1" aria-labelledby="editHProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editHProfileModalLabel">Edit Hustler Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editProfileForm" action="/crm/hustler/edit-profile" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="mb-4">
                        <div class="row g-3">
                            <div class="col-12">
                                <label for="primaryLocation" class="form-label">Primary Location</label>
                                <input required type="text" class="form-control rounded-3" name="primaryLocation" id="primaryLocation"
                                    value="<?= isset(auth()->hustler()->primaryLocation) ? auth()->hustler()->primaryLocation : '' ?>" required>
                            </div>
                            <div class="col-12">
                                <label for="workBio" class="form-label">Work Bio</label>
                                <textarea required class="form-control rounded-3" name="workBio" id="workBio" rows="3"><?= isset(auth()->hustler()->workBio) ? auth()->hustler()->workBio : 'No work bio set' ?></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Work Profile Section -->
                    <div class="mb-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="primarySkill" class="form-label">Primary Skill</label>
                                <select class="form-select searchSelect rounded-3" name="primarySkill" id="primarySkill" required>
                                    <?= $services ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="pricing" class="form-label">
                                    <i class="fas fa-dollar-sign"></i> Pricing
                                </label>
                                <div class="input-group">
                                    <input type="number" class="form-control rounded-3" name="pricing" id="pricing"
                                        value="<?= isset(auth()->hustler()->pricing) ? auth()->hustler()->pricing : '0' ?>" min="0" step="0.01" required>
                                    <select class="form-select" name="pricingType" id="pricingType" style="max-width: 120px;">
                                        <?= $pricingUnits ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <label for="skills" class="form-label">Skills</label>
                                <div class="mb-2">
                                    <select class="form-select rounded-3" id="skillsDropdown">
                                        <?= $services ?>
                                    </select>
                                </div>
                                <div id="selectedSkills" class="d-flex flex-wrap gap-2 mb-2">
                                    <!-- Selected skills will appear here as tags -->
                                </div>
                                <input type="hidden" name="skills" id="skillsInput" value="">
                                <div class="form-text">Select skills from dropdown to add them as tags</div>
                            </div>
                        </div>
                    </div>

                    <!-- Availability Section -->
                    <div class="mb-4">
                        <h6 class="fw-bold mb-3">Availability</h6>
                        <div class="row g-3">
                            <?php
                            $days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
                            $shortDays = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
                            ?>
                            <?php foreach ($days as $index => $day):
                            $isActive = isset(auth()->hustler()->availability[$index]) && auth()->hustler()->availability[$index]->active;
                            ?>
                            <div class="col text-center">
                                <div class="availability-box p-3 border rounded-3 fw-bold
                                    <?= $isActive ? 'bg-success bg-opacity-25 border-success text-white' : 'bg-danger bg-opacity-25 border-danger text-dark' ?>"
                                    data-index="<?= $index ?>"
                                    data-active="<?= $isActive ? '1' : '0' ?>"
                                    id="availBox<?= $index ?>"
                                    style="cursor:pointer;">
                                    <?= $shortDays[$index] ?>
                                    <input type="hidden" name="availability[<?= $index ?>]" id="availability<?= $index ?>" value="<?= $isActive ? 1 : 0 ?>">
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" id="saveBtn" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const dropdown = document.getElementById('skillsDropdown');
    const selectedSkillsContainer = document.getElementById('selectedSkills');
    const skillsInput = document.getElementById('skillsInput');
    let selectedSkills = [];

    // Load existing skills if any
    const existingSkills = <?= json_encode(!empty(auth()->hustler()->skills) && is_array(auth()->hustler()->skills) ? auth()->hustler()->skills : []) ?>;
    selectedSkills = [...existingSkills];
    updateSkillsDisplay();

    dropdown.addEventListener('change', function() {
        const selectedValue = this.value;
        const selectedText = this.options[this.selectedIndex].text;

        if (selectedValue && !selectedSkills.includes(selectedValue)) {
            selectedSkills.push(selectedValue);
            updateSkillsDisplay();
        }

        this.value = ''; // Reset dropdown
    });

    function updateSkillsDisplay() {
        selectedSkillsContainer.innerHTML = '';
        skillsInput.value = selectedSkills.join(',');

        selectedSkills.forEach(skill => {
            const tag = document.createElement('span');
            tag.className = 'badge bg-danger opacity-75 p-2 d-inline-flex align-items-center gap-1';
            tag.innerHTML = `
${skill}
<button type="button" class="btn-close btn-close-white" style="font-size: 0.7em;" onclick="removeSkill('${skill}')"></button>
`;
            selectedSkillsContainer.appendChild(tag);
        });
    }

    window.removeSkill = function(skill) {
        selectedSkills = selectedSkills.filter(s => s !== skill);
        updateSkillsDisplay();
    };


    document.querySelectorAll('.availability-box').forEach(box => {
        box.addEventListener('click', function () {
            const index = this.dataset.index;
            const isActive = this.dataset.active === '1';
            const input = document.getElementById('availability' + index);

            if (isActive) {
                this.classList.remove('bg-success', 'bg-opacity-25', 'border-success', 'text-white');
                this.classList.add('bg-danger', 'bg-opacity-25', 'border-danger', 'text-dark');
                this.dataset.active = '0';
                input.value = '0';
            } else {
                this.classList.remove('bg-danger', 'bg-opacity-25', 'border-danger', 'text-dark');
                this.classList.add('bg-success', 'bg-opacity-25', 'border-success', 'text-white');
                this.dataset.active = '1';
                input.value = '1';
            }
        });
    });
    ;
});

editProfileForm.addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(editProfileForm);
    const originalText = saveBtn.textContent;

    // Show loading state
    saveBtn.disabled = true;
    saveBtn.textContent = 'Saving...';

    fetch(editProfileForm.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            alert(JSON.stringify(data, null, 2));
            setTimeout(() => {
                const modal = bootstrap.Modal.getInstance(document.getElementById('editHProfileModal'));
                if (modal) {
                    modal.hide();
                }
            }, 1000);
        })
        .catch(error => {
            console.error('Error:', error);
        })
        .finally(() => {
            saveBtn.disabled = false;
            saveBtn.textContent = originalText;
        });
});
</script>
