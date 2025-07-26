@extends('layouts.mantis')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header">
                    <h4>Selamat Datang di Halaman Pemilihan Ketua BEM</h4>
                </div>
                <div class="card-body">
                    <div class="row align-items-center">
                        <!-- GIF di kiri -->
                        <div class="col-md-5 text-center mb-3 mb-md-0">
                            <img src="{{ asset('storage/HI_Robot.gif') }}" alt="Robot Welcome" class="img-fluid" style="max-height: 250px;">
                        </div>

                        <!-- Penjelasan di kanan -->
                        <div class="col-md-7">
                            <h5>Apa itu LumoraVote?</h5>
                            <p>
                                <strong>LumoraVote</strong> adalah aplikasi berbasis web yang dirancang untuk mempermudah proses pemilihan ketua BEM secara online, cepat, dan transparan.
                                Setiap mahasiswa dapat memberikan suaranya dengan aman melalui sistem ini. Dengan antarmuka yang user-friendly dan fitur real-time, LumoraVote memastikan keadilan dalam setiap proses pemilihan.
                            </p>
                            <p>
                                Ayo gunakan hak suaramu dan jadilah bagian dari perubahan kampus yang lebih baik bersama LumoraVote!
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
