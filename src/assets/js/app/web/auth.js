class AuthUI extends Master {
    constructor() {
        super();
        // ANY CONSTRUCTOR LOGIC AVAILABLE
    }

    setUpPage() {
        // setup auth page
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const authUiInstance = new AuthUI();
    authUiInstance.setUpPage(); 
});