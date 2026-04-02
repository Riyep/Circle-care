<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/jpeg" href="{{ asset('assets/images/Logo.png') }}">
    <title>Login</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background:
                linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.3)),
                url('/assets/images/background.jpg') no-repeat center center;
            background-size: cover;
            border-radius: 25%;
        }

        .login-card {
            padding: 3rem;
            border: 1px solid #dee2e6;
            width: 30%;
            border-radius: 8px;
            background-color: rgba(255, 255, 255, 0.9);
            box-shadow: 2px 4px 6px rgba(0, 0, 0, 0.1);
            position: relative;
            top: 15mm;
        }

        .welcome-text {
            position: absolute;
            top: 3%;
            left: 50%;
            transform: translateX(-50%);
            color: #ffffff;
            font-size: 6rem;
            text-align: center;
            font-weight: bold;
            text-shadow:
                1px 1px 0 rgba(0, 0, 0, 0.5),
                -1px 1px 0 rgba(0, 0, 0, 0.5),
                1px -1px 0 rgba(0, 0, 0, 0.5),
                -1px -1px 0 rgba(0, 0, 0, 0.5),
                2px 2px 0 rgba(0, 0, 0, 0.5),
                -2px 2px 0 rgba(0, 0, 0, 0.5),
                2px -2px 0 rgba(0, 0, 0, 0.5),
                -2px -2px 0 rgba(0, 0, 0, 0.5);
        }

        .subtext {
            position: absolute;
            top: 20%;
            left: 50%;
            transform: translateX(-50%);
            color: #fff;
            font-size: 1.7rem;
            text-align: center;
            text-shadow:
                1px 1px 0 rgba(0, 0, 0, 0.5),
                -2px 2px 0 rgba(0, 0, 0, 0.5);
        }

        .login-container {
            position: relative;
            width: 100%;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

         .notification {
            position: absolute;
            top: calc(100% + 10px); /* Posisi di bawah login card */
            left: 50%;
            transform: translateX(-50%);
            width: 120%;
            max-width: 600px;
            z-index: 10;
            opacity: 0; /* Awalnya tidak terlihat */
            animation: fadeInSlide 0.5s ease-out forwards; /* Tambahkan animasi */
        }

        @keyframes fadeInSlide {
            0% {
                opacity: 0;
                transform: translate(-50%, -10px); /* Mulai dari sedikit lebih atas */
            }
            100% {
                opacity: 1;
                transform: translate(-50%, 0); /* Posisi akhir */
            }
        }

        .notification .alert {
            margin: 0;
            padding: 1rem;
            border-radius: 8px; /* Tambahkan sedikit sudut membulat */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Tambahkan efek bayangan */
        }

    </style>
</head>

<body>
    <div class="login-container">
        <!-- Welcome text and subtext -->
        <div class="welcome-text">Welcome</div>
        <div class="subtext">Silahkan tulis permasalahan anda di sini</div>

        <!-- Login Card -->
        <div class="login-card">
            <h3 class="text-center mb-4">Login</h3>

            <div class="container mt-5">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group">
                        <label for="mt_useremail">Email:</label>
                        <input type="email" name="mt_useremail" id="mt_useremail" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="mt_userpass">Password:</label>
                        <input type="password" name="mt_userpass" id="mt_userpass" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Login</button>
                </form>
                <p class="mt-3 text-center">
                    Belum punya akun? <a href="{{ route('register') }}">Daftar</a>
                </p>
            </div>
            @if ($errors->any())
            <div class="notification">
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
        </div>      
    </div>
</body>

</html>
