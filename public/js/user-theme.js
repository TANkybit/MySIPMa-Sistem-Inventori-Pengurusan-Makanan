(function () {
  var toggle = document.getElementById('themeToggle');
  document.querySelectorAll('.logout-icon-only').forEach(function (button) {
    button.setAttribute('title', 'Log Keluar');
    button.setAttribute('aria-label', 'Log Keluar');
  });
  if (!toggle) return;

  function applyTheme(theme) {
    document.documentElement.setAttribute('data-bs-theme', theme);
    var icon = toggle.querySelector('i');
    if (icon) icon.className = theme === 'dark' ? 'bi bi-moon-fill' : 'bi bi-sun-fill';
    localStorage.setItem('theme', theme);
  }

  var saved = localStorage.getItem('theme') || 'light';
  applyTheme(saved);

  toggle.addEventListener('click', function () {
    var cur = document.documentElement.getAttribute('data-bs-theme') || 'light';
    applyTheme(cur === 'dark' ? 'light' : 'dark');
    location.reload();
  });
})();
