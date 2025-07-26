@extends('layouts.mantis')

@section('content')
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if(Auth::check() && Auth::user()->role->role_name == 'admin')
        <style>
            #table th {
                text-align: center;
                vertical-align: middle;
            }

            #table td {
                text-align: left;
                vertical-align: middle;
            }

            #table td:nth-child(1),
            #table td:nth-child(7),
            #table td:nth-child(8) {
                text-align: center;
            }
            
            /* Tambahan style untuk mengatasi z-index dan scroll */
            .swal2-container {
                z-index: 99999 !important;
            }
            .modal-backdrop {
                z-index: 1040 !important;
            }
            body {
                overflow: auto !important;
                padding-right: 0 !important;
            }
        </style>
        <div class="container">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Rekapitulasi Suara</h4>
                </div>
                <div class="card-body">
                    <div id="chart" class="mb-4"></div>

                    <h5>Data Profile</h5>
                    <table class="table table-striped table-sm table-bordered" id="table">
                        <thead style="background-color: #6C63FF;">
                            <tr>
                                <th>No</th>
                                <th>Nama Pemilih</th>
                                <th>Email</th>
                                <th>NIM</th>
                                <th>Kelas</th>
                                <th>Jurusan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Modal konfirmasi hapus --}}
        <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Konfirmasi Hapus</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <p>Yakin ingin menghapus <strong id="deleteUserName"></strong>? Data tidak dapat dikembalikan.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Hapus</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            window.onload = function () {
                const chartData = @json($rekap);
                const categories = chartData.map(i => i.nama);
                const votes = chartData.map(i => i.votings_count);

                const chart = new ApexCharts(document.querySelector('#chart'), {
                    chart: { type: 'bar', height: 400 },
                    series: [{ name: 'Jumlah Suara', data: votes }],
                    xaxis: { categories },
                    dataLabels: { enabled: true }
                });
                chart.render();

                let selectedDeleteId = null;

                function updateChartAndTable() {
                    fetch('/chart-data')
                        .then(r => r.json())
                        .then(d => {
                            chart.updateOptions({
                                series: [{ name: 'Jumlah Suara', data: d.map(i => i.votings_count) }],
                                xaxis: { categories: d.map(i => i.nama) }
                            });
                        });

                    fetch('/voting-data')
                        .then(r => r.json())
                        .then(data => {
                            const tbody = document.querySelector('#table tbody');
                            tbody.innerHTML = '';
                            data.forEach((item, index) => {
                                const status = item.kandidat_id
                                    ? '<button class="btn btn-success mt-auto" disabled>Sudah memilih</button>'
                                    : '<button class="btn btn-danger mt-auto" disabled>Belum memilih</button>';

                                const row = `
                                    <tr>
                                        <td style="text-align:center;">${index + 1}</td>
                                        <td>${item.user?.name ?? '-'}</td>
                                        <td>${item.user?.email ?? '-'}</td>
                                        <td>${item.nim}</td>
                                        <td>${item.kelas}</td>
                                        <td>${item.jurusan}</td>
                                        <td style="text-align:center;">${status}</td>
                                        <td style="text-align:center;">
                                            <button type="button" class="btn btn-danger btn-sm delete-voting"
                                                data-id="${item.id}" data-name="${item.user?.name ?? 'User'}"
                                                data-bs-toggle="modal" data-bs-target="#confirmDeleteModal">
                                                Hapus
                                            </button>
                                        </td>
                                    </tr>
                                `;
                                tbody.insertAdjacentHTML('beforeend', row);
                            });

                            // Re-bind tombol delete
                            document.querySelectorAll('.delete-voting').forEach(button => {
                                button.addEventListener('click', function () {
                                    selectedDeleteId = this.dataset.id;
                                    document.getElementById('deleteUserName').textContent = this.dataset.name;
                                });
                            });
                        });
                }

                // Fungsi untuk membersihkan modal dan mengembalikan scroll
                function restorePageScroll() {
                    // Hapus semua backdrop
                    const backdrops = document.querySelectorAll('.modal-backdrop, .swal2-backdrop-show');
                    backdrops.forEach(backdrop => backdrop.remove());
                    
                    // Reset body styles
                    document.body.style.overflow = 'auto';
                    document.body.style.paddingRight = '0';
                    document.body.classList.remove('modal-open', 'swal2-shown', 'swal2-height-auto');
                    
                    // Hapus container SweetAlert jika ada
                    const swalContainers = document.querySelectorAll('.swal2-container');
                    swalContainers.forEach(container => container.remove());
                }

                // Hapus Voting dengan penanganan modal yang lebih baik
                document.getElementById('confirmDeleteBtn').addEventListener('click', function () {
                    if (!selectedDeleteId) return;

                    const modal = bootstrap.Modal.getInstance(document.getElementById('confirmDeleteModal'));
                    
                    fetch(`/voting/${selectedDeleteId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(async res => {
                        const data = await res.json();
                        
                        // Tutup modal dengan callback
                        if (modal) {
                            modal.hide();
                            
                            // Event listener untuk setelah modal benar-benar tertutup
                            document.getElementById('confirmDeleteModal').addEventListener('hidden.bs.modal', function() {
                                restorePageScroll();
                                
                                if (res.ok && data.success) {
                                    Swal.fire({
                                        toast: true,
                                        icon: 'success',
                                        title: 'Data berhasil dihapus!',
                                        position: 'top-end',
                                        showConfirmButton: false,
                                        timer: 2000,
                                        timerProgressBar: true
                                    }).then(() => {
                                        updateChartAndTable();
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Gagal',
                                        text: data.message || 'Gagal menghapus data.'
                                    });
                                }
                            }, { once: true });
                        } else {
                            restorePageScroll();
                        }
                    })
                    .catch((error) => {
                        console.error('Error:', error);
                        restorePageScroll();
                        Swal.fire({
                            icon: 'error',
                            title: 'Kesalahan Server',
                            text: 'Tidak dapat menghubungi server.'
                        });
                    });
                });

                updateChartAndTable();
                setInterval(updateChartAndTable, 5000);
            };
        </script>

        @vite('resources/js/app.js')
    @endif
@endsection