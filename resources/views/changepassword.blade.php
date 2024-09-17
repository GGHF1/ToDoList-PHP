<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/passStyle.css') }}">
    <link rel="icon" href="{{ asset('images/web-icon.png') }}" >
    <title>Password Change</title>
</head>
<body>
    <div class="container">
        <div class="pass-form">
            <form method="POST" action="{{ route('changepassword') }}">
            @csrf
                <h1>Password Change</h1>
                <input type="text" name="username" id="username" placeholder="Username" required>
                <input type="email" name="email" id="email" placeholder="Email" required>
                <input type="password" id="password" name="password" placeholder="Enter new password" required>

                
                <div class="button-container">
                        <button type="submit" id="cgpass-button">Change Password</button>
                    </div>
            </form>
        </div>
    </div>
    
</body>
</html>