const doc = document.documentElement;

const setTheme = (theme) => {
  doc.setAttribute('data-theme', theme);
  localStorage.setItem('theme', theme);
};
setTheme(localStorage.getItem('theme') || 'light');

document.getElementById('themeToggle')?.addEventListener('click', () => {
  setTheme(doc.getAttribute('data-theme') === 'dark' ? 'light' : 'dark');
});

document.getElementById('menuToggle')?.addEventListener('click', (e) => {
  const nav = document.getElementById('primaryNav');
  const open = nav.classList.toggle('open');
  e.currentTarget.setAttribute('aria-expanded', String(open));
});

window.addEventListener('scroll', () => {
  document.getElementById('siteHeader')?.classList.toggle('scrolled', window.scrollY > 8);
});

const openModal = (id) => document.getElementById(id)?.removeAttribute('hidden');
const closeAllModals = () => document.querySelectorAll('.modal').forEach((m) => m.setAttribute('hidden', ''));

document.getElementById('joinUsTrigger')?.addEventListener('click', () => openModal('joinUsModal'));
document.getElementById('heroJoinUs')?.addEventListener('click', () => openModal('joinUsModal'));
document.querySelectorAll('[data-modal-open]').forEach((btn) => btn.addEventListener('click', () => openModal(btn.dataset.modalOpen)));
document.querySelectorAll('[data-modal-close]').forEach((btn) => btn.addEventListener('click', closeAllModals));
document.querySelectorAll('.modal').forEach((m) => m.addEventListener('click', (e) => { if (e.target === m) closeAllModals(); }));

const banner = document.getElementById('cookieBanner');
if (!localStorage.getItem('cookieChoice')) banner.style.display = 'flex';
document.getElementById('acceptCookies')?.addEventListener('click', () => { localStorage.setItem('cookieChoice', 'accepted'); banner.style.display = 'none'; });
document.getElementById('rejectCookies')?.addEventListener('click', () => { localStorage.setItem('cookieChoice', 'rejected'); banner.style.display = 'none'; });

const createPostToggle = document.getElementById('createPostToggle');
createPostToggle?.addEventListener('click', () => {
  const form = document.getElementById('createPostForm');
  const hidden = form.classList.toggle('hidden');
  createPostToggle.setAttribute('aria-expanded', String(!hidden));
});
