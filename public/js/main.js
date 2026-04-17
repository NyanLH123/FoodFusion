(function () {
    'use strict';

    function base(path) {
        return (window.FF_BASE || '') + path;
    }

    function setCookie(name, value, days) {
        const date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        document.cookie = name + '=' + encodeURIComponent(value) + ';expires=' + date.toUTCString() + ';path=/';
    }

    function getCookie(name) {
        const key = name + '=';
        const parts = document.cookie.split(';');
        for (let i = 0; i < parts.length; i += 1) {
            const part = parts[i].trim();
            if (part.indexOf(key) === 0) {
                return decodeURIComponent(part.substring(key.length));
            }
        }
        return null;
    }

    function escapeHtml(value) {
        return String(value || '')
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
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

    function initAjaxRegistration() {
        const form = document.getElementById('joinUsForm');
        const feedback = document.getElementById('joinUsFeedback');
        if (!form || !feedback) return;

        form.addEventListener('submit', async function (event) {
            event.preventDefault();
            feedback.className = 'small text-muted mb-2';
            feedback.textContent = 'Submitting...';

            const formData = new FormData(form);

            try {
                const response = await fetch(base('/auth/register'), {
                    method: 'POST',
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                    body: formData
                });

                const json = await response.json();
                if (json.success) {
                    feedback.className = 'small text-success mb-2';
                    feedback.textContent = json.message || 'Registration successful.';
                    form.reset();
                } else {
                    feedback.className = 'small text-danger mb-2';
                    feedback.textContent = (json.errors || ['Registration failed.']).join(' ');
                }
            } catch (error) {
                feedback.className = 'small text-danger mb-2';
                feedback.textContent = 'Network error. Please try again.';
            }
        });
    }

    async function loadComments(postId, container) {
        try {
            const res = await fetch(base('/cookbook/comments?postId=' + encodeURIComponent(postId)), {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });
            const json = await res.json();
            if (!json.success) {
                container.innerHTML = '<span class="text-muted">No comments.</span>';
                return;
            }

            if (!Array.isArray(json.comments) || json.comments.length === 0) {
                container.innerHTML = '<span class="text-muted">No comments yet.</span>';
                return;
            }

            container.innerHTML = json.comments.map(function (c) {
                const name = escapeHtml((c.firstname || '') + ' ' + (c.lastname || ''));
                const message = escapeHtml(c.message || '');
                return '<div class="border rounded-3 p-2 mb-2"><strong>' + name + '</strong><div>' + message + '</div></div>';
            }).join('');
        } catch (error) {
            container.innerHTML = '<span class="text-danger">Failed to load comments.</span>';
        }
    }

    function setLikeState(button, isLiked) {
        button.setAttribute('data-liked', isLiked ? '1' : '0');
        button.setAttribute('aria-pressed', isLiked ? 'true' : 'false');
        button.classList.toggle('is-active', isLiked);

        const icon = button.querySelector('.js-like-icon');
        if (icon) {
            icon.classList.remove('bi-heart', 'bi-heart-fill');
            icon.classList.add(isLiked ? 'bi-heart-fill' : 'bi-heart');
        }

        const label = button.querySelector('.js-like-label');
        if (label) {
            label.textContent = isLiked ? 'Liked' : 'Like';
        }
    }

    function setShareState(button, isShared) {
        button.setAttribute('data-shared', isShared ? '1' : '0');
        button.setAttribute('aria-pressed', isShared ? 'true' : 'false');
        button.classList.toggle('is-active', isShared);
        button.disabled = isShared;

        const icon = button.querySelector('.js-share-icon');
        if (icon) {
            icon.classList.remove('bi-share', 'bi-share-fill');
            icon.classList.add(isShared ? 'bi-share-fill' : 'bi-share');
        }

        const label = button.querySelector('.js-share-label');
        if (label) {
            label.textContent = isShared ? 'Shared' : 'Share';
        }
    }

    function initCookbookAjax() {
        document.querySelectorAll('.js-comments').forEach(function (container) {
            const postId = container.getAttribute('data-post-id');
            if (postId) {
                loadComments(postId, container);
            }
        });

        document.querySelectorAll('.js-like-btn').forEach(function (button) {
            button.addEventListener('click', async function () {
                if (button.getAttribute('data-loading') === '1') return;

                const postId = button.getAttribute('data-post-id');
                const body = new URLSearchParams({ postId: postId, type: 'like' });
                button.setAttribute('data-loading', '1');

                try {
                    const response = await fetch(base('/cookbook/interact'), {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: body.toString()
                    });

                    if (response.status === 401) {
                        window.location.href = base('/auth/login');
                        return;
                    }

                    const json = await response.json();
                    if (json.success) {
                        const card = button.closest('[data-post-card]');
                        const count = card ? card.querySelector('.js-like-count') : null;
                        if (count) count.textContent = String(json.totalInteraction || 0);
                        setLikeState(button, Boolean(json.isLiked));
                    }
                } catch (error) {
                    // keep UI stable on request failure
                } finally {
                    button.removeAttribute('data-loading');
                }
            });
        });

        document.querySelectorAll('.js-comment-form').forEach(function (form) {
            form.addEventListener('submit', async function (event) {
                event.preventDefault();
                const postId = form.getAttribute('data-post-id');
                const messageInput = form.querySelector('input[name="message"]');
                if (!messageInput || !messageInput.value.trim()) return;

                const body = new URLSearchParams({ postId: postId, message: messageInput.value.trim() });

                try {
                    const response = await fetch(base('/cookbook/comment'), {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: body.toString()
                    });
                    const json = await response.json();
                    if (json.success) {
                        messageInput.value = '';
                        const commentsContainer = document.querySelector('.js-comments[data-post-id="' + postId + '"]');
                        if (commentsContainer) {
                            loadComments(postId, commentsContainer);
                        }
                    }
                } catch (error) {
                    // keep UI stable on request failure
                }
            });
        });

        document.querySelectorAll('.js-share-btn').forEach(function (button) {
            button.addEventListener('click', async function () {
                if (button.getAttribute('data-loading') === '1' || button.getAttribute('data-shared') === '1') {
                    return;
                }

                const postId = button.getAttribute('data-post-id');
                const shareUrl = button.getAttribute('data-share-url') || window.location.href;
                const body = new URLSearchParams({ postId: postId });
                button.setAttribute('data-loading', '1');

                try {
                    const response = await fetch(base('/cookbook/share'), {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: body.toString()
                    });

                    if (response.status === 401) {
                        window.location.href = base('/auth/login');
                        return;
                    }

                    const json = await response.json();
                    if (json.success) {
                        const card = button.closest('[data-post-card]');
                        const count = card ? card.querySelector('.js-share-count') : null;
                        if (count) count.textContent = String(json.totalshare || 0);
                        setShareState(button, Boolean(json.isShared));

                        try {
                            await navigator.clipboard.writeText(shareUrl);
                        } catch (error) {
                            // ignore clipboard errors
                        }
                    }
                } catch (error) {
                    // keep UI stable on request failure
                } finally {
                    button.removeAttribute('data-loading');
                }
            });
        });
    }

    function initPopupTimer() {
        const modalElement = document.getElementById('joinUsModal');
        const loggedIn = document.body.getAttribute('data-logged-in') === '1';
        if (!modalElement || loggedIn) return;
        if (getCookie('signup_popup_seen') === '1') return;

        const modal = new bootstrap.Modal(modalElement);
        setTimeout(function () {
            modal.show();
            setCookie('signup_popup_seen', '1', 30);
        }, 3000);
    }

    function initRecipeFilterAutoSubmit() {
        const form = document.getElementById('recipeFilterForm');
        if (!form) return;
        form.querySelectorAll('select').forEach(function (select) {
            select.addEventListener('change', function () {
                form.submit();
            });
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        initOverlayAlerts();
        initAjaxRegistration();
        initCookbookAjax();
        initPopupTimer();
        initRecipeFilterAutoSubmit();
    });
})();
