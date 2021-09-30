@extends('layout.main')
@section('title','Berita')
@section('halaman','Acara/Kegiatan RW 2')

@section('content')
  @if ($data->count() == 0)
    <div class="container-fluid p-5">
      <div class="alert alert-warning alert-has-icon">
        <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
        <div class="alert-body">
          <div class="alert-title">Perhatian</div>
          Belum ada data acara/kegiatan dimasukan.
        </div>
      </div>
    </div>
  @else

    <div class="row">
      @foreach($data as $d)
      <div class="col-12 col-md-4 col-lg-4">
        <article class="article article-style-c">
          <div class="article-header">
            <div class="article-image" data-background="{{$d['url']}}" style="background-image: url(&quot;assets/img/news/img01.jpg&quot;);">
            </div>
          </div>
          <div class="article-details">
            <div class="article-category"><a href="#">Acara/Kegiatan</a> <div class="bullet"></div> <a href="#">{{ date('m/d/Y',strtotime($d['created_at'])) }}</a></div>
            <div class="article-title">
              <h2><a href="{{route('showAcara',['slug' => $d->slug])}}">{{$d['judul']}}</a></h2>
            </div>
          </div>
        </article>
      </div>
      @endforeach
    </div>
    <div class="d-flex justify-content-center">
      {{ $data->links() }}
    </div>
  @endif
@endsection