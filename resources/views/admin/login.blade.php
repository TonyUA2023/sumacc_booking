<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Admin Login - SUMACC</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        :root {
            --primary-color: #3498db; /* Un azul moderno y profesional */
            --primary-hover-color: #2980b9;
            --text-color: #4a5568; /* Gris oscuro para texto principal */
            --label-color: #718096; /* Gris más claro para etiquetas */
            --background-color: #f7fafc; /* Un gris muy claro para el fondo */
            --card-background-color: #ffffff;
            --border-color: #e2e8f0; /* Borde sutil para inputs */
            --error-bg-color: #fff5f5;
            --error-text-color: #c53030;
            --error-border-color: #fc8181;
            --font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            --border-radius: 8px;
            --input-padding: 14px;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeInError {
            from { opacity: 0; max-height: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0; }
            to { opacity: 1; max-height: 100px; margin-bottom: 25px; padding-top: 15px; padding-bottom: 15px; } /* Ajusta max-height según necesidad */
        }


        body {
            font-family: var(--font-family);
            background-color: var(--background-color);
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color: var(--text-color);
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        .login-wrapper {
            animation: fadeIn 0.5s ease-out forwards;
            width: 100%;
            padding: 20px;
            box-sizing: border-box;
        }

        .login-container {
            background-color: var(--card-background-color);
            padding: 30px 40px 40px 40px; /* Aumentado padding inferior */
            border-radius: var(--border-radius);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05), 0 5px 10px rgba(0,0,0,0.02);
            width: 100%;
            max-width: 420px;
            margin: auto;
            box-sizing: border-box;
        }

        .app-logo {
            text-align: center;
            margin-bottom: 15px; /* Reducido margen inferior */
        }

        .app-logo img {
            max-width: 120px; /* Ajusta según tu logo */
            height: auto;
            margin-bottom: 5px;
        }

        .app-logo .app-name {
            font-size: 28px; /* Aumentado tamaño */
            font-weight: 700; /* Más grueso */
            color: var(--primary-color);
            letter-spacing: -0.5px;
        }


        .login-container h1 {
            color: var(--text-color);
            font-size: 22px; /* Ligeramente más pequeño para balancear con el logo */
            font-weight: 600;
            text-align: center;
            margin-top: 0; /* Quitado margen superior si el logo está arriba */
            margin-bottom: 35px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            font-weight: 500;
            margin-bottom: 10px;
            font-size: 14px;
            color: var(--label-color);
        }

        .form-group input[type="email"],
        .form-group input[type="password"] {
            width: 100%;
            padding: var(--input-padding);
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            box-sizing: border-box;
            font-size: 16px;
            color: var(--text-color);
            background-color: var(--background-color); /* Fondo sutil para inputs */
            transition: border-color 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }

        .form-group input[type="email"]:focus,
        .form-group input[type="password"]:focus {
            border-color: var(--primary-color);
            outline: none;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.15);
            background-color: var(--card-background-color);
        }

        .login-button {
            width: 100%;
            padding: var(--input-padding);
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: var(--border-radius);
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s ease-in-out, transform 0.1s ease-in-out;
            box-shadow: 0 4px 15px rgba(52, 152, 219, 0.2);
        }

        .login-button:hover {
            background-color: var(--primary-hover-color);
            box-shadow: 0 6px 20px rgba(52, 152, 219, 0.3);
        }
        .login-button:active {
            transform: scale(0.98);
        }

        .errors-container {
            background-color: var(--error-bg-color);
            color: var(--error-text-color);
            border-left: 4px solid var(--error-border-color);
            border-radius: 4px; /* Cambiado para que solo el borde izquierdo sea el acento */
            padding: 15px 20px;
            margin-bottom: 25px; /* Ajustado margen */
            animation: fadeInError 0.4s ease-out forwards;
            overflow: hidden; /* Para que funcione la animación de max-height */
        }

        .errors-container ul {
            margin: 0;
            padding: 0;
            list-style-type: none; /* Removidas viñetas por defecto */
        }
        .errors-container li {
            margin-bottom: 8px;
            font-size: 14px;
        }
        .errors-container li:last-child {
            margin-bottom: 0;
        }
        /* Fuente Inter (opcional, si la quieres cargar) */
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
    </style>
</head>
<body>
    <div class="login-wrapper">
        <div class="login-container">
            <div class="app-logo">
                {{-- Si tienes un logo SVG o PNG, úsalo aquí: --}}
                {{-- <img src="{{ asset('images/logo-sumacc.svg') }}" alt="SUMACC Logo"> --}}
                <div class="app-name">SUMACC</div>
            </div>
            <h1>Administrator Login</h1>

            @if ($errors->any())
                <div class="errors-container">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login.submit') }}">
                @csrf

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" required>
                </div>

                <div class="form-group" style="margin-top: 30px;"> {{-- Más espacio antes del botón --}}
                    <button type="submit" class="login-button">Log In</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>