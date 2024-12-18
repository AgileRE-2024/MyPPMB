<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" defer></script>
</head>
<body class="bg-gray-100 h-screen flex">
    <aside class="bg-blue-600 text-white w-64 flex flex-col shadow-lg">
        <h2 class="text-center text-2xl font-bold py-6 border-b border-blue-500">
            <i class="fas fa-comments mr-2"></i> MyPPMB
        </h2>
        <nav class="flex-1 px-4 space-y-4 mt-6">
            <a href="/userhome" class="flex items-center space-x-4 p-3 rounded-lg bg-blue-700 hover:bg-blue-800">
                <i class="fas fa-video"></i>
                <span>Ruang Zoom</span>
            </a>
        </nav>
        <form action="{{ route('logout') }}" method="POST" class="mt-auto p-4">
            @csrf
            <button type="submit" class="w-full bg-red-500 hover:bg-red-600 py-2 rounded-lg text-center flex items-center justify-center space-x-2">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </button>
        </form>
    </aside>
    <main class="flex-1 overflow-y-auto p-6">
        <div class="container mx-auto max-w-7xl bg-white shadow rounded-lg p-6 space-y-6">
            <div class="grid grid-cols-1 gap-6">
                <div class="bg-gray-50 p-4 rounded-lg shadow-md flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-gray-700">Total Zoom Links</h3>
                        <p class="text-sm text-gray-500">All active Zoom links</p>
                    </div>
                    <span class="text-blue-500 text-2xl font-bold">{{ count($link_detail) }}</span>
                </div>
                
            </div>
            
            <h2 class="text-xl font-bold text-gray-800">Daftar Link Zoom</h2>
            <p class="text-sm text-gray-500 mb-4">
                Below is a list of active Zoom links for different sessions. Click "Masuk Ruang Zoom" to join.
            </p>
            
            <div class="space-y-6">
                @foreach ($link_detail as $link => $detail)
                    <div class="bg-gray-50 p-4 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300">
                        <h3 class="font-medium text-gray-700">
                            <span class="text-blue-500 font-bold">{{ $detail->gelombang_name }}</span> 
                            - {{ $detail->date }}
                        </h3>
                        <div class="flex items-center space-x-4 mt-2">
                            <span class="text-xs font-semibold text-gray-500 bg-green-100 text-green-500 px-2 py-1 rounded-full">
                                Active
                            </span>
                            <button 
                                class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg text-center"
                                onclick="enterZoom('{{ $detail->link_ruang }}')">
                                Masuk Ruang Zoom
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </main>

    <script>
        function enterZoom(link) {
            if (!/^https?:\/\//i.test(link)) {
                link = 'http://' + link; 
            }
            window.open(link, '_blank');
        }
    </script>
</body>
</html>
