// Logs the user out after a period of inactivity. Warns first, and lets them stay signed in.
(function () {
  var timeoutMeta = document.querySelector('meta[name="session-idle-timeout"]');
  var roleMeta = document.querySelector('meta[name="session-role"]');
  if (!timeoutMeta || !roleMeta) return;

  var idleMs = parseInt(timeoutMeta.content, 10) * 1000;
  var warnMs = Math.min(60000, idleMs / 2); // warn this long before logging out
  var role = roleMeta.content;
  var lastPing = Date.now();
  var warnTimer, logoutTimer, countdownTimer;

  var modalEl = document.createElement('div');
  modalEl.className = 'modal fade';
  modalEl.tabIndex = -1;
  modalEl.setAttribute('data-bs-backdrop', 'static');
  modalEl.innerHTML =
    '<div class="modal-dialog modal-dialog-centered"><div class="modal-content">' +
    '<div class="modal-header"><h5 class="modal-title">Still there?</h5></div>' +
    '<div class="modal-body">You have been inactive and will be logged out in <strong id="idleCountdown"></strong> seconds.</div>' +
    '<div class="modal-footer">' +
    '<button type="button" class="btn btn-secondary" id="idleLogout">Log out now</button>' +
    '<button type="button" class="btn btn-primary" id="idleStay">Stay signed in</button>' +
    '</div></div></div>';
  document.body.appendChild(modalEl);
  var modal = new bootstrap.Modal(modalEl);
  var countdownEl = modalEl.querySelector('#idleCountdown');

  function logout() {
    fetch('/' + role + '/logout', { method: 'POST', credentials: 'same-origin' })
      .finally(function () { window.location.href = '/login'; });
  }

  function showWarning() {
    var deadline = Date.now() + warnMs;
    countdownEl.textContent = Math.ceil(warnMs / 1000);
    countdownTimer = setInterval(function () {
      countdownEl.textContent = Math.max(0, Math.ceil((deadline - Date.now()) / 1000));
    }, 1000);
    modal.show();
  }

  function schedule() {
    clearTimeout(warnTimer);
    clearTimeout(logoutTimer);
    clearInterval(countdownTimer);
    warnTimer = setTimeout(showWarning, idleMs - warnMs);
    logoutTimer = setTimeout(logout, idleMs);
  }

  // Tell the server the user is active, at most once a minute, so its own idle timer agrees with ours.
  function ping() {
    if (Date.now() - lastPing < 60000) return;
    lastPing = Date.now();
    fetch('/session/ping', { credentials: 'same-origin' });
  }

  function activity() {
    if (modalEl.classList.contains('show')) return; // while warned, only the buttons count
    schedule();
    ping();
  }

  ['mousemove', 'keydown', 'click', 'scroll', 'touchstart'].forEach(function (evt) {
    document.addEventListener(evt, activity, { passive: true });
  });

  modalEl.querySelector('#idleStay').addEventListener('click', function () {
    modal.hide();
    lastPing = 0;
    schedule();
    ping();
  });
  modalEl.querySelector('#idleLogout').addEventListener('click', logout);

  schedule();
})();
