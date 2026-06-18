/**
 * Chili Baja – home.js
 * Főoldal interakciók: scroll animációk, sticky header, mobil menü
 */

document.addEventListener('DOMContentLoaded', function () {

  // ── Sticky header scrolled osztály ──
  const header = document.getElementById('site-header');
  if (header) {
    window.addEventListener('scroll', function () {
      header.classList.toggle('scrolled', window.scrollY > 20);
    }, { passive: true });
  }

  // ── Mobil hamburger menü ──
  const menuBtn = document.getElementById('mobile-menu-btn');
  const mobileMenu = document.getElementById('mobile-menu');
  if (menuBtn && mobileMenu) {
    menuBtn.addEventListener('click', function () {
      mobileMenu.classList.toggle('open');
      menuBtn.setAttribute('aria-expanded', mobileMenu.classList.contains('open'));
    });
    // Kívülre kattintásra bezár
    document.addEventListener('click', function (e) {
      if (!menuBtn.contains(e.target) && !mobileMenu.contains(e.target)) {
        mobileMenu.classList.remove('open');
      }
    });
  }

  // ── Fade-up reveal (Intersection Observer) ──
  const fadeEls = document.querySelectorAll('.fade-up');
  if (fadeEls.length) {
    const observer = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
          observer.unobserve(entry.target);
        }
      });
    }, { threshold: 0.12 });
    fadeEls.forEach(function (el) { observer.observe(el); });
  }

  // ── Stagger grid reveal ──
  const staggerEls = document.querySelectorAll('.stagger-item');
  if (staggerEls.length) {
    const staggerObserver = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
          staggerObserver.unobserve(entry.target);
        }
      });
    }, { threshold: 0.08 });
    staggerEls.forEach(function (el) { staggerObserver.observe(el); });
  }

  // ── Hero parallax (enyhe) ──
  const heroImg = document.getElementById('hero-img');
  if (heroImg) {
    window.addEventListener('scroll', function () {
      const y = window.scrollY;
      heroImg.style.transform = 'scale(1.05) translateY(' + (y * 0.12) + 'px)';
    }, { passive: true });
  }

  // ── Scroll caret eltüntetése scrollkor ──
  const caret = document.getElementById('scroll-caret');
  if (caret) {
    window.addEventListener('scroll', function () {
      caret.style.opacity = window.scrollY > 80 ? '0' : '';
    }, { passive: true });
  }

});
