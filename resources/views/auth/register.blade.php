<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Voting Online Ketua BEM</title>
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
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .navbar {
            background: linear-gradient(135deg, var(--primary-color) 0%, #224abe 100%);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            font-weight: 800;
            font-size: 1.5rem;
        }

        .login-hero {
            background: linear-gradient(rgba(78, 115, 223, 0.8), rgba(78, 115, 223, 0.8)), 
                        url('https://images.unsplash.com/photo-1523050854058-8df90110c9f1?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 3rem 0;
            border-radius: 0 0 20px 20px;
            margin-bottom: 3rem;
        }

        .login-card {
            border-radius: 15px;
            border: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            max-width: 500px;
            margin: 0 auto;
        }

        .login-card-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, #224abe 100%);
            color: white;
            padding: 1.5rem;
            text-align: center;
        }

        .login-card-body {
            padding: 2rem;
            background-color: white;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(78, 115, 223, 0.25);
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: #3e63c9;
            border-color: #3e63c9;
        }

        .login-footer {
            margin-top: auto;
            background-color: var(--dark-color);
            color: white;
            padding: 1.5rem 0;
            text-align: center;
        }

        .social-login .btn {
            border-radius: 50px;
            padding: 0.5rem;
            width: 40px;
            height: 40px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin: 0 5px;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="/"><i class="fas fa-vote-yea me-2"></i>LumoraVote</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="/homepage">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="/login">Login</a></li>
                    <li class="nav-item"><a class="nav-link active" href="/register">Register</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="login-hero text-center">
        <div class="container">
            <h1 class="display-5 fw-bold mb-3">BUAT AKUN BARU</h1>
            <p class="lead">Daftarkan diri Anda untuk menggunakan hak suara dalam pemilihan</p>
        </div>
    </section>

    <!-- Register Form -->
    <div class="container mb-5">
        <div class="login-card">
            <div class="login-card-header">
                <h3><i class="fas fa-user-plus me-2"></i>Register</h3>
            </div>
            <div class="login-card-body">
                <form action="{{ route('register') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Masukkan nama lengkap Anda" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Masukkan email Anda" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Masukkan password Anda" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Masukkan ulang password Anda" required>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="terms" name="terms" required>
                        <label class="form-check-label" for="terms">Saya menyetujui <a href="#" class="text-primary">Syarat dan Ketentuan</a></label>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg"><i class="fas fa-user-plus me-2"></i>Daftar</button>
                    </div>
                </form>

                <div class="text-center mt-4">
                    <p class="mb-3">Atau daftar dengan</p>
                    <div class="social-login">
                        <a href="#" class="btn btn-outline-primary"><i class="fab fa-google"></i></a>
                        <a href="#" class="btn btn-outline-primary"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="btn btn-outline-primary"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <p>Sudah punya akun? <a href="{{ route('login') }}" class="text-primary">Masuk disini</a></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="login-footer">
        <div class="container">
            <p class="mb-0">&copy; {{ date('Y') }} LumoraVOTE. By Tim_08.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>