@extends('layouts.mantis')

@section('content')
    <style>
        /* ... (keep all your existing styles) ... */
        /* Gaya untuk tabel admin */
        .action ul {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .edit, .delete {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 50px;
            height: 35px;
            border-radius: 4px;
            font-size: 16px;
            color: white;
        }

        .edit {
            background-color: rgb(194, 194, 49);
        }

        .delete {
            background-color: red;
            padding-top: 5px;
        }

        .delete button i {
            color: white;
        }

        #table th {
            text-align: center;
            vertical-align: middle;
        }

        #table td {
            text-align: left;
            vertical-align: middle;
        }

        #table td:nth-child(4),
        #table td:nth-child(5),
        #table td:nth-child(6),
        #table td:nth-child(7) {
            text-align: center;
        }

        /* Gaya untuk tampilan user */
        .kandidat-container {
            padding: 2rem 0;
        }
        
        .kandidat-title {
            font-weight: 700;
            margin-bottom: 2rem;
            color: #2c3e50;
            text-align: center;
        }
        
        .kandidat-card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            height: 100%;
        }
        
        .kandidat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }
        
        .kandidat-img-container {
            height: 280px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8f9fa;
            overflow: hidden;
            position: relative;
        }
        
        .kandidat-img {
            max-width: 100%;
            max-height: 100%;
            width: auto;
            height: auto;
            object-fit: contain;
            object-position: center;
            transition: transform 0.3s ease;
        }
        
        .kandidat-card:hover .kandidat-img {
            transform: scale(1.03);
        }
        
        .kandidat-body {
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            height: calc(100% - 280px);
        }
        
        .kandidat-name {
            font-weight: 700;
            font-size: 1.25rem;
            margin-bottom: 0.5rem;
            color: #2c3e50;
        }
        
        .kandidat-nim {
            color: #6c757d;
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }
        
        .kandidat-desc {
            color: #495057;
            margin-bottom: 1.5rem;
            flex-grow: 1;
        }
        
        .kandidat-votes {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
            color: #6c757d;
            font-size: 0.9rem;
        }
        
        .kandidat-votes i {
            margin-right: 0.5rem;
            color: #6C63FF;
        }
        
        .kandidat-actions {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .kandidat-actions .btn {
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
            font-weight: 500;
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        .kandidat-actions form {
            width: 100%;
        }
        
        .btn-detail {
            background-color: #6C63FF;
            color: white;
            border: none;
        }
        
        .btn-detail:hover {
            background-color: #5a52d6;
            color: white;
        }
        
        .btn-vote {
            background-color: #28a745;
            color: white;
            border: none;
            width: 100%;
        }

        .btn-vote:hover {
            background-color: #218838;
            color: white;
        }
        
        .btn-disabled {
            background-color: #6c757d;
            color: white;
            border: none;
            cursor: not-allowed;
        }

        /* Placeholder icon style */
        .img-placeholder {
            font-size: 5rem;
            color: #6C63FF;
            opacity: 0.7;
        }

        /* Add these new styles for better text spacing */
        .kandidat-desc {
            padding: 0 15px; /* Add horizontal padding */
        }
        
        .kandidat-desc p {
            margin-bottom: 0.8rem;
            text-align: justify;
            word-break: break-word;
        }
        
        .kandidat-desc strong {
            display: block;
            margin-bottom: 0.3rem;
        }

        /* Modal content spacing */
        .modal-paragraph {
            padding: 0 15px;
            text-align: justify;
            word-break: break-word;
        }
    </style>

    @if(Auth::check() && Auth::user()->role->role_name == 'admin')
        <!-- Tampilan Admin (tetap sama seperti sebelumnya) -->
        <div class="container">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Data Kandidat</h4>
                    <a href="{{ route('kandidat.create') }}" class="btn btn-primary">Tambah Data</a>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-sm table-bordered" id="table">
                        <thead style="background-color: #6C63FF;">
                            <tr class="field">
                                <th>No</th>
                                <th>Nama</th>
                                <th>NIM</th>
                                <th>Visi</th>
                                <th>Misi</th>
                                <th>Foto</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kandidat as $index => $item)
                                <tr>
                                    <td style="text-align: center">{{ $index + 1 }}</td>
                                    <td>{{ $item->nama }}</td>
                                    <td>{{ $item->nim }}</td>
                                    <td>
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#modalVisi{{ $item->id }}">
                                            Visi
                                        </button>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#modalMisi{{ $item->id }}">
                                            Misi
                                        </button>
                                    </td>
                                    <td>
                                        @if ($item && !empty($item->foto))
                                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#modalFoto{{ $item->id }}">
                                                Lihat Foto
                                            </button>
                                        @else
                                            <span class="text-muted">Tidak ada foto</span>
                                        @endif
                                    </td>
                                    <td class="action">
                                        <ul>
                                            <li class="edit">
                                                <a class="edit" href="{{ route('kandidat.edit', $item->id) }}">
                                                    <i class="ti ti-edit"></i>
                                                </a>
                                            </li>
                                            <li class="delete">
                                                <button type="button" class="btn btn-link text-danger p-0" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal{{ $item->id }}">
                                                    <i class="ti ti-trash"></i>
                                                </button>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @else
        <!-- Improved user view with better spacing -->
        <div class="kandidat-container">
            <div class="container">
                <h2 class="kandidat-title">Daftar Kandidat Ketua BEM</h2>
                <div class="row">
                    @foreach($kandidat as $item)
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="kandidat-card">
                                <div class="kandidat-img-container">
                                    @if($item->foto)
                                        <img src="{{ asset('storage/' . $item->foto) }}" class="kandidat-img" alt="{{ $item->nama }}">
                                    @else
                                        <div class="d-flex align-items-center justify-content-center h-100">
                                            <i class="fas fa-user-tie img-placeholder"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="kandidat-body">
                                    <h3 class="kandidat-name">{{ $item->nama }}</h3>
                                    <div class="kandidat-nim">NIM: {{ $item->nim }}</div>
                                    <div class="kandidat-desc">
                                        <p><strong>Visi:</strong> {{ Str::limit($item->visi, 75) }}</p>
                                        <p><strong>Misi:</strong> {{ Str::limit($item->misi, 75) }}</p>
                                    </div>
                                    <div class="kandidat-actions">
                                        <button type="button" class="btn btn-detail" data-bs-toggle="modal"
                                            data-bs-target="#modalDetail{{ $item->id }}">
                                            <i class="fas fa-info-circle me-2"></i>Detail Kandidat
                                        </button>
                                        
                                        @if(!Auth::user()->voting || is_null(Auth::user()->voting->kandidat_id))
                                            @if(!Auth::user()->nim || !Auth::user()->kelas || !Auth::user()->jurusan || !Auth::user()->voting)
                                                <button type="button" class="btn btn-warning w-100 py-2" data-bs-toggle="modal"
                                                    data-bs-target="#modalBefore{{ $item->id }}">
                                                    <i class="fas fa-check-circle me-2"></i>Pilih Kandidat
                                                </button>
                                            @else
                                                <form action="{{ route('voting.store') }}" method="POST" class="w-100">
                                                    @csrf
                                                    <input type="hidden" name="kandidat_id" value="{{ $item->id }}">
                                                    <button type="submit" class="btn btn-success w-100 py-2">
                                                        <i class="fas fa-check-circle me-2"></i>Pilih Kandidat
                                                    </button>
                                                </form>
                                            @endif
                                        @else
                                            <button class="btn btn-secondary w-100 py-2" disabled>
                                                <i class="fas fa-check-circle me-2"></i>Anda Sudah Memilih
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    {{-- Improved modals with better spacing --}}
    @foreach ($kandidat as $item)
        <div class="modal fade" id="modalDetail{{ $item->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Detail Kandidat: {{ $item->nama }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <h6>Visi:</h6>
                            <p class="modal-paragraph">{{ $item->visi }}</p>
                        </div>
                        <div class="mb-3">
                            <h6>Misi:</h6>
                            <p class="modal-paragraph">{!! nl2br(e($item->misi)) !!}</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    {{-- Include modal --}}
    @include('kandidat.modals')
@endsection