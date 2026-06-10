(function () {
  'use strict';

  var SESSION_LIFETIME  = 15;        // minutes (default, can be overridden by meta tags)
  var WARNING_TIME      = 10;         // minutes before expiry to show warning
  var GRACE_PERIOD      = 120;        // seconds after warning before auto-logout
  var HEARTBEAT_URL     = '/session/heartbeat';
  var EXPIRE_URL        = '/session/expire';

  var IDLE_TIMEOUT      = (SESSION_LIFETIME - WARNING_TIME) * 60; // seconds
  var TICK_INTERVAL     = 1000; // 1 second

  var idleTimer   = null;
  var graceTimer  = null;
  var tickInterval = null;
  var modal       = null;
  var countdownEl  = null;

  var lastActivity = Date.now();

  // ── Inject the warning modal ──
  function injectModal() {
    var div = document.createElement('div');
    div.innerHTML =
      '<div class="modal fade" id="sessionTimeoutModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">' +
        '<div class="modal-dialog modal-dialog-centered">' +
          '<div class="modal-content" style="background:var(--surface,#11151f); border:1px solid var(--border,#2c333f);">' +
            '<div class="modal-body text-center p-4">' +
              '<div class="mb-3"><span style="font-size:3rem;">&#9203;</span></div>' +
              '<h5 class="fw-bold mb-2" style="color:var(--text,#e2e8f0);">Sesi Akan Tamat</h5>' +
              '<p class="mb-3" style="color:var(--muted,#94a3b8);">' +
                'Sesi anda akan tamat tidak lama lagi kerana tiada aktiviti.<br>' +
                'Sila klik butang di bawah untuk teruskan sesi.' +
              '</p>' +
              '<div class="mb-3">' +
                '<span id="sessCountdown" style="font-size:2rem; font-weight:700; color:#f59e0b;">' + GRACE_PERIOD + '</span>' +
                '<span style="color:var(--muted,#94a3b8);"> saat</span>' +
              '</div>' +
              '<button class="btn btn-lg px-5" id="sessContinueBtn" type="button" style="background:#10b981; color:#fff; border-radius:50px;">Teruskan Sesi</button>' +
            '</div>' +
          '</div>' +
        '</div>' +
      '</div>';
    document.body.appendChild(div.firstElementChild);
  }

  // ── Show / hide Bootstrap modal ──
  function showModal() {
    var el = document.getElementById('sessionTimeoutModal');
    if (!el) return;
    if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
      modal = new bootstrap.Modal(el, { backdrop: 'static', keyboard: false });
      modal.show();
    } else {
      el.classList.add('show');
      el.style.display = 'block';
    }
    countdownEl = document.getElementById('sessCountdown');
    if (countdownEl) countdownEl.textContent = GRACE_PERIOD;
    startGraceTimer();
  }

  function hideModal() {
    if (modal) {
      modal.hide();
      modal = null;
    }
    var el = document.getElementById('sessionTimeoutModal');
    if (el) {
      el.classList.remove('show');
      el.style.display = '';
    }
    stopGraceTimer();
  }

  // ── Grace period countdown ──
  function startGraceTimer() {
    stopGraceTimer();
    var remaining = GRACE_PERIOD;
    graceTimer = setInterval(function () {
      remaining--;
      if (countdownEl) countdownEl.textContent = remaining;
      if (remaining <= 0) {
        stopGraceTimer();
        expireSession();
      }
    }, 1000);
  }

  function stopGraceTimer() {
    if (graceTimer) {
      clearInterval(graceTimer);
      graceTimer = null;
    }
  }

  // ── Continue session ──
  function continueSession() {
    var btn = document.getElementById('sessContinueBtn');
    if (btn) {
      btn.disabled = true;
      btn.textContent = 'Menyambung...';
    }

    fetch(HEARTBEAT_URL, { credentials: 'same-origin' })
      .then(function (resp) {
        if (!resp.ok) throw new Error('Heartbeat failed');
        return resp.json();
      })
      .then(function () {
        hideModal();
        resetIdleTimer();
        if (btn) { btn.disabled = false; btn.textContent = 'Teruskan Sesi'; }
      })
      .catch(function () {
        // Session already expired — redirect to login
        window.location.href = EXPIRE_URL;
      });
  }

  // ── Expire session ──
  function expireSession() {
    stopAllTimers();
    window.location.href = EXPIRE_URL;
  }

  // ── Idle timer ──
  function startIdleTimer() {
    stopIdleTimer();
    idleTimer = setTimeout(function () {
      showModal();
    }, IDLE_TIMEOUT * 1000);
  }

  function stopIdleTimer() {
    if (idleTimer) {
      clearTimeout(idleTimer);
      idleTimer = null;
    }
  }

  function resetIdleTimer() {
    lastActivity = Date.now();
    stopIdleTimer();
    startIdleTimer();
  }

  function stopAllTimers() {
    stopIdleTimer();
    stopGraceTimer();
    if (tickInterval) {
      clearInterval(tickInterval);
      tickInterval = null;
    }
  }

  // ── Tick: optional visual feedback like updating a status indicator ──
  function tick() {
    // Could be used to update a navbar indicator in the future
  }

  // ── Activity events ──
  var activityEvents = ['mousedown', 'keydown', 'scroll', 'touchstart'];

  // Debounced mousemove handler
  var moveTimer = null;
  function onMouseMove() {
    if (moveTimer) return;
    moveTimer = setTimeout(function () {
      moveTimer = null;
      onUserActivity();
    }, 5000); // debounce mousemove to once per 5s
  }

  function onUserActivity() {
    var elapsed = (Date.now() - lastActivity) / 1000;
    if (elapsed > 5) {
      resetIdleTimer();
    }
  }

  // ── Init ──
  function init() {
    if (document.getElementById('sessionTimeoutModal')) return; // already injected

    // Read config from meta tags if present
    var lifetimeMeta = document.querySelector('meta[name="session-lifetime"]');
    if (lifetimeMeta) SESSION_LIFETIME = parseInt(lifetimeMeta.getAttribute('content'), 10) || SESSION_LIFETIME;

    var warningMeta = document.querySelector('meta[name="session-warning"]');
    if (warningMeta) WARNING_TIME = parseInt(warningMeta.getAttribute('content'), 10) || WARNING_TIME;

    var graceMeta = document.querySelector('meta[name="session-grace"]');
    if (graceMeta) GRACE_PERIOD = parseInt(graceMeta.getAttribute('content'), 10) || GRACE_PERIOD;

    // Recalculate idle timeout based on (possibly overridden) values
    IDLE_TIMEOUT = (SESSION_LIFETIME - WARNING_TIME) * 60;

    injectModal();

    // Wire up "Continue" button
    document.addEventListener('click', function (e) {
      if (e.target && e.target.id === 'sessContinueBtn') {
        continueSession();
      }
    });

    // Register activity events
    activityEvents.forEach(function (ev) {
      document.addEventListener(ev, onUserActivity);
    });
    document.addEventListener('mousemove', onMouseMove);

    // Start the idle timer
    startIdleTimer();

    // Optional tick
    tickInterval = setInterval(tick, TICK_INTERVAL);

    // If modal is already shown and user resumes activity, auto-hide it
    // (grace timer keeps running, user still needs to click Continue)
  }

  // Wait for DOM ready
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
