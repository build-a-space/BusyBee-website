/* Busy Bee — front-end interactions */
(function () {
  'use strict';

  // Mobile nav
  var toggle = document.querySelector('.nav-toggle');
  var nav = document.getElementById('site-nav');
  if (toggle && nav) {
    toggle.addEventListener('click', function () {
      var open = nav.classList.toggle('open');
      toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
      document.body.classList.toggle('nav-open', open);
    });
    nav.querySelectorAll('.sub-toggle').forEach(function (btn) {
      btn.addEventListener('click', function () {
        var li = btn.closest('li');
        var open = li.classList.toggle('sub-open');
        btn.setAttribute('aria-expanded', open ? 'true' : 'false');
      });
    });
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape' && nav.classList.contains('open')) {
        nav.classList.remove('open');
        document.body.classList.remove('nav-open');
        toggle.setAttribute('aria-expanded', 'false');
        toggle.focus();
      }
    });
  }

  // FAQ live filter
  var filter = document.querySelector('[data-faq-filter]');
  if (filter) {
    filter.addEventListener('input', function () {
      var q = filter.value.trim().toLowerCase();
      document.querySelectorAll('.faq details').forEach(function (d) {
        var match = !q || d.textContent.toLowerCase().indexOf(q) !== -1;
        d.classList.toggle('hidden', !match);
        if (q && match) d.open = true;
      });
    });
  }

  // Light client-side validation on quote forms
  document.querySelectorAll('.quote-form').forEach(function (form) {
    form.addEventListener('submit', function (e) {
      var name = form.querySelector('[name=name]');
      var phone = form.querySelector('[name=phone]');
      var email = form.querySelector('[name=email]');
      var digits = (phone.value || '').replace(/\D/g, '');
      var ok = name.value.trim() !== '' && (digits.length >= 10 || (email.value && email.checkValidity()));
      if (!ok) {
        e.preventDefault();
        (name.value.trim() === '' ? name : phone).focus();
        var msg = form.querySelector('.alert.bad.js');
        if (!msg) {
          msg = document.createElement('div');
          msg.className = 'alert bad js';
          msg.setAttribute('role', 'alert');
          msg.textContent = 'Please enter your name and a 10-digit phone number (or a valid email).';
          form.querySelector('.qf-sub').after(msg);
        }
        return;
      }
      var btn = form.querySelector('button[type=submit]');
      btn.disabled = true;
      btn.textContent = 'Sending…';
    });
  });

  // Track phone clicks in GA if present
  document.querySelectorAll('a[href^="tel:"]').forEach(function (a) {
    a.addEventListener('click', function () {
      if (typeof window.gtag === 'function') window.gtag('event', 'phone_call', { link_url: a.href });
    });
  });
})();

/* Static preview: forms need the PHP host, so show a notice instead of submitting. */
document.querySelectorAll('.quote-form').forEach(function (f) {
  f.addEventListener('submit', function (e) {
    if (e.defaultPrevented) return;
    e.preventDefault();
    var b = f.querySelector('button[type=submit]');
    b.disabled = false; b.textContent = 'Send My Free Estimate Request';
    alert('Preview site: the estimate form goes live once the site is on the PHP host. For now, please call the number above.');
  });
});
