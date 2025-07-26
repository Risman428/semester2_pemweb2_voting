@extends('layouts.mantis')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Form Edit Data Kandidat</h4>
                <div>
                    <a href="{{ route('kandidat.index') }}" class="btn btn-sm btn-secondary">Kembali</a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('kandidat.update', $kandidats->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group my-2">
                        <label for="nama">Nama</label>
                        <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror"
                            value="{{ old('nama', $kandidats->nama) }}">
                        @error('nama')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group my-2">
                        <label for="nim">NIM</label>
                        <input type="text" name="nim" id="nim" class="form-control @error('nim') is-invalid @enderror"
                            value="{{ old('nim', $kandidats->nim) }}">
                        @error('nim')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group my-2">
                        <label for="visi">Visi</label>
                        <textarea name="visi" id="visi" class="form-control @error('visi') is-invalid @enderror" rows="3">{{ old('visi', $kandidats->visi) }}</textarea>
                        @error('visi')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group my-2">
                        <label for="misi">Misi</label>
                        <textarea name="misi" id="misi" class="form-control @error('misi') is-invalid @enderror" rows="5">{{ old('misi', $kandidats->misi) }}</textarea>
                        @error('misi')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group my-2">
                        <label for="foto">Foto Kandidat</label>
                        <input type="file" name="foto" id="foto"
                            class="form-control @error('foto') is-invalid @enderror">
                        @error('foto')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror

                        @if ($kandidats->foto)
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $kandidats->foto) }}" alt="Foto Kandidat" width="120" class="img-thumbnail">
                            </div>
                        @endif
                    </div>

                    <div class="my-2 d-flex justify-content-end">
                        <button class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
