// modules/passwordToggle.js

export function initializePasswordToggle() {
    // Select all elements with the data-toggle-password attribute
    const toggleButtons = document.querySelectorAll('[data-toggle-password]');

    toggleButtons.forEach(button => {
        const fieldId = button.getAttribute('data-toggle-password');
        const passwordField = document.getElementById(fieldId);

        if (passwordField) {
            button.addEventListener('click', () => {
                // Toggle password visibility
                if (passwordField.type === 'password') {
                    passwordField.type = 'text';
                    button.querySelector('svg').setAttribute('fill', 'currentColor');  // Optional: change icon color
                } else {
                    passwordField.type = 'password';
                    button.querySelector('svg').setAttribute('fill', 'none');  // Optional: revert icon color
                }
            });
        }
    });
}
