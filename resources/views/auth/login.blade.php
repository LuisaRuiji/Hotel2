{{-- Modern Login UI --}}
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
            background: url('/images/background.jpeg') center center/cover no-repeat;
            min-height: 50vh;
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
            padding: 2.5rem 2.5rem 2rem 2.5rem;
            width: 500px;
            max-height: 100vh;
            height:700px;
            margin: 0;
            overflow: hidden;
            color: #fff;
        }
        .card-login .card-overlay {
            position: absolute;
            inset: 0;
            background: rgba(255,255,255,0.92);
            border-radius: 1rem;
            z-index: 1;
            pointer-events: none;
        }
        .card-login > *:not(.card-overlay) {
            position: relative;
            z-index: 2;
        }
        .card-login input,
        .card-login label,
        .card-login .text-accent,
        .card-login .text-primary,
        .card-login .btn-login-gradient {
            color: #222 !important;
        }
        .card-login .btn-login-gradient {
            color: #fff !important;
        }
        .card-login input {
            background: #f8fafc;
            border: 1px solid #d1d5db;
        }
        .card-login input:focus {
            background: #fff;
        }
        .card-login .form-input::placeholder {
            color: #888;
            opacity: 1;
        }
        .card-login .form-group { margin-bottom: 1.1rem; }
        .card-login .mb-8 { margin-bottom: 2rem; }
        .card-login .mb-4 { margin-bottom: 1rem; }
        .card-login .w-36 { width: 6.5rem; height: 6.5rem; }
        .card-login .text-3xl { font-size: 2rem; font-weight: 700; }
        .card-login .font-bold { font-weight: 700; }
        .card-login .text-lg { font-size: 1.1rem; }
        .card-login .mt-2 { margin-top: 0.5rem; }
        .card-login .rounded { border-radius: 0.5rem; }
        .card-login .shadow-sm { box-shadow: 0 1px 4px 0 rgba(0,0,0,0.04); }
        .card-login label, .card-login .text-sm { font-size: 0.98rem; }
        .card-login .form-input {
            font-size: 1.08rem;
            padding: 0.75rem 1rem;
            margin-bottom: 0.5rem;
            border-radius: 0.5rem;
            width: 100%;
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
        .form-input {
            font-size: 1.08rem;
            background: #f8fafc;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            padding: 0.75rem 1rem;
            margin-bottom: 0.5rem;
            transition: border-color 0.2s, box-shadow 0.2s;
            width: 100%;
        }
        .form-input:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.08);
            background: #fff;
        }
        .form-group { margin-bottom: 1.1rem; }
        .text-primary {
            color: #2563eb;
        }
        .text-accent {
            color: #2ed8c3;
        }
        .centered-flex {
            min-height: 100vh;
            width: 100vw;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .text-3xl { font-size: 2rem; font-weight: 700; }
        .font-bold { font-weight: 700; }
        .text-lg { font-size: 1.1rem; }
        .mt-2 { margin-top: 0.5rem; }
        .rounded { border-radius: 0.5rem; }
        .shadow-sm { box-shadow: 0 1px 4px 0 rgba(0,0,0,0.04); }
        label, .text-sm { font-size: 0.98rem; }
        @media (max-width: 500px) {
            .card-login { padding: 1.2rem 0.5rem; max-width: 98vw; }
            .card-login .w-36 { width: 4.5rem; height: 4.5rem; }
            .card-login .text-3xl { font-size: 1.3rem; }
        }
        .sign-in-title {
            font-size: 2.8rem;
            text-align: center;
            margin-bottom: 0.5rem;
        }
        .welcome-text {
            font-size: 1.5rem;
            text-align: center;
            margin-bottom: 2rem;
        }
        .login-btn {
            display: block;
            margin: 2rem auto 0 auto;
            width: 80%;
            padding: 1rem 0;
            font-size: 1.3rem;
            font-weight: 700;
            border-radius: 0.7rem;
            letter-spacing: 0.5px;
        }
        @media (max-width: 500px) {
            .sign-in-title { font-size: 1.6rem; }
            .welcome-text { font-size: 1.1rem; }
            .login-btn { font-size: 1rem; padding: 0.7rem 0; width: 100%; }
        }
        .register-btn {
            display: block;
            width: 80%;
            margin: 1.2rem auto 0 auto;
            padding: 0.9rem 0;
            font-size: 1.1rem;
            font-weight: 600;
            text-align: center;
            border-radius: 0.7rem;
            background: #2ed8c3;
            color: #222;
            text-decoration: none;
            letter-spacing: 0.5px;
            transition: background 0.2s, color 0.2s;
        }
        .register-btn:hover {
            background: #1fc2a0;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="centered-flex">
        <div class="card-login">
            <div class="card-overlay"></div>
            <div class="mb-8 text-center">
                <img src="/images/logo-transparent.png" alt="Hotel de Luna y Servicio Logo" style="display: block; margin-left: auto; margin-right: auto; width: 12rem; height: 12rem; object-fit: contain;" />
                <h2 class="sign-in-title font-bold mb-2" style="background: linear-gradient(90deg, #7b2ff2, #1e90ff); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Sign In</h2>
                <p class="welcome-text text-accent mb-6">Welcome back! Please login to your account.</p>
            </div>
            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf
                <!-- Email Address -->
                <div class="form-group">
                    <input id="email" name="email" type="email" required autofocus autocomplete="username"
                        class="form-input py-2 h-12 bg-gray-50 border border-gray-300 rounded focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition w-full" placeholder="Enter your email address" value="{{ old('email') }}" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>
                <!-- Password -->
                <div class="form-group">
                    <input id="password" name="password" type="password" required autocomplete="current-password"
                        class="form-input py-2 h-12 bg-gray-50 border border-gray-300 rounded focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition w-full" placeholder="Enter your password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>
                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between mb-4">
                    <label class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" name="remember" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                        <span class="ml-2 text-sm text-gray-200">Remember me</span>
                    </label>
                    @if (Route::has('password.request'))
                        <a class="text-sm text-accent hover:underline" href="{{ route('password.request') }}">
                            Forgot password?
                        </a>
                    @endif
                </div>
                <!-- Login Button -->
                <button type="submit" class="login-btn btn-login-gradient shadow-sm">Log in</button>
            </form>
            <a href="{{ route('register') }}" class="register-btn">Register</a>
        </div>
    </div>
</body>
</html>
