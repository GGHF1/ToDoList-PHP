<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/registerstyle.css') }}">
    <link rel="icon" href="{{ asset('images/web-icon.png') }}" >
    <title>User Registration</title>
</head>
<body>
    <div class="container">
        <h1>Registration</h1>

        <div class="register-form">
            <form method="post" action="{{ route('register') }}" accept-charset="UTF-8">
                {{ csrf_field() }}

                <input type="text" name="username" id="username" placeholder="Username" required minlength="4" maxlength="20">
                <div id="usernameError" class="error-message"></div>

                <input type="email" name="email" id="email" placeholder="Email" required>
                <div class="error-message"></div>

                <input type="password" name="password" id="password" placeholder="Password" required>
                <div id="passwordError" class="error-message"></div>

                <button type="submit" id="reg-button" disabled>Register</button>
            </form>
        </div>
    </div>
    <script src="{{ asset('js/reg-input.js') }}"></script>
</body>
</html>
