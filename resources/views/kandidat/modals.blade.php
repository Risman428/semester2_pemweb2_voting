<style>
    /* Tambahkan style ini di bagian head atau file CSS terpisah */
    .modal-text {
        white-space: pre-wrap; /* Mempertahankan line breaks */
        word-wrap: break-word; /* Memastikan kata panjang bisa dipotong */
        text-align: justify; /* Rata kiri-kanan */
        padding: 0 0.5rem; /* Sedikit padding horizontal */
        margin-bottom: 0; /* Hilangkan margin bawah default */
    }
    
    .modal-dialog {
        max-width: 600px; /* Lebar maksimal modal */
    }
    
    .modal-content {
        border-radius: 10px;
    }


    /* modal detail */ 
    .text-detail {
        font-size: 18px;
    }
</style>


{{-- Modal Delete --}}
@foreach ($kandidat as $item)
    <div class="modal fade" id="confirmDeleteModal{{ $item->id }}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <p>Yakin ingin menghapus <strong>{{ $item->nama }}</strong>? Data tidak dapat dikembalikan.</p>
                </div>
                <div class="modal-footer">
                    <form action="{{ route('kandidat.destroy', $item->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger">Hapus</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach

    {{-- Modal Visi --}}
@foreach ($kandidat as $item)
    @if ($item->visi)
        <div class="modal fade" id="modalVisi{{ $item->id }}" tabindex="-1" aria-labelledby="visiModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Visi - {{ $item->nama }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body p-4">
                        <h5 class="fw-bold mb-3">Visi:</h5>
                        <div class="px-3">
                            <p class="modal-text">{!! nl2br(e($item->visi)) !!}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endforeach

    {{-- Modal Misi --}}
@foreach ($kandidat as $item)
    @if ($item->misi)
        <div class="modal fade" id="modalMisi{{ $item->id }}" tabindex="-1" aria-labelledby="misiModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Misi - {{ $item->nama }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body p-4">
                        <h5 class="fw-bold mb-3">Misi:</h5>
                        <div class="px-3">
                            <p class="modal-text">{!! nl2br(e($item->misi)) !!}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endforeach

{{-- Modal Foto --}}
@foreach ($kandidat as $item)
    @if ($item->foto)
        <div class="modal fade" id="modalFoto{{ $item->id }}" tabindex="-1" aria-labelledby="fotoModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Foto {{ $item->nama }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body text-center">
                        <img src="{{ asset('storage/' . $item->foto) }}" alt="Foto Kandidat" class="img-fluid rounded">
                    </div>
                </div>
            </div>
        </div>
    @endif
@endforeach

{{-- Modal Detail --}}
@foreach ($kandidat as $item)
    <div class="modal fade" id="modalDetail{{ $item->id }}" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Visi & Misi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body p-4">
                    <h5 class="fw-bold mb-3">Visi:</h5>
                    <div class="px-3 mb-4">
                        <p class="modal-text">{!! nl2br(e($item->visi)) !!}</p>
                    </div>
                    
                    <h5 class="fw-bold mb-3">Misi:</h5>
                    <div class="px-3">
                        <p class="modal-text">{!! nl2br(e($item->misi)) !!}</p>
                    </div>
                    
                    <div class="mt-4 pt-3 border-top">
                        <small class="text-muted">NIM: {{ $item->nim }}</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach


{{-- kondisi belum voting --}}
@foreach ($kandidat as $item)
    <div class="modal fade" id="modalBefore{{ $item->id }}" tabindex="-1" aria-labelledby="beforeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Notification</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <p class="text-detail">Maaf anda belum bisa memilih <b><i>{{ $item->nama }}</i></b>, anda harus mengisi profile terlebih dahulu</p>
                </div>
            </div>
        </div>
    </div>
@endforeach