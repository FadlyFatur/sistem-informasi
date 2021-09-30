<div class="main-sidebar">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="#"> Sistem Informasi</a>
          </div>

          <ul class="sidebar-menu">
              <li class="active"><a class="nav-link" href="{{ route('beranda') }}"><i class="fas fa-home"></i> <span>Beranda</span></a></li>  
              <hr>
              <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-university"></i><span>Menu Utama</span></a>
                <ul class="dropdown-menu">
                  <li><a class="nav-link" href="{{ route('cariWarga') }}">Cek Warga</a></li>
                  <li><a class="nav-link" href="{{ route('Acara') }}">Acara/Kegiatan</a></li>
                  <li><a class="nav-link" href="{{ route('lihatStaff') }}">Staff</a></li>
                  <li><a class="nav-link" href="{{ route('galeri') }}">Galeri</a></li>
                </ul>
              </li>
              <hr>  
              <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-database"></i><span>Pengelolaan Data</span></a>
                <ul class="dropdown-menu">
                <li><a class="nav-link" href="{{ route('crudWarga') }}">Data Warga</a></li>
                  <li><a class="nav-link" href="{{ route('staff') }}">Data Staff</a></li>
                  <li><a class="nav-link" href="{{ route('editAcara') }}">Data Acara</a></li>
                  <li><a class="nav-link" href="{{ route('galeriAdmin') }}">Data Galeri</a></li>
                </ul>
              </li>
              <hr>
              @if (Auth::check())
                @if (Auth::user()->status == '2')
                <li class="nav-item dropdown">
                  <a href="#" class="nav-link has-dropdown"><i class="fas fa-th-large"></i> <span>Pengelolaan Website</span></a>
                 <ul class="dropdown-menu">
                  <li><a class="nav-link" href="{{ route('editBeranda') }}">Pengelolaan Beranda</a></li>
                  <li><a class="nav-link" href="{{ route('user') }}">Pengelolaan User</a></li>
                </ul>
               </li>
               <hr>
                @endif
              @endif
              @if (Auth::check())
              <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="far fa-address-card"></i> <span>Profil</span></a>
                <ul class="dropdown-menu">
                  <li><a class="nav-link" href="{{ route('profil') }}">Sunting Profil</a></li>
                </ul>
              </li>

            <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
              <a href="{{ route('logout') }}" class="btn btn-primary btn-lg btn-block btn-icon-split"
              onclick="event.preventDefault();
                  document.getElementById('logout-form').submit();">
              <i class="fas fa-sign-out-alt"></i></i>Logout/Keluar
              </a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
            @endif
        </aside>
      </div>