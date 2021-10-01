@if (count($cariwarga)  > 0)
  @foreach($cariwarga as $c)
    <tr>
      <td>{{ $c->nama }}</td>
      <td>{{ $c->jk }}</td>
      <td>{{ $c->tempat_lahir }}, {{$c->tanggal_lahir}}</td>
      <td>{{ $c->rt }} / {{ $c->rw }}</td>
      <td>{{ $c->alamat }}, {{ $c->kel }}, {{ $c->kec }}, {{ $c->kota }}</td>
    </tr>
  @endforeach
@else
  <tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
@endif