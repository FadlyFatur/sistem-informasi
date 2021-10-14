@extends('layout.main')
@section('title','Data Aspirasi')
@section('halaman','Data Apirasi Masyarakat')

@section('content')
<div class="card user-card-full p-3">
@if ($message = Session::get('sukses'))
<div class="alert alert-success alert-dismissible show fade">
  <div class="alert-body">
    <button class="close" data-dismiss="alert">
      <span>×</span>
    </button>
    {{ Session::get('sukses') }}
  </div>
</div>
@endif

@if ($message = Session::get('gagal'))
<div class="alert alert-danger alert-dismissible show fade">
  <div class="alert-body">
    <button class="close" data-dismiss="alert">
      <span>×</span>
    </button>
    {{ Session::get('gagal') }}
  </div>
</div>
@endif

  <div class="card-header">
      <h4>Data User</h4>
    </div>

    <div class="table-responsive" style="color:black;">
      <p class="text-center" >Total Aspirasi : <span id="total-record">{{ $count }}</span></p>

      <table class="table table-sm" id="asptbl">
        <thead>
          <tr>
            <th class="text-center">Pengirim</th>
            <th class="text-center">Aspirai</th>
            <th class="text-center">Tanggal dibuat</th>
            <th class="text-center">Aksi</th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>

    </div>
</div>
@endsection

@section('modal')
  <div class="modal fade text-body" id="aspirasi" tabindex="-1" role="dialog" aria-labelledby="aspirasi" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="aspirasi">Password Reset</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            {{-- konteks --}}
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="button" class="btn btn-primary">Reset</button>
        </div>
      </div>
    </div>
  </div>
@endsection


@section('js')
  <script>

  $('#asptbl').DataTable({
    processing: true,
    serverSide: true,
    ajax: '{{ route("getAspirasi") }}',
    columns: [
        {data: 'pengirim', name: 'pengirim'},
        {data: 'aspirasi', name: 'aspirasi', orderable: false, searchable: false},
        {data: 'created_at', name: 'tanggal', searchable: false},
        {data: 'action', name: 'action', orderable: false, searchable: false}
    ]
  });

  </script>
@endsection