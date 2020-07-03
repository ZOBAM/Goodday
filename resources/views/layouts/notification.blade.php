
        <div role="alert" aria-live="assertive" aria-atomic="true" class="toast" data-autohide="false">
            <div class="toast-header">
              <img src="{{asset('/images/gdaylogo.png')}}" class="rounded mr-2" alt="..." width="65px">
              <strong class="mr-auto">Good Day</strong>
              <small>Saved!</small>
              <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="toast-body">
              {{Session::get('info')}}.
            </div>
          </div>
        <script>
            $('.toast').toast('show')
        </script>
