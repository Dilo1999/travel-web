/**
 * Small site-wide interactive bits: the header that turns from transparent
 * (over the home hero video) to a solid glass pill on scroll, the floating
 * WhatsApp panel, and the prev/next buttons on horizontal card rails.
 */

function initHeaderScroll() {
  const bar = document.querySelector('[data-nav-bar][data-transparent-hero]');
  if (!bar) return;

  const onScroll = () => {
    bar.classList.toggle('is-solid', window.scrollY > 80);
  };
  window.addEventListener('scroll', onScroll, { passive: true });
  onScroll();
}

function initWhatsapp() {
  const panel = document.querySelector('[data-wa-panel]');
  const toggleBtn = document.querySelector('[data-wa-toggle]');
  const closeBtn = document.querySelector('[data-wa-close]');
  if (!panel) return;

  const setOpen = (open) => {
    panel.classList.toggle('hidden', !open);
    if (toggleBtn) toggleBtn.setAttribute('aria-expanded', open ? 'true' : 'false');
  };

  if (toggleBtn) {
    toggleBtn.addEventListener('click', () => setOpen(panel.classList.contains('hidden')));
  }
  if (closeBtn) closeBtn.addEventListener('click', () => setOpen(false));

  // Any "WhatsApp us" button elsewhere on the page (package cards, CTAs) opens the same panel.
  document.querySelectorAll('[data-wa-open]').forEach((el) => {
    el.addEventListener('click', (ev) => {
      ev.preventDefault();
      setOpen(true);
    });
  });
}

function initRails() {
  document.querySelectorAll('[data-rail]').forEach((rail) => {
    const track = rail.querySelector('[data-rail-track]');
    const prev = rail.querySelector('[data-rail-prev]');
    const next = rail.querySelector('[data-rail-next]');
    if (!track) return;

    const scrollByStep = (dir) => {
      const card = track.firstElementChild;
      const step = card ? card.getBoundingClientRect().width + 16 : 320;
      track.scrollBy({ left: dir * step * 2, behavior: 'smooth' });
    };

    if (prev) prev.addEventListener('click', () => scrollByStep(-1));
    if (next) next.addEventListener('click', () => scrollByStep(1));
  });
}

function initWidgets() {
  initHeaderScroll();
  initWhatsapp();
  initRails();
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', initWidgets);
} else {
  initWidgets();
}
