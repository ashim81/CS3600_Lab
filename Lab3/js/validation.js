'use strict';

// Reload history-restored pages so the server rechecks authentication after logout.
window.addEventListener('pageshow', (event) => {
    if (event.persisted) window.location.reload();
});

document.querySelectorAll('form[data-validate]').forEach((form) => {
    // Native required/type constraints remain available when JavaScript is disabled.
    form.noValidate = true;
    const registration = form.dataset.validate === 'register';
    const fields = Array.from(form.querySelectorAll('input:not([type="hidden"])'));

    function validate(field) {
        const value = field.value;
        let message = '';
        if (value === '' || (field.type !== 'password' && value.trim() === '')) {
            message = 'This field is required.';
        } else if (field.name === 'full_name' && Array.from(value.trim()).length > 100) {
            message = 'Full name must be no more than 100 characters.';
        } else if (field.name === 'email' && (value.trim().length > 254 || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value.trim()))) {
            message = 'Enter a valid email address.';
        } else if (registration && field.name === 'password' &&
            (Array.from(value).length < 8 || new TextEncoder().encode(value).length > 72 || value.includes('\0'))) {
            message = 'Use at least 8 characters and no more than 72 bytes.';
        } else if (field.name === 'confirm_password' && value !== form.elements.password.value) {
            message = 'Passwords must match.';
        }
        document.getElementById(field.id + '-error').textContent = message;
        field.setAttribute('aria-invalid', message ? 'true' : 'false');
        return !message;
    }

    fields.forEach((field) => {
        field.addEventListener('blur', () => validate(field));
        field.addEventListener('input', () => {
            if (field.getAttribute('aria-invalid') === 'true') validate(field);
            if (registration && field.name === 'password' && form.elements.confirm_password.value) {
                validate(form.elements.confirm_password);
            }
        });
    });

    form.addEventListener('submit', (event) => {
        let firstInvalid = null;
        fields.forEach((field) => {
            if (!validate(field) && !firstInvalid) firstInvalid = field;
        });
        if (firstInvalid) {
            event.preventDefault();
            firstInvalid.focus();
        }
    });
});
