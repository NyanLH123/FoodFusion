(function () {
    'use strict';

    function initDeleteConfirmations() {
        document.addEventListener('click', function (event) {
            const button = event.target.closest('[data-confirm-delete]');
            if (!button) return;

            const ok = window.confirm('Are you sure you want to delete this item?');
            if (!ok) {
                event.preventDefault();
            }
        });
    }

    function initImagePreview() {
        const input = document.querySelector('[data-image-preview-input]');
        const preview = document.querySelector('[data-image-preview]');
        if (!input || !preview) return;

        input.addEventListener('change', function () {
            const file = input.files && input.files[0] ? input.files[0] : null;
            if (!file) {
                preview.classList.add('d-none');
                preview.removeAttribute('src');
                return;
            }

            const reader = new FileReader();
            reader.onload = function (event) {
                preview.src = String(event.target && event.target.result ? event.target.result : '');
                preview.classList.remove('d-none');
            };
            reader.readAsDataURL(file);
        });
    }

    function initOverlayAlerts() {
        const alerts = document.querySelectorAll('.ff-overlay-alert');
        alerts.forEach(function (alert, index) {
            const delay = 3200 + (index * 400);
            window.setTimeout(function () {
                alert.style.transition = 'opacity .2s ease, transform .2s ease';
                alert.style.opacity = '0';
                alert.style.transform = 'translateY(-6px)';
                window.setTimeout(function () {
                    if (alert.parentNode) {
                        alert.parentNode.removeChild(alert);
                    }
                }, 220);
            }, delay);
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        initDeleteConfirmations();
        initImagePreview();
        initOverlayAlerts();
    });
})();
