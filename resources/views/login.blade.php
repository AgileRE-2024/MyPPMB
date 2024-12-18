<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-blue-500 flex items-center justify-center min-h-screen bg-cover bg-center relative" style="background-image: url('https://unair.ac.id/wp-content/uploads/2016/02/Top-500-1.jpg');">
    <div class="absolute inset-0 bg-blue-500 opacity-75"></div>

    <div class="bg-white bg-opacity-90 backdrop-blur-sm p-8 rounded-lg shadow-lg w-full max-w-md relative z-10">
        <div class="absolute inset-0 transform rotate-45 bg-blue-100 opacity-10 -z-10"></div>
        
        <h2 class="text-2xl font-bold text-gray-700 text-center flex items-center justify-center mb-6">
            <i class="fas fa-sign-in-alt text-blue-500 mr-2"></i> MyPPMB Login
        </h2>
        
        @if($errors->has('login_error'))
            <div class="bg-red-100 text-red-600 p-3 rounded-md text-sm mb-4">
                {{ $errors->first('login_error') }}
            </div>
        @endif

        <form id="loginForm" action="{{ route('login') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label for="username" class="block text-sm font-medium text-gray-700 mb-2">Username</label>
                <input 
                    type="text" 
                    id="username" 
                    name="username" 
                    placeholder="Enter your username" 
                    required
                    class="w-full px-4 py-3 border rounded-lg text-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-500"
                >
            </div>
            
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    placeholder="Enter your password" 
                    required
                    class="w-full px-4 py-3 border rounded-lg text-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-500"
                >
            </div>

            <div>
                <button 
                    type="submit" 
                    class="w-full bg-blue-500 text-white py-3 rounded-lg text-sm font-medium hover:bg-blue-600 transition-transform transform hover:scale-105"
                >
                    Login
                </button>
            </div>
        </form>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
</body>
</html>
