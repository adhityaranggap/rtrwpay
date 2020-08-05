
<div class="flash-message">
    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
        @if(Session::has('alert-' . $msg))            
            <p class="alert alert-{{ $msg }} alert-dismissible show fade">{{ Session::get('alert-' . $msg) }}  
                <button class="close" data-dismiss="alert">
                    <span>×</span>
                </button>
            </p>
        @endif
    @endforeach
</div> 