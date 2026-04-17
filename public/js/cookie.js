(function () {
    'use strict';

    var COOKIE_NAME        = 'ff_cookie_consent';
    var LEGACY_COOKIE_NAME = 'cookie_consent';

    /* ── Cookie helpers ──────────────────────────────────────────────── */

    function setCookie(name, value, days) {
        var date = new Date();
        date.setTime(date.getTime() + days * 24 * 60 * 60 * 1000);
        document.cookie =
            name + '=' + encodeURIComponent(value) +
            ';expires=' + date.toUTCString() +
            ';path=/;SameSite=Lax';
    }

    function deleteCookie(name) {
        document.cookie =
            name + '=;expires=Thu, 01 Jan 1970 00:00:00 GMT;path=/;SameSite=Lax';
    }

    function getCookie(name) {
        var key   = name + '=';
        var parts = document.cookie.split(';');
        for (var i = 0; i < parts.length; i++) {
            var part = parts[i].trim();
            if (part.indexOf(key) === 0) {
                return decodeURIComponent(part.substring(key.length));
            }
        }
        return null;
    }

    /* ── Consent state ───────────────────────────────────────────────── */

    function readConsent() {
        var value = getCookie(COOKIE_NAME);
        if (value === 'accepted' || value === 'declined') {
            return value;
        }

        // Migrate legacy cookie name silently
        var legacy = getCookie(LEGACY_COOKIE_NAME);
        if (legacy === 'accepted' || legacy === 'declined') {
            setCookie(COOKIE_NAME, legacy, 365);
            deleteCookie(LEGACY_COOKIE_NAME);
            return legacy;
        }

        return null;
    }

    /* ── Banner visibility ───────────────────────────────────────────── */

    function showBanner(banner) {
        banner.classList.remove('d-none');
    }

    function hideBanner(banner) {
        banner.classList.add('d-none');
    }

    /* ── Homepage detection ──────────────────────────────────────────── */
    /**
     * Returns true only when the visitor is on the site's homepage.
     *
     * FF_BASE is the sub-path prefix set by PHP (e.g. "" or "/test_foodfusion").
     * Homepage paths we accept:
     *   ""          → "/"
     *   "/subpath"  → "/subpath" or "/subpath/"
     */
    function isHomePage() {
        var base     = (window.FF_BASE || '').replace(/\/+$/, '');   // strip trailing slash
        var pathname = window.location.pathname.replace(/\/+$/, ''); // strip trailing slash

        // Exact match: pathname equals the base prefix (or "/" when base is empty)
        if (base === '') {
            return pathname === '' || pathname === '/';
        }
        return pathname === base || pathname === base + '/';
    }

    /* ── Initialisation ──────────────────────────────────────────────── */

    function initCookieBanner() {
        var banner = document.getElementById('cookieConsentBanner');
        if (!banner) { return; }

        // Only show on the homepage; hide immediately on all other pages.
        if (!isHomePage()) {
            hideBanner(banner);
            return;
        }

        // User already gave consent — never show again.
        if (readConsent()) {
            hideBanner(banner);
            return;
        }

        // New visitor on homepage — show the banner.
        showBanner(banner);

        var accept  = document.getElementById('cookieAccept');
        var decline = document.getElementById('cookieDecline');

        if (accept && !accept.hasAttribute('data-cookie-bound')) {
            accept.setAttribute('data-cookie-bound', '1');
            accept.addEventListener('click', function () {
                setCookie(COOKIE_NAME, 'accepted', 365);
                hideBanner(banner);
            });
        }

        if (decline && !decline.hasAttribute('data-cookie-bound')) {
            decline.setAttribute('data-cookie-bound', '1');
            decline.addEventListener('click', function () {
                setCookie(COOKIE_NAME, 'declined', 365);
                hideBanner(banner);
            });
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initCookieBanner);
    } else {
        initCookieBanner();
    }

})();
