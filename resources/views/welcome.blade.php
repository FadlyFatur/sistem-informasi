@extends('layout.main')
@section('title','Beranda')
@section('halaman','Beranda')
@section('css')
<link rel="stylesheet" href="{{asset('css/welcome.css')}}">
@endsection

@section('content')
<!-- //welcome -->

<!-- image slider -->
<div class="container-fluid jumbo">
  <div class="jumbotron" style="background-image: url(&quot;img/Register-photo.jpg&quot;) ">
  <div class="container teks">
      <h1 class="display-4  align-text-bottom">Sistem Informasi Kependudukan RW 02</h1>
      <p class="lead align-text-bottom"></p>
    </div>
  </div>
</div>
<hr>

<!-- counter -->
<div class="container-fluid">
  <h2 class="section-title">Data</h2>

  <div class="row d-flex justify-content-center">
      
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
      <div class="card card-statistic-1">
        <div class="card-icon bg-primary">
          <i class="fas fa-users"></i>
        </div>
        <div class="card-wrap">
          <div class="card-header">
            <h4>Total Warga</h4>
          </div>
          <div class="card-body">
            <h2>{{ $jmlwarga }}</h2>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
      <div class="card card-statistic-1">
        <div class="card-icon bg-danger">
        <i class="fas fa-user-tie"></i>
        </div>
        <div class="card-wrap">
          <div class="card-header">
            <h4>Total Staff</h4>
          </div>
          <div class="card-body">
            <h2>{{ $jmlstaff }}</h2>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
      <div class="card card-statistic-1">
        <div class="card-icon bg-warning">
        <i class="far fa-calendar-check"></i>
        </div>
        <div class="card-wrap">
          <div class="card-header">
            <h4>Total Acara</h4>
          </div>
          <div class="card-body">
            <h2>{{ $jmlacara }}</h2>
          </div>
        </div>
      </div>
    </div>
  </div>


</div>
<hr>  

<!-- visi dan misi  -->
<div class="container-fluid">
  <div class="d-flex justify-content-between">
    <h2 class="section-title">Visi dan Misi</h2>
  </div>
  @if(isset($beranda->visi) || isset($beranda->misi))
  <div class="row text-center">
    <div class="col p-2" id="visi">
    <h3>Visi</h3>
    <p>{!! $beranda->visi !!}</p>
    </div>
    <div class="col p-2" id="misi">
    <h3>Misi</h3>
    <p>{!! $beranda->misi !!}</p>
    </div>
  </div>
  @else
  <div class="row text-center">
    <div class="col p-2" id="visi">
    <h3>Visi</h3>
    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Minima magni a cupiditate modi repudiandae exercitationem odit quos, facilis omnis, quisquam dicta aut? Qui ducimus ut dicta repudiandae, illo minus laudantium?</p>
    </div>
    <div class="col p-2" id="misi">
    <h3>Misi</h3>
    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Qui laudantium suscipit magni inventore aliquam molestias, nisi, earum et ea at cupiditate deleniti. Obcaecati, quod! Accusamus vitae eligendi quae minus ab.</p>
    </div>
  </div>
  @endif
</div>
<hr>

<!-- news section -->
<div class="container-fluid">
  <div class="d-flex justify-content-between">
      <a href="{{ route('Acara') }}"><h2 class="section-title">Acara/Kegiatan Masyarakat <i class="fas fa-chevron-right"></i></h2></a>
  </div>
  @if ($data->count() == 0)
    <div class="row d-flex justify-content-center">
      <div class="col">
        <div class="alert alert-danger text-center">
          <div class="alert-title">Belum ada acara/kegiatan.</div>
        </div>
      </div>
    </div>
  @else
  <div class="row">
    @foreach($data as $r)
      <div class="col-12 col-md-4 col-lg-4">
        <article class="article article-style-c">
          <div class="article-header">
            <div class="article-image" data-background="{{$r['url']}}" style="background-image: url(&quot;assets/img/news/img13.jpg&quot;);">
            </div>
          </div>
          <div class="article-details">
            <div class="article-category"><a href="#">Acara/Kegiatan</a> <div class="bullet"></div> <a href="#">{{ date('m/d/Y',strtotime($r['created_at'])) }}</a></div>
            <div class="article-title">
              <h5 class="mb-4">{{$r['judul']}}</h5>
            </div>
            <div class="article-cta">
              <a href="{{route('showAcara',['slug' => $r->slug])}}">Baca Selengkapnya <i class="fas fa-chevron-right"></i></a>
            </div>
          </div>
        </article>
      </div>
    @endforeach
  </div>  
  @endif
</div>
<hr>

<!-- staff -->  
<div class="container-fluid">
  <div class="d-flex justify-content-between">
      <a href="{{ route('lihatStaff') }}"><h2 class="section-title">Staf/Pengurus RW <i class="fas fa-chevron-right"></i></h2></a>
  </div>
  @if ($staff->count() == 0)
  <div class="row d-flex justify-content-center">
    <div class="col">
      <div class="alert alert-danger text-center">
        <div class="alert-title">Belum ada data staff.</div>
      </div>
    </div>
  </div>
  @else

  <div class="row pb-2">
    @foreach ($staff as $s)
      <div class="col-md-3 col-sm-6 p-5">
        <div class="user-item text-center">
          @if (isset($s->foto))
          <div class="company-header-avatar" style="background-image: url({{Storage::url($s['url'])}})"></div>
          @else
          <div class="company-header-avatar" style="background-image: url(&quot;assets/img/avatar/avatar-5.png&quot;)">
          </div>
          @endif
          <!-- <img alt="image" src="{{Storage::url($s['url'])}}" class="img-fluid"> -->
          <div class="user-details mt-3">
            <h5 class="user-name">{{$s['nama']}}</h5>
            <div class="text-job text-muted">{{ $s->jabatan->njabatan }}</div>
          </div>  
        </div>
      </div>
    @endforeach
  </div>
  @endif
</div>
<hr>

<!-- informasi kontak -->
<div class="container-fluid">
  <h2 class="section-title">Kontak</h2>

  @if ($jmlberanda == 0)
    <div class="row d-flex justify-content-center">
      <div class="col">
        <div class="alert alert-danger text-center">
          <div class="alert-title">Belum ada data kontak.</div>
        </div>
      </div>
    </div>
  @else
  <div class="row d-flex justify-content-center text-center">
    <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-5">
      <div class="col-12">
        <div class="hero bg-primary text-white">
          <i class="fas fa-phone-square"></i>
          <div class="hero-inner">
          <hr class="hr-4">
            <h2>Kontak</h2>
            <p class="lead">{{$beranda['kontak']}}</p>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-5">
      <div class="col-12">
        <div class="hero bg-primary text-white">
        <i class="fas fa-at"></i>
        <div class="hero-inner">
          <hr class="hr-4">
            <h2>Email</h2>
            <p class="lead">{{$beranda['email']}}</p>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-5">
      <div class="col-12">
        <div class="hero bg-primary text-white">
          <i class="fas fa-map-marked-alt" style="margin-bottom:0px;"></i>
          <div class="hero-inner">
          <hr class="hr-4">
            <h2>Alamat</h2>
            <p class="lead p-alamat">{{$beranda['alamat']}}</p>
          </div>
        </div>
      </div>
    </div>

  </div>
  @endif
</div>
  
@endsection