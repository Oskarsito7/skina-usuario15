<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Iniciar sesión</title>
    <link rel="shortcut icon" href="{{ asset('public/osei_logo.png') }}">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="public/plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="public/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="public/dist//css/adminlte.min.css">
    <style>
        body {
            height: 100vh;
            width: 100%;
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #07233d, #1A5F99, #2A93D5);
        }

        .login-container {
            background-color: rgba(10, 25, 40, 0.85);
            padding: 40px 35px;
            border-radius: 12px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.4);
            width: 100%;
            max-width: 380px;
            color: #fff;
        }

        .login-container h2 {
            text-align: center;
            margin-bottom: 35px;
            color: #E0E0E0;
            font-size: 2.2rem;
            font-weight: 600;
        }

        .input-group {
            margin-bottom: 28px;
            position: relative;
        }

        .input-group label {
            display: block;
            margin-bottom: 8px;
            color: #B0B0B0;
            font-size: 0.9rem;
            font-weight: 500;
            background-color: transparent;
        }

        .input-group input[type="text"],
        .input-group input[type="email"],
        .input-group input[type="password"] {
            width: 100%;
            padding: 12px 0;
            font-size: 1rem;
            color: #fff;
            background-color: transparent;
            border: none;
            border-bottom: 2px solid #555;
            outline: none;
            transition: border-color 0.3s ease;
            box-sizing: border-box;
        }

        .input-group input[type="text"]:focus,
        .input-group input[type="email"]:focus,
        .input-group input[type="password"]:focus {
            border-bottom-color: #2A93D5;
        }

        .input-group input::placeholder {
            color: #777;
            opacity: 1;
        }


        .submit-btn {
            background-color: #E67E22;
            /* Color naranja original */
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 1.1rem;
            font-weight: 600;
            width: 100%;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 20px;
            /* Transiciones para suavizar los cambios */
            transition: background-color 0.2s ease, transform 0.1s ease, box-shadow 0.2s ease;
            outline: none;
            /* Evita el contorno predeterminado en algunos navegadores al hacer clic */
        }

        .submit-btn:hover {
            transform: translateY(1px);
            background-color: #FFA726;
            box-shadow: 0 0 8px rgba(255, 167, 38, 0.6),
                0 0 15px rgba(255, 204, 0, 0.7),
                0 0 25px rgba(255, 204, 0, 0.5);
        }


        .error-message {
            color: #E74C3C;
            font-size: 0.85rem;
            display: block;
            margin-top: 6px;
        }

        .input-group input.is-invalid {
            border-bottom-color: #E74C3C !important;
        }

        .login-links {
            text-align: center;
            margin-top: 25px;
        }

        .login-links a {
            color: #A0DFFF;
            text-decoration: none;
            font-size: 0.9rem;
            margin: 0 10px;
        }

        .login-links a:hover {
            text-decoration: underline;
            color: #FFA726;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h2>Inventario Skina</h2>

        @if (Route::has('login'))
            <div class="login-links">
                @auth
                    <a href="{{ url('/dashboard') }}"
                        class="text-sm text-gray-700 dark:text-gray-500 underline">Dashboard</a>
                @else
                    <a href="{{ route('login') }}">Iniciar sesión</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}">Registrarse</a>
                    @endif
                @endauth
            </div>
        @endif

    </div>
</body>

</html>
