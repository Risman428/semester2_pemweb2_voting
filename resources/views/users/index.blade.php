@extends('layouts.mantis')

@section('content')

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
    #table td:nth-child(5) {
        text-align: center;
    }
</style>

<div class="card">
    <div class="card-header">
        <div class="card-title">Data Users</div>
    </div>
    <div class="card-body">
        <table class="table table-striped table-sm table-bordered" id="table">
            <thead style="background-color: #6C63FF;">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Opsi</th>
                </tr>
            </thead>
            <tbody id="userTableBody">
                <!-- Akan diisi secara dinamis oleh JavaScript -->
            </tbody>
        </table>
    </div>
</div>

<!-- Penampung semua modal -->
<div id="modalsContainer"></div>

<script>
    window.onload = function () {
        const tableBody = document.getElementById('userTableBody');
        const modalContainer = document.getElementById('modalsContainer');

        function fetchUserData() {
            // Cek apakah ada modal yang sedang terbuka
            const isModalOpen = document.querySelector('.modal.show') !== null;
            if (isModalOpen) return; // Jangan update kalau modal terbuka

            fetch('/user-data')
                .then(res => res.json())
                .then(users => {
                    tableBody.innerHTML = '';
                    modalContainer.innerHTML = '';

                    users.forEach((user, index) => {
                        const modalId = `roleModal${user.id}`;
                        const row = `
                            <tr>
                                <td style="text-align:center;">${index + 1}</td>
                                <td>${user.name}</td>
                                <td>${user.email}</td>
                                <td>${user.role?.role_name ?? '-'}</td>
                                <td style="text-align:center;">
                                    <button type="button" class="btn btn-sm" style="background-color: #6C63FF; color: white;"
                                        data-bs-toggle="modal" data-bs-target="#${modalId}">
                                        Ganti Role
                                    </button>
                                </td>
                            </tr>
                        `;
                        tableBody.insertAdjacentHTML('beforeend', row);

                        const modal = `
                            <div class="modal fade" id="${modalId}" tabindex="-1" aria-labelledby="modalLabel${user.id}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Ganti Role</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p class="my-2 text-center text-secondary">Mengganti role dapat merubah hak akses user, klik Ganti Role untuk melanjutkan.</p>
                                        <form action="{{ route('users.update-role') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="user_id" value="${user.id}">
                                            <div>
                                                <label for="role_id">Tentukan Role Akses</label>
                                                <select name="role_id" class="form-control">
                                                    <option value="">Pilih Role</option>
                                                    @foreach ($roles as $role)
                                                        <option value="{{ $role->id }}">{{ $role->role_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div>
                                                <button type="submit" class="btn mt-2 w-100" style="background-color: #6C63FF; color: white;">Ganti Role</button>
                                            </div>
                                        </form>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        `;
                        modalContainer.insertAdjacentHTML('beforeend', modal);
                    });
                });
        }


        fetchUserData();
        setInterval(fetchUserData, 5000);
    };
</script>

@endsection
