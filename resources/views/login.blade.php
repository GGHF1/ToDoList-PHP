<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/loginstyle.css') }}">
    <link rel="icon" href="{{ asset('images/web-icon.png') }}" >
    <title>User Login</title>
</head>
<body>
    <div class="container">
        <h1>Login</h1>
        <div class="login-form">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <input type="text" name="username" id="username" placeholder="Username" required>
                <input type="password" name="password" id="password" placeholder="Password" required>
                
                <div class="options-container">
                    <label>
                        <input type="checkbox" onclick="showPassFunc()"> Show Password
                    </label>
                    <p class="forgot-pass">
                        <a href="{{ route('changepassword') }}">Forgot Password?</a>
                    </p>
                </div>

                <div class="button-container">
                    <button type="submit" id="log-button">Login</button>
                </div>
                @if (session('error'))
                    <div class="error-msg">
                        {{ session('error') }}
                    </div>
                @endif
            </form>
            <p class="register-link">
                Don't have an account? <a href="{{ route('register') }}">Click here to register</a>
            </p>
        </div>
    </div>
    <script src="{{ asset('js/showpass.js') }}"></script>
</body>
</html>
