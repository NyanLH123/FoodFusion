// Modal Logic
const modal = document.getElementById("joinUsModal");
const btn = document.getElementById("joinUsBtn");
const span = document.getElementsByClassName("close")[0];
if(btn) btn.onclick = () => modal.style.display = "block";
if(span) span.onclick = () => modal.style.display = "none";

// Cookie Logic
const cookieBanner = document.getElementById('cookieConsent');
if (localStorage.getItem('cookiesAccepted')) {
    cookieBanner.style.display = 'none';
}
document.getElementById('acceptCookies')?.addEventListener('click', () => {
    localStorage.setItem('cookiesAccepted', 'true');
    cookieBanner.style.display = 'none';
});