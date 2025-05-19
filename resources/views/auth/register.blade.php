<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel de Luna y Servicio</title>
    <link rel="icon" type="image/png" href="/images/logo-only.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background: linear-gradient(135deg, rgba(45,33,124,0.85) 0%, rgba(30,58,138,0.85) 100%), url('/images/background.jpeg') center center/cover no-repeat;
            min-height: 100vh;
            width: 100vw;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .centered-flex {
            min-height: 100vh;
            width: 100vw;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .card-login {
            position: relative;
            background: linear-gradient(135deg, rgba(44,34,124,0.93) 0%, rgba(30,58,138,0.93) 100%);
            border-radius: 1rem;
            box-shadow: 0 2px 12px 0 rgba(37,99,235,0.06);
            padding: 1.5rem 1.5rem 1.2rem 1.5rem;
            width: 500px;
            max-width: 95vw;
            height: 600px;
            margin: 0;
            overflow: hidden;
            color: #fff;
        }
        .sign-in-title {
            font-size: 2rem;
            text-align: center;
            margin-bottom: 0.7rem;
        }
        .welcome-text {
            font-size: 1.1rem;
            text-align: center;
            margin-bottom: 1.3rem;
        }
        .form-group { margin-bottom: 1rem; }
        .form-input {
            font-size: 1.08rem;
            background: #f8fafc;
            border: 1px solid #d1d5db;
            border-radius: 0.7rem;
            padding: 1rem 1.5rem;
            margin-bottom: 0.7rem;
            width: 400px;
            max-width: 90%;
            display: block;
            margin-left: auto;
            margin-right: auto;
            box-sizing: border-box;
        }
        .form-input:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.08);
            background: #fff;
        }
        .form-input::placeholder {
            color: #888;
            opacity: 1;
        }
        .login-btn {
            width: 400px;
            max-width: 90%;
            display: block;
            margin: 1.2rem auto 0 auto;
            font-size: 1.1rem;
            padding: 0.9rem 0;
            border-radius: 0.7rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-align: center;
        }
        .register-btn {
            background: #2ed8c3;
            color: #222;
            text-decoration: none;
            margin: 1.2rem auto 0 auto;
            padding: 0.9rem 0;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 0.7rem;
            letter-spacing: 0.5px;
            transition: background 0.2s, color 0.2s;
        }
        .register-btn:hover {
            background: #1fc2a0;
            color: #fff;
        }
        .btn-login-gradient {
            background: linear-gradient(90deg, #7b2ff2, #1e90ff);
            color: #fff;
            border: none;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 0.5rem;
            transition: background 0.3s;
        }
        .btn-login-gradient:hover {
            background: linear-gradient(90deg, #1e90ff, #7b2ff2);
            color: #fff;
        }
        .text-accent {
            color: #2ed8c3;
        }
        .mb-8 { margin-bottom: 1.5rem; }
        .mb-4 { margin-bottom: 1rem; }
        .w-36 { width: 6.5rem; height: 6.5rem; }
        @media (max-width: 600px) {
            .card-login { width: 98vw; padding: 0.7rem 0.2rem; }
            .w-36 { width: 4rem; height: 4rem; }
            .sign-in-title { font-size: 1.2rem; }
            .welcome-text { font-size: 0.95rem; }
            .login-btn { width: 98vw; max-width: 98vw; padding: 0.7rem 0; }
            .form-input { width: 98vw; max-width: 98vw; padding: 0.8rem 1rem; }
        }
    </style>
</head>
<body>
    <div class="centered-flex">
        <div class="card-login">
            <div class="mb-8 text-center">
                <img src="/images/logo-transparent.png" alt="Hotel de Luna y Servicio Logo" style="display: block; margin-left: auto; margin-right: auto; width: 6.5rem; height: 6.5rem; object-fit: contain;" />
                <h2 class="sign-in-title font-bold mb-2" style="background: linear-gradient(90deg, #7b2ff2, #1e90ff); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Register</h2>
                <p class="welcome-text text-accent mb-6">Create your account to get started.</p>
            </div>
            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf
                <div class="form-group">
                    <input id="name" name="name" type="text" required autofocus autocomplete="name"
                        class="form-input" placeholder="Enter your name" value="{{ old('name') }}" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>
                <div class="form-group">
                    <input id="email" name="email" type="email" required autocomplete="username"
                        class="form-input" placeholder="Enter your email address" value="{{ old('email') }}" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>
                <div class="form-group">
                    <input id="password" name="password" type="password" required autocomplete="new-password"
                        class="form-input" placeholder="Enter your password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>
                <div class="form-group">
                    <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password"
                        class="form-input" placeholder="Confirm your password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>
                <button type="submit" class="login-btn btn-login-gradient shadow-sm">Register</button>
            </form>
        </div>
    </div>
</body>
</html>
