(function () {
    'use strict';

    function setCookie(name, value, days) {
        var date = new Date();
        date.setTime(date.getTime() + days * 24 * 60 * 60 * 1000);
        document.cookie = name + '=' + encodeURIComponent(value) + ';expires=' + date.toUTCString() + ';path=/;SameSite=Lax';
    }

    function getCookie(name) {
        var key = name + '=';
        var items = document.cookie.split(';');
        for (var i = 0; i < items.length; i += 1) {
            var part = items[i].trim();
            if (part.indexOf(key) === 0) {
                return decodeURIComponent(part.substring(key.length));
            }
        }
        return null;
    }

    function initCookieBanner() {
        var banner = document.getElementById('cookieBanner');
        if (!banner) {
            return;
        }

        var consent = getCookie('cookie_consent');
        if (!consent) {
            banner.style.display = 'block';
        }

        var acceptBtn = document.getElementById('cookieAccept');
        var declineBtn = document.getElementById('cookieDecline');

        if (acceptBtn) {
            acceptBtn.addEventListener('click', function () {
                setCookie('cookie_consent', 'accepted', 30);
                banner.style.display = 'none';
            });
        }

        if (declineBtn) {
            declineBtn.addEventListener('click', function () {
                setCookie('cookie_consent', 'declined', 30);
                banner.style.display = 'none';
            });
        }
    }

    function initOverlayFlash() {
        window.setTimeout(function () {
            var alerts = document.querySelectorAll('.ff-overlay-alert');
            alerts.forEach(function (alert) {
                alert.style.transition = 'opacity 0.4s ease';
                alert.style.opacity = '0';
                window.setTimeout(function () {
                    if (alert.parentNode) {
                        alert.parentNode.removeChild(alert);
                    }
                }, 420);
            });
        }, 4200);
    }

    function initSignupPopup() {
        var modalEl = document.getElementById('joinUsModal');
        if (!modalEl) {
            return;
        }

        if (document.body.getAttribute('data-logged-in') === '1') {
            return;
        }

        if (getCookie('signup_modal_dismissed') === '1') {
            return;
        }

        var modal = window.bootstrap ? new window.bootstrap.Modal(modalEl) : null;
        if (!modal) {
            return;
        }

        window.setTimeout(function () {
            modal.show();
        }, 5000);

        modalEl.addEventListener('hidden.bs.modal', function () {
            setCookie('signup_modal_dismissed', '1', 30);
        });

        var passwordInput = document.getElementById('modalPassword');
        var helper = document.getElementById('passwordStrengthText');
        if (passwordInput && helper) {
            passwordInput.addEventListener('input', function () {
                var value = passwordInput.value;
                var score = 0;
                if (/[a-z]/.test(value)) { score += 1; }
                if (/[A-Z]/.test(value)) { score += 1; }
                if (/\d/.test(value)) { score += 1; }
                if (/[^\w\s]/.test(value)) { score += 1; }
                if (value.length >= 8) { score += 1; }

                if (score <= 2) {
                    helper.textContent = 'Password strength: weak';
                    helper.className = 'form-text text-danger';
                } else if (score <= 4) {
                    helper.textContent = 'Password strength: medium';
                    helper.className = 'form-text text-warning';
                } else {
                    helper.textContent = 'Password strength: strong';
                    helper.className = 'form-text text-success';
                }
            });
        }
    }

    function initLockCountdown() {
        var lockAlert = document.querySelector('[data-lock-seconds]');
        var countdownEl = document.getElementById('lockCountdown');
        if (!lockAlert || !countdownEl) {
            return;
        }

        var seconds = parseInt(lockAlert.getAttribute('data-lock-seconds'), 10) || 0;
        countdownEl.textContent = String(seconds);

        var timer = window.setInterval(function () {
            seconds -= 1;
            if (seconds <= 0) {
                countdownEl.textContent = '0';
                window.clearInterval(timer);
                return;
            }
            countdownEl.textContent = String(seconds);
        }, 1000);
    }

    function initImagePreview() {
        var imageInput = document.getElementById('image');
        var preview = document.getElementById('imagePreview');
        if (!imageInput || !preview) {
            return;
        }

        imageInput.addEventListener('change', function () {
            var file = imageInput.files && imageInput.files[0];
            if (!file) {
                preview.src = '';
                preview.classList.add('d-none');
                return;
            }

            var reader = new FileReader();
            reader.onload = function (event) {
                preview.src = event.target && event.target.result ? String(event.target.result) : '';
                preview.classList.remove('d-none');
            };
            reader.readAsDataURL(file);
        });
    }

    function initIngredientRows() {
        var addBtn = document.getElementById('addIngredientBtn');
        var container = document.getElementById('ingredientRows');
        if (!addBtn || !container) {
            return;
        }

        addBtn.addEventListener('click', function () {
            var row = document.createElement('div');
            row.className = 'row g-2 ingredient-row';
            row.innerHTML = '<div class="col-md-5"><input type="text" class="form-control" name="ingredient_name[]" placeholder="Ingredient name"></div>' +
                '<div class="col-md-3"><input type="number" step="0.01" min="0" class="form-control" name="ingredient_amount[]" placeholder="Amount"></div>' +
                '<div class="col-md-3"><input type="text" class="form-control" name="ingredient_unit[]" placeholder="Unit"></div>' +
                '<div class="col-md-1 d-grid"><button type="button" class="btn btn-outline-danger btn-sm remove-ingredient">x</button></div>';
            container.appendChild(row);
        });

        container.addEventListener('click', function (event) {
            var target = event.target;
            if (target && target.classList.contains('remove-ingredient')) {
                var row = target.closest('.ingredient-row');
                if (row) {
                    row.remove();
                }
            }
        });
    }

    function initResourceSearch() {
        var searchInputs = document.querySelectorAll('.ff-resource-search');
        if (!searchInputs.length) {
            return;
        }

        searchInputs.forEach(function (input) {
            input.addEventListener('input', function () {
                var query = input.value.trim().toLowerCase();
                var grid = input.closest('section').querySelector('[data-resource-grid]');
                if (!grid) {
                    return;
                }

                var items = grid.querySelectorAll('[data-resource-item]');
                items.forEach(function (item) {
                    var title = item.getAttribute('data-resource-title') || '';
                    item.style.display = title.indexOf(query) !== -1 ? '' : 'none';
                });
            });
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        initCookieBanner();
        initOverlayFlash();
        initSignupPopup();
        initLockCountdown();
        initImagePreview();
        initIngredientRows();
        initResourceSearch();
    });
})();

