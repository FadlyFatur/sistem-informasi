<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{config('app.name')}} - @yield('title')</title>
  <link href="{{ asset('css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{ asset('fontawesome-free-5.15.1-web\css\all.css')}}" rel="stylesheet">

  <!-- CSS Libraries -->
  <!-- Template CSS -->
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">
  <link rel="stylesheet" href="{{asset('dist/css/chocolat.css')}}" type="text/css" media="screen" >
  <link rel="stylesheet" href="{{asset('dropzone/min/dropzone.min.css')}}" type="text/css" media="screen" >
  <link rel="stylesheet" href="{{asset('jquery.dataTables.min.css')}}" type="text/css" media="screen" >
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  @yield('css')
  
  <style>
  /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
      -webkit-appearance: none;
      margin: 0;
    }

    /* Firefox */
    input[type=number] {
      -moz-appearance: textfield;
    }
  </style>

</head>

<body oncopy="return false" oncut="return false" onpaste="return false">
  @yield('modal')
  <div id="app">
    <div class="main-wrapper">
      <div class="navbar-bg"></div>
      @include('layout.nav')
      @include('layout.sidebar')
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>@yield('halaman')</h1>
          </div>
          <div class="section-body">
            <main>
              @yield('content')
            </main>
          </div>
        </section>
      </div>
      
      <footer class="main-footer">
        <div class="footer-left">
          Copyright &copy; 2020  |  Created By <a target="_blank" href="https://www.itenas.ac.id/">Informatika Itenas</a>   |  Template By <a target="_blank" href="https://getstisla.com/getting-started">STISLA</a> 
        </div>
        <div class="footer-right">
          
        </div>
      </footer>
    </div>
  </div>
 
  <script src="{{asset('jquery-3.3.1.min.js')}}"></script>
  <script src="{{asset('popper.min.js')}}"></script>
  <script src="{{asset('js/bootstrap.min.js')}}"></script>
  <script src="{{asset('jquery.nicescroll.min.js')}}"></script>
  <script src="{{asset('moment.min.js')}}"></script>
  <!-- JS Libraies -->
  <script src="{{asset('assets/js/stisla.js')}}"></script>
  <!-- Template JS File -->
  <script src="{{asset('assets/js/scripts.js')}}"></script>
  <script src="{{asset('assets/js/custom.js')}}"></script>
  <script src="{{ asset('dist/js/chocolat.js') }}"></script>
  <script src="{{ asset('dropzone/min/dropzone.min.js') }}"></script>
  <script src="{{ asset('jquery.dataTables.min.js') }}"></script>
  <!-- Page Specific JS File -->
  @yield('js')
  <script> 
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
  </script>
 
</body>
</html>
