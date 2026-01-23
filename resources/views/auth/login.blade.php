<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Loan App</title>
    <style>
        body { font-family: sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; background-color: #f3f4f6; }
        .login-card { background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); width: 300px; }
        .form-group { margin-bottom: 1rem; }
        label { display: block; margin-bottom: .5rem; font-weight: bold; }
        input { width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 4px; box-sizing: border-box; }
        button { width: 100%; padding: 0.75rem; background-color: #2563eb; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; }
        button:hover { background-color: #1d4ed8; }
        .error { color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem; }
    </style>
</head>
<body>
    <div class="login-card">
        <h2 style="text-align: center; margin-top: 0;">Login</h2>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" value="developer" required autofocus>
                @error('username')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
                <small>Copy the password - Test@Password123# <br> (for testing purpose only)</small>
                @error('password')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit">Log in</button>
        </form>
    </div>
</body>
</html>
