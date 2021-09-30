@extends('layout.main')
@section('title','Galeri')
@section('halaman','Galeri')
@section('css')
<link rel="stylesheet" href="{{ URL::asset('css/galeri.css') }}">
@endsection

@section('content')
<div class="card">
    <div id="container2" style="background-image: url(&quot;assets/img/news/img03.jpg&quot;);"></div>
    <div class="card-body" id="uploaded-image">
        <p>Klik foto yang ingin dilihat</p>
        <div class="gallery gallery-md text-center">
            @foreach ($images as $i)
            <div class="gallery-item" data-image="{{asset('images/' . $i->getFilename())}}" data-title="Image 1" href="{{asset('images/' . $i->getFilename())}}" style="background-image: url(&quot;assets/img/news/img03.jpg&quot;); height:100px; width:100px;"></div>
            @endforeach
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    Chocolat(document.querySelectorAll('.gallery-item'), {
            container: document.querySelector('#container2'),
            imageSize: 'cover',
        });
</script>
@endsection