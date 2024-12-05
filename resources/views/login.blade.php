<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #3b82f6;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            width: 350px; 
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .login-container h2 {
            margin-bottom: 20px;
            color: #333;
            text-align: center;
            font-size: 1.8rem;
            position: relative;
        }

        .login-container h2 i {
            color: #007BFF;
            margin-right: 8px;
            font-size: 1.5rem;
        }

        .login-container div {
            margin-bottom: 20px;
            position: relative;
        }

        .login-container label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            text-align: left;
        }

        .login-container input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 30px;
            box-sizing: border-box;
            transition: border-color 0.3s, box-shadow 0.3s;
            font-size: 1rem;
        }

        .login-container input:focus {
            border-color: #007BFF;
            box-shadow: 0 0 8px rgba(0, 123, 255, 0.2);
            outline: none;
        }

        .login-container input::placeholder {
            color: #aaa;
        }

        .login-container button {
            width: 100%;
            padding: 12px;
            background-color: #007BFF;
            border: none;
            border-radius: 30px;
            color: #fff;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
        }

        .login-container button:hover {
            background-color: #0056b3;
            transform: scale(1.02);
        }

        .login-container button:active {
            transform: scale(1);
        }

        .login-container::before {
            content: "";
            position: absolute;
            width: 150%;
            height: 150%;
            background-color: rgba(0, 123, 255, 0.1);
            top: -50%;
            left: -50%;
            transform: rotate(45deg);
            z-index: -1;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2><i class="fas fa-sign-in-alt"></i>Login</h2>
        <form id="loginForm" action="{{ route('login') }}" method="POST">
            @csrf
            <div>
            <label for="username">Username</label>
            <input type="text" id="username" name="username" placeholder="Enter your username" required>
            </div>
            <div>
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" required>
            </div>
            <div>
            <button type="submit">Login</button>
            </div>
        </form>
    </div>
</body>
</html>
