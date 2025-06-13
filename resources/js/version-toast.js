(function(){
  const config = @json(config('version-toast'));
  const current = window.CURRENT_APP_VERSION;
  const toastEl = document.getElementById('versionToast');
  const toastVersionEl = document.getElementById('toastVersion');
  const refreshBtn = document.getElementById('toastRefreshBtn');
  const dismissBtn = document.getElementById('toastDismissBtn');

  // Initialize Bootstrap toast
  const bsToast = new bootstrap.Toast(toastEl);

  refreshBtn.addEventListener('click', () => window.location.reload(true));
  dismissBtn.addEventListener('click', () => bsToast.hide());

  function checkVersion() {
    fetch('/' + config['version_file'] + '?_=' + Date.now())
      .then(r => r.json())
      .then(j => {
        const latest = `${j.tag}.${j.commit}`;
        if (latest !== current && !toastEl.classList.contains('show')) {
          toastVersionEl.textContent = latest;
          bsToast.show();
        }
      }).catch(console.error);
  }

  // First check on load, then at configured interval
  checkVersion();
  setInterval(checkVersion, config['poll_interval'] * 1000);
})();