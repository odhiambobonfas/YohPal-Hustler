class Profile extends Master {
    constructor() {
        super();
        // ANY CONSTRUCTOR LOGIC APPLICABLE
    }

    activateNavTabNavigation() {
        const tabs = document.querySelectorAll('.nav-tabs .tab');
        const panels = document.querySelectorAll('.panel-content');

        tabs.forEach(tab => {
            if (!documentContains(tab)) return;
            tab = cloneNodeElement(tab);
            tab.addEventListener('click', (event) => {
                const target = event.target.getAttribute('data-tab'); 
                const tabs = document.querySelectorAll('.nav-tabs .tab');
                
                tabs.forEach(t => t.classList.remove('active'));
                panels.forEach(p => p.classList.remove('active'));

                event.target.classList.add('active');
                const panel = document.querySelector(`#${target}`);
                if (documentContains(panel)) panel.classList.add('active');
            });
        });
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const profileInstance = new Profile();
    profileInstance.activateNavTabNavigation();
});