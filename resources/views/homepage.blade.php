<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voting Online Ketua BEM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #4e73df;
            --secondary-color: #f8f9fc;
            --accent-color: #f6c23e;
            --dark-color: #5a5c69;
        }

        body {
            font-family: 'Nunito', sans-serif;
            background-color: var(--secondary-color);
        }

        .navbar {
            background: linear-gradient(135deg, var(--primary-color) 0%, #224abe 100%);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            font-weight: 800;
            font-size: 1.5rem;
        }

        .hero-section {
            background: linear-gradient(rgba(78, 115, 223, 0.8), rgba(78, 115, 223, 0.8)), 
                        url('https://images.unsplash.com/photo-1523050854058-8df90110c9f1?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 5rem 0;
            border-radius: 0 0 20px 20px;
            margin-bottom: 3rem;
        }

        .candidate-card {
            border-radius: 15px;
            overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s;
            margin-bottom: 2rem;
            border: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .candidate-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
        }

        .candidate-img {
            height: 250px;
            object-fit: cover;
            object-position: top;
        }

        .vote-progress {
            height: 10px;
            border-radius: 5px;
        }

        footer {
            background-color: var(--dark-color);
            color: white;
            padding: 2rem 0;
            margin-top: 3rem;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href="#"><i class="fas fa-vote-yea me-2"></i>LumoraVote</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link active" href="#">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#candidates">Kandidat</a></li>
                    <li class="nav-item"><a class="nav-link" href="/login">Login</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section text-center">
        <div class="container">
            <h1 class="display-4 fw-bold mb-4">PEMILIHAN KETUA BEM</h1>
            <p class="lead mb-5">Mari berpartisipasi dalam menentukan masa depan kampus kita!</p>
            <a href="#candidates" class="btn btn-light btn-lg px-4 me-2"><i class="fas fa-users me-1"></i> Lihat Kandidat</a>
            <a href="/login" class="btn btn-outline-light btn-lg px-4"><i class="fas fa-vote-yea me-1"></i> Vote Sekarang</a>
        </div>
    </section>

    <!-- Candidates Section -->
    <section id="candidates" class="container mb-5">
        <div class="text-center mb-5">
            <h2 class="fw-bold">KANDIDAT KETUA BEM</h2>
            <p class="lead text-muted">Berikut adalah kandidat yang akan bersaing dalam pemilihan ini</p>
        </div>

        <div class="row" id="kandidat-container">
            @foreach ($kandidats as $item)
                @php
                    $totalVotes = $kandidats->sum('votings_count');
                    $percentage = $totalVotes > 0 ? round(($item->votings_count / $totalVotes) * 100) : 0;
                @endphp
                <div class="col-lg-4 col-md-6">
                    <div class="card candidate-card">
                        <img src="{{ asset('storage/' . $item->foto) }}" class="card-img-top candidate-img" alt="{{ $item->nama }}">
                        <div class="card-body">
                            <h4 class="card-title">{{ $item->nama }}</h4>
                            <strong>NIM :</strong> <p class="text-muted">{{ $item->nim }}</p>
                            <strong>Visi :</strong> <p class="card-text">{{ $item->visi }}</p>
                            <strong>Misi :</strong> <p class="card-text">{{ $item->misi }}</p>

                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <small class="text-muted">Total Suara:</small>
                                <p class="card-text"> {{ $item->votings_count }}</p>
                            </div>
                            <div class="progress vote-progress mb-3">
                                <div class="progress-bar bg-success" role="progressbar" style="width: {{ $percentage }}%" aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Footer -->
    <footer class="text-center">
        <div class="container">
            <p class="mb-0">&copy; {{ date('Y') }} LumoraVOTE. By Tim_08.</p>
        </div>
    </footer>

    <script>
        function fetchKandidatData() {
            fetch('/getdata')
                .then(response => response.json())
                .then(data => {
                    const container = document.getElementById('kandidat-container');
                    container.innerHTML = '';

                    let totalVotes = data.reduce((acc, curr) => acc + curr.votings_count, 0);

                    data.forEach(item => {
                        let percentage = totalVotes > 0 ? Math.round((item.votings_count / totalVotes) * 100) : 0;
                        let card = `
                            <div class="col-lg-4 col-md-6">
                                <div class="card candidate-card">
                                    <img src="/storage/${item.foto}" class="card-img-top candidate-img" alt="${item.nama}">
                                    <div class="card-body">
                                        <h4 class="card-title">${item.nama}</h4>
                                        <strong>NIM :</strong> <p class="text-muted">${item.nim}</p>
                                        <strong>Visi :</strong> <p class="card-text">${item.visi.replace(/\n/g, '<br>')}</p>
                                        <strong>Misi :</strong> <p class="card-text">${item.misi.replace(/\n/g, '<br>')}</p>

                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <small class="text-muted">Total Suara:</small>
                                            <p class="card-text"> ${item.votings_count}</p>
                                        </div>
                                        <div class="progress vote-progress mb-3">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: ${percentage}%" aria-valuenow="${percentage}" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;

                        container.innerHTML += card;
                    });
                });
        }

        // Panggil saat halaman pertama kali dimuat
        fetchKandidatData();

        // Refresh setiap 5 detik
        setInterval(fetchKandidatData, 5000);
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
