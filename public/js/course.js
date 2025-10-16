// Educational Center Form JavaScript
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('.edu-center-form');
    const fileInput = document.getElementById('logo');
    const fileDisplay = document.querySelector('.edu-center-file-display');
    const uploadText = document.querySelector('.edu-center-upload-text');
    const submitBtn = document.querySelector('.edu-center-btn-primary');
    const cancelBtn = document.querySelector('.edu-center-btn-secondary');

    // File upload handling
    fileInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            fileDisplay.classList.add('edu-center-file-selected');
            uploadText.textContent = `Tanlangan: ${file.name}`;

            // Add success animation
            fileDisplay.style.transform = 'scale(1.02)';
            setTimeout(() => {
                fileDisplay.style.transform = 'scale(1)';
            }, 200);
        } else {
            fileDisplay.classList.remove('edu-center-file-selected');
            uploadText.textContent = 'Logo yuklash';
        }
    });

    // Form validation

    requiredFields.forEach(field => {
        field.addEventListener('blur', validateField);
        field.addEventListener('input', validateField);
    });

    function validateField(e) {
        const field = e.target;
        const fieldGroup = field.closest('.edu-center-field-group');

        // Remove existing error message
        const existingError = fieldGroup.querySelector('.edu-center-error-message');
        if (existingError) {
            existingError.remove();
        }

        if (field.hasAttribute('required') && !field.value.trim()) {
            showFieldError(field, 'Bu maydon to\'ldirilishi shart');
        } else if (field.type === 'email' && field.value && !isValidEmail(field.value)) {
            showFieldError(field, 'Email manzil noto\'g\'ri formatda');
        } else {
            field.classList.remove('edu-center-error');
        }
    }

    function showFieldError(field, message) {
        field.classList.add('edu-center-error');
        const fieldGroup = field.closest('.edu-center-field-group');

        const errorDiv = document.createElement('div');
        errorDiv.className = 'edu-center-error-message';
        errorDiv.textContent = message;
        fieldGroup.appendChild(errorDiv);
    }

    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    // Form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        // Validate all required fields
        let isValid = true;
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                validateField({
                    target: field
                });
                isValid = false;
            }
        });

        if (!isValid) {
            showNotification('Iltimos, barcha majburiy maydonlarni to\'ldiring', 'error');
            return;
        }

        // Show loading state
        submitBtn.classList.add('edu-center-loading');
        submitBtn.disabled = true;

        // Simulate form submission
        setTimeout(() => {
            showNotification('O\'quv markaz muvaffaqiyatli qo\'shildi!', 'success');

            // Reset form
            form.reset();
            fileDisplay.classList.remove('edu-center-file-selected');
            uploadText.textContent = 'Logo yuklash';

            // Remove loading state
            submitBtn.classList.remove('edu-center-loading');
            submitBtn.disabled = false;
        }, 2000);
    });

    // Cancel button
    cancelBtn.addEventListener('click', function() {
        if (confirm('Haqiqatan ham bekor qilmoqchimisiz? Barcha ma\'lumotlar yo\'qoladi.')) {
            form.reset();
            fileDisplay.classList.remove('edu-center-file-selected');
            uploadText.textContent = 'Logo yuklash';

            // Clear any error messages
            const errorMessages = form.querySelectorAll('.edu-center-error-message');
            errorMessages.forEach(msg => msg.remove());

            const errorFields = form.querySelectorAll('.edu-center-error');
            errorFields.forEach(field => field.classList.remove('edu-center-error'));
        }
    });

    // Notification system
    function showNotification(message, type = 'info') {
        // Remove existing notifications
        const existingNotifications = document.querySelectorAll('.edu-center-notification');
        existingNotifications.forEach(notification => notification.remove());

        const notification = document.createElement('div');
        notification.className = `edu-center-notification edu-center-notification-${type}`;
        notification.innerHTML = `
    <div class="edu-center-notification-content">
        <span class="edu-center-notification-message">${message}</span>
        <button class="edu-center-notification-close">&times;</button>
    </div>
`;

        document.body.appendChild(notification);

        // Auto remove after 5 seconds
        setTimeout(() => {
            if (notification.parentNode) {
                notification.remove();
            }
        }, 5000);

        // Close button functionality
        const closeBtn = notification.querySelector('.edu-center-notification-close');
        closeBtn.addEventListener('click', () => {
            notification.remove();
        });

        // Animate in
        setTimeout(() => {
            notification.classList.add('edu-center-notification-show');
        }, 100);
    }

    // Input animations
    const inputs = form.querySelectorAll('.edu-center-input, .edu-center-textarea');
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentNode.classList.add('edu-center-field-focused');
        });

        input.addEventListener('blur', function() {
            this.parentNode.classList.remove('edu-center-field-focused');
        });
    });

    // Number input validation
    const numberInput = document.getElementById('studentCount');
    numberInput.addEventListener('input', function() {
        if (this.value < 0) {
            this.value = 0;
        }
    });

    // Add smooth scrolling for form validation errors
    function scrollToFirstError() {
        const firstError = form.querySelector('.edu-center-error');
        if (firstError) {
            firstError.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });
            firstError.focus();
        }
    }
});

// Add CSS for notifications and error states
const additionalStyles = `
.edu-center-error {
    border-color: #fc8181 !important;
    background: #fed7d7 !important;
}

.edu-center-error-message {
    color: #e53e3e;
    font-size: 0.875rem;
    margin-top: 0.25rem;
    font-weight: 500;
}

.edu-center-notification {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 1000;
    max-width: 400px;
    opacity: 0;
    transform: translateX(100%);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.edu-center-notification-show {
    opacity: 1;
    transform: translateX(0);
}

.edu-center-notification-content {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1rem 1.25rem;
    border-radius: 12px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    backdrop-filter: blur(10px);
}

.edu-center-notification-success .edu-center-notification-content {
    background: rgba(72, 187, 120, 0.95);
    color: white;
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.edu-center-notification-error .edu-center-notification-content {
    background: rgba(229, 62, 62, 0.95);
    color: white;
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.edu-center-notification-message {
    font-weight: 500;
    margin-right: 1rem;
}

.edu-center-notification-close {
    background: none;
    border: none;
    color: inherit;
    font-size: 1.5rem;
    cursor: pointer;
    padding: 0;
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    transition: background-color 0.2s;
}

.edu-center-notification-close:hover {
    background: rgba(255, 255, 255, 0.2);
}

.edu-center-field-focused .edu-center-label {
    color: #667eea;
    transform: translateY(-2px);
    transition: all 0.2s ease;
}

@media (max-width: 480px) {
    .edu-center-notification {
        right: 10px;
        left: 10px;
        max-width: none;
    }
}
`;

// Inject additional styles
const styleSheet = document.createElement('style');
styleSheet.textContent = additionalStyles;
document.head.appendChild(styleSheet);