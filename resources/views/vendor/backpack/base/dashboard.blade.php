@extends(backpack_view('blank'))

@section('content')
<div class="card">
  <div class="card-header">
    Karyawan Teladan
  </div>
  <div class="card-body">
<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Nama</th>
      <th scope="col">Tahun</th>
      <th scope="col">Nilai Total</th>
      <th scope="col">Akhir</th>
      <th scope="col">Kriteria</th>
      <th scope="col">Verifikasi</th>
    </tr>
  </thead>
  <tbody>
    @if ($penilaians)
    @foreach ($penilaians as $penilaian)
      <tr>
      <th scope="row">{{ $loop->iteration }}</th>
      <td> {{ $penilaian->karyawan }} </td>
      <td> {{ $penilaian->tahun }} </td>
      <td> {{ $penilaian->total }} </td>
      <td>{{ $penilaian->akhir }}</td>
      <td> 
       @php

        if ($penilaian->akhir >= 4.1){
            echo 'SANGAT BAIK';
        } elseif ($penilaian->akhir >= 3.1 && $penilaian->akhir <= 4){
            echo 'BAIK';
        } elseif ($penilaian->akhir >= 2.1 && $penilaian->akhir <= 3){
            echo 'CUKUP';
        } elseif ($penilaian->akhir >= 1.1 && $penilaian->akhir <= 2){
            echo 'KURANG';
        } else {
            echo 'TIDAK BAIK';
        }

    @endphp
       </td>
       <td>
            Terverifikasi
       </td>
    </tr>
    @endforeach
    @endif
  </tbody>
</table>
  </div>
</div>
@endsection