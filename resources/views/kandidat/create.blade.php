@extends('layouts.mantis')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title">Form Tambah Kandidat</h4>
            <div>
                <a href="{{ route('kandidat.index') }}" class="btn btn-primary mb-3">Kembali</a>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('kandidat.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group my-2">
                    <label for="nama">Nama Kandidat</label>
                    <input type="text" name="nama" id="nama" 
                        class="form-control @error('nama') is-invalid @enderror" 
                        value="{{ old('nama') }}" autofocus>
                    @error('nama')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group my-2">
                    <label for="nim">NIM</label>
                    <input type="text" name="nim" id="nim" 
                        class="form-control @error('nim') is-invalid @enderror" 
                        value="{{ old('nim') }}">
                    @error('nim')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group my-2">
                    <label for="visi">Visi</label>
                    <textarea name="visi" id="visi" rows="3" 
                        class="form-control @error('visi') is-invalid @enderror">{{ old('visi') }}</textarea>
                    @error('visi')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group my-2">
                    <label for="misi">Misi</label>
                    <textarea name="misi" id="misi" rows="3" 
                        class="form-control @error('misi') is-invalid @enderror">{{ old('misi') }}</textarea>
                    @error('misi')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group my-2">
                    <label for="foto">Foto Kandidat</label>
                    <input type="file" name="foto" id="foto" 
                        class="form-control @error('foto') is-invalid @enderror" 
                        accept="image/*">
                    @error('foto')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="my-2 d-flex justify-content-end">
                    <button class="btn btn-primary">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
