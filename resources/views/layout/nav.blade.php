<nav class="navbar navbar-expand-lg main-navbar">

  <form class="form-inline mr-auto">
    <ul class="navbar-nav mr-3">
      <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
      <!-- <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li> -->
      <li><h3>Sistem Informasi Kependudukan</h3></li>
    </ul>
  </form>

  <ul class="navbar-nav navbar-right">
     <!-- Authentication Links -->
     @guest
        <li class="nav-item">
            <!-- <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a> -->
            <a href="{{ route('login') }}" class="btn btn-icon icon-left btn-primary mr-1"><i class="fas fa-sign-in-alt"></i>{{ __('Masuk') }}</a>
        </li>
        @if (Route::has('register'))
            <li class="nav-item">
                <a href="{{ route('register') }}" class="btn btn-icon icon-left btn-primary ml-1"><i class="fas fa-user-plus"></i>{{ __('Daftar') }}</a>
                <!-- <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a> -->
            </li>
        @endif
        <!-- jika sudah login  -->
     @else
        <li class="nav-item dropdown">
            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
            <div class="d-sm-none d-lg-inline-block">
              <h6>Halo, {{ Auth::user()->username }}</h6>
            </div>
            </a>

            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
            <p class="dropdown-item" href="">{{ Auth::user()->username }}</p>
            <hr>
            <a href="{{ route('profil') }}" class="dropdown-item has-icon">
                <i class="far fa-user"></i> Profile
              </a>
            <a href="{{ route('logout') }}" class="dropdown-item has-icon text-danger"
                onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i> Logout
              </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </li>
    @endguest
  </ul>
        
</nav>