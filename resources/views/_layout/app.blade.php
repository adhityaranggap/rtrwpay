<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', '') | {{ $appName }}</title>
  <!-- CSS -->
  <link rel="stylesheet" type="text/css" href="{{asset('assets/vendors/jqueryui/css/jquery-ui.min.css')}}">
  
  <!-- Script -->
  <script src="{{asset('assets/vendors/jquery/js/jquery-3.3.1.min.js')}}" type="text/javascript"></script>
  <script src="{{asset('assets/vendors/jqueryui/js/jquery-ui.min.js')}}" type="text/javascript"></script>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" >
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}" >

  <!-- Template CSS -->
  <link rel="stylesheet" href="{{ asset('assets/vendors/stisla/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendors/stisla/css/components.css') }}">  
    
  @stack('css')
</head>

<body>
  @include('_layout.modal')
  <div id="app">
    <div class="main-wrapper">
      <!-- <div class="navbar-nav bg-gradient-info sidebar sidebar-dark accordion"></div> -->
      <div class="navbar-bg"></div>
      @include('_layout.navbar')


      <!-- Sidebar -->
    @include('_layout.sidebar')

      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>@yield('page_header', '')</h1>
          </div>

          <div class="section-body">
            @yield('content')
          </div>
        </section>
      </div>

      <!-- Footer -->
      @include('_layout.footer')
      </footer>
    </div>
  </div>

  <!-- General JS Scripts -->
  
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>

  <script src="{{ asset('assets/vendors/stisla/js/stisla.js') }}"></script>

  <!-- JS Libraies -->

  <!-- Custome Modal Js -->
  <script src="{{ asset('js/modal.js') }}"></script>
  @stack('script')

  <script type="text/javascript" src="{{ asset('js/chat.js') }}"></script>

  <script id="intergram" type="text/javascript" src="https://www.intergram.xyz/js/widget.js"></script>


  <!-- CHoose -->
  <script src="{{ asset('assets/vendors/chosen/js/jquery.js') }}"></script>
  <script>
    $('select').chosen({ width:'100%' });
  </script>
  <!-- Select2 -->
  <script src="{{ asset('assets/js/select2.min.js') }}"></script>  
  
  <!-- Template JS File -->
  <script src="{{ asset('assets/vendors/stisla/js/scripts.js') }}"></script>
  <script src="{{ asset('assets/vendors/stisla/js/custom.js') }}"></script>

  <!-- Page Specific JS File -->
  @stack('js')
</body>
</html>
