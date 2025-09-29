document.addEventListener('DOMContentLoaded', function () {
    const dropdown = document.getElementById('skillsDropdown');
    const selectedSkillsContainer = document.getElementById('selectedSkills');
    const skillsInput = document.getElementById('skillsInput');
    let selectedSkills = [];

    // Load existing skills if any
    const existingSkills = JSON.parse('<?= json_encode(!empty(auth()->hustler()->skills) && is_array(auth()->hustler()->skills) ? auth()->hustler()->skills : []) ?>');
    selectedSkills = [];
    updateSkillsDisplay();

    dropdown.addEventListener('change', function () {
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
            tag.innerHTML = `${skill}
                    <button type="button" class="btn-close btn-close-white" style="font-size: 0.7em;" onclick="removeSkill('${skill}')"></button>
                `;
            selectedSkillsContainer.appendChild(tag);
        });
    }

    window.removeSkill = function (skill) {
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
    });;
});

editProfileForm.addEventListener('submit', function (e) {
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