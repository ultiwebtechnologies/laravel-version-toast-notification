{{-- Bootstrap 4 toast --}}
<div class="toast-container position-fixed" style="top:50%; right:1rem; transform:translateY(-50%); z-index:1060;">
  <div id="versionToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-autohide="false">
    <div class="toast-header">
      <strong class="mr-auto">New Version Available</strong>
      <small class="text-muted">just now</small>
      <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="toast-body">
      Version <span id="toastVersion"></span> is live.
      <div class="mt-2 pt-2 border-top">
        <button id="toastRefreshBtn" type="button" class="btn btn-sm btn-primary">Refresh Now</button>
        <button id="toastDismissBtn" type="button" class="btn btn-sm btn-link" data-dismiss="toast">Later</button>
      </div>
    </div>
  </div>
</div>