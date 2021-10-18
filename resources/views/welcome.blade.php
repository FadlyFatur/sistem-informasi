@extends('layout.main')
@section('title','Beranda')
{{-- @section('halaman','Beranda') --}}
@section('css')
<link rel="stylesheet" href="{{asset('css/welcome.css')}}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/css/splide.min.css">
@endsection

@section('content')
<!-- //welcome -->

<!-- image slider -->
<div class="container-fluid jumbo">
  @if ($beranda->foto_thumb != null )
  <div class="jumbotron" style="background-image: url('{{ Storage::url($beranda->foto_thumb) }}')">
      
  @else
  <div class="jumbotron" style="background-image: url('img/homepage-thumb.jpg')">
      
  @endif
  <div class="container teks">
      <h1 class="display-4  align-text-bottom">Sistem Informasi Kependudukan</h1>
      <h2 class="align-text-bottom">{{ $beranda->nama_intansi }}</h2>
      <p class="lead align-text-bottom"></p>
    </div>
  </div>
</div>
<hr>

<!-- counter -->
<div class="container-fluid">
  <h2 class="section-title">Data</h2>

  <div class="row d-flex justify-content-center">
      
    <div class="col-md-4 col-sm-12">
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

    <div class="col-md-4 col-sm-12">
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

    <div class="col-md-4 col-sm-12">
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

@if(isset($beranda->visi) || isset($beranda->misi))
<!-- visi dan misi  -->
<div class="container-fluid">
  <div class="d-flex justify-content-between">
    <h2 class="section-title">Visi dan Misi</h2>
  </div>
  <div class="row text-center">
    <div class="col-md-6 col-sm-12 p-2" id="visi">
      <h3>Visi</h3>
      <p>{!! $beranda->visi !!}</p>
    </div>

    <div class="col-md-6 col-sm-12 p-2" id="misi">
      <h3>Misi</h3>
      <p>{!! $beranda->misi !!}</p>
    </div>
  </div>
</div>
<hr>
@endif

<!-- acara section -->
<div class="container-fluid">
  <div class="d-flex justify-content-between">
      <a href="{{ route('list-kegiatan') }}"><h2 class="section-title">Acara/Kegiatan Masyarakat <i class="fas fa-chevron-right"></i></h2></a>
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

  <div class="splide">
    <div class="splide__track">
      <div class="splide__list">
        @foreach($data as $r)
          <div class="splide__slide">
            <article class="article article-style-c">
              <div class="article-header">
                <div class="article-image" data-background="{{$r['url']}}"style="background-image: url(&quot;assets/img/news/img03.jpg&quot;);">
                </div>
              </div>
              <div class="article-details">
                <div class="article-category"><a href="#">Acara/Kegiatan</a> <div class="bullet"></div> <a href="#">{{ date('m/d/Y',strtotime($r['created_at'])) }}</a></div>
                <div class="article-title">
                  <h5 class="mb-4">{{$r['judul']}}</h5>
                </div>
                <div class="article-cta">
                  <a href="{{route('show-kegiatan',['slug' => $r->slug])}}">Baca Selengkapnya <i class="fas fa-chevron-right"></i></a>
                </div>
              </div>
            </article>
          </div>
        @endforeach
      </div>
    </div>
  </div>  
  @endif
</div>
<hr>

<!-- staff -->  
<div class="container-fluid">
  <div class="d-flex justify-content-between">
      <a href="{{ route('list-Staff') }}"><h2 class="section-title">Staf/Pengurus<i class="fas fa-chevron-right"></i></h2></a>
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
        <div class="user-item">
          @if (isset($s->foto))
            <img src="{{Storage::url($s['url'])}}" alt="staff-foto">
          @else
            <div class="company-header-avatar" style="background-image: url(&quot;assets/img/avatar/avatar-5.png&quot;)">
            </div>
          @endif
          <div class="user-details mt-3 text-center">
            <h5 class="user-name">{{$s['nama']}}</h5>
            <div class="text-job text-muted">{{ $s->jabatan['nama']}}</div>
          </div>  
        </div>
      </div>
    @endforeach
  </div>
  @endif
</div>
<hr>

<!-- Berita section -->
<div class="container-fluid">
  <div class="d-flex justify-content-between">
      <a href="#berita"><h2 class="section-title">Berita Terbaru <i class="fas fa-chevron-right"></i></h2></a>
  </div>

  @if ($berita == '404')
    <div class="row d-flex justify-content-center">
      <div class="col">
        <div class="alert alert-danger text-center">
          <div class="alert-title">Belum ada berita/offline.</div>
        </div>
      </div>
    </div>
  @else

  <div class="splide">
    <div class="splide__track">
      <div class="splide__list">
        @foreach($berita as $b)
          <div class="splide__slide">
            <article class="article article-style-c">
              <div class="article-header">
                <div class="article-image" data-background="{{$b['img']}}" style="background-image: url(&quot;assets/img/news/img13.jpg&quot;);">
                </div>
              </div>
              <div class="article-details">
                <div class="article-category"><a href="#">Berita</a> <div class="bullet"></div> <a href="#">{{ date('m/d/Y',strtotime($b['date'])) }}</a></div>
                <div class="article-title">
                  <h5 class="mb-4">{{$b['judul']}}</h5>
                </div>
                <div class="article-cta">
                  <a target="_blank" href="{{ $b['url'] }}">Baca Selengkapnya <i class="fas fa-chevron-right"></i></a>
                </div>
              </div>
            </article>
          </div>
        @endforeach
      </div>
    </div>
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
    <div class="col-lg-3 col-md-6 col-sm-6 mb-5">
        <div class="hero bg-primary text-white">
          <i class="fas fa-phone-square"></i>
          <div class="hero-inner">
          <hr class="hr-4">
            <h2>Kontak</h2>
            <p class="lead">{{$beranda['kontak']}}</p>
          </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-5">
        <div class="hero bg-primary text-white">
        <i class="fas fa-at"></i>
        <div class="hero-inner">
          <hr class="hr-4">
            <h2>Email</h2>
            <p class="lead">{{$beranda['email']}}</p>
          </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-5">
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
  @endif
</div>
  
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/js/splide.min.js"></script>
<script>
  document.querySelectorAll('.splide').forEach(carousel => new Splide( carousel, {
    perPage: 3,
    rewind : true,
    perMove: 1,
    autoplay: true,
    breakpoints: {
      '640': {
        perPage: 2,
        gap    : '1rem',
      },
      '480': {
        perPage: 1,
        gap    : '1rem',
      },
    }
  }).mount());


	// new Splide( '.splide', {
  //   perPage: 3,
  //   rewind : true,
  //   perMove: 1,
  //   autoplay: true,
  //   breakpoints: {
  //     '640': {
  //       perPage: 2,
  //       gap    : '1rem',
  //     },
  //     '480': {
  //       perPage: 1,
  //       gap    : '1rem',
  //     },
  //   }
  // }).mount();

</script>
@endsection