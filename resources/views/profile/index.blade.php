@extends('layouts.mantis')

@section('content')
<div class="container py-4">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title">Data Profile</h4>
        </div>
        <div class="card-body">
            @php
                $user = Auth::user();
                $profilLengkap = $user->nim && $user->kelas && $user->jurusan && $user->voting;
            @endphp

            @if(!$profilLengkap)
                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group my-2">
                        <label for="nim">NIM</label>
                        <input type="text" name="nim" id="nim" class="form-control @error('nim') is-invalid @enderror" value="{{ old('nim', $user->nim) }}">
                        @error('nim')
                            <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>

                    <div class="form-group my-2">
                        <label for="kelas">Kelas</label>
                        <select name="kelas" id="kelas" class="form-control @error('kelas') is-invalid @enderror">
                            <option value="">-- Pilih Kelas --</option>
                            @for($year = 2023; $year <= 2025; $year++)
                                @foreach(['A','B','C'] as $huruf)
                                    <option value="{{ $huruf . ' - ' . $year }}"
                                        {{ old('kelas', $user->kelas) == $huruf . ' - ' . $year ? 'selected' : '' }}>
                                        {{ $huruf . ' - ' . $year }}
                                    </option>
                                @endforeach
                            @endfor
                        </select>
                        @error('kelas')
                            <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>

                    <div class="form-group my-2">
                        <label for="jurusan">Jurusan</label>
                        <select name="jurusan" id="jurusan" class="form-control @error('jurusan') is-invalid @enderror">
                            <option value="">-- Pilih Jurusan --</option>
                            @foreach(['Teknik Informatika', 'Manajemen Informatika', 'Komputerisasi Akuntansi'] as $jurusan)
                                <option value="{{ $jurusan }}"
                                    {{ old('jurusan', $user->jurusan) == $jurusan ? 'selected' : '' }}>
                                    {{ $jurusan }}
                                </option>
                            @endforeach
                        </select>
                        @error('jurusan')
                            <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>

                    <div class="my-2 d-flex justify-content-end">
                        <button class="btn btn-success">Simpan Profile</button>
                    </div>
                </form>
            @else
                {{-- Tampilkan data jika sudah lengkap --}}
                <table class="table table-bordered table-striped">
                    <tr>
                        <th>Nama</th>
                        <td>{{ $user->name }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $user->email }}</td>
                    </tr>
                    <tr>
                        <th>NIM</th>
                        <td>{{ $user->nim }}</td>
                    </tr>
                    <tr>
                        <th>Kelas</th>
                        <td>{{ $user->kelas }}</td>
                    </tr>
                    <tr>
                        <th>Jurusan</th>
                        <td>{{ $user->jurusan }}</td>
                    </tr>
                </table>
            @endif

        </div>
    </div>
</div>
@endsection
