<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" defer></script>
</head>
<body class="bg-gradient-to-r from-blue-50 to-blue-100 h-screen flex">
    <!-- Sidebar -->
    <aside class="bg-blue-600 text-white w-64 flex flex-col shadow-lg">
        <h2 class="text-center text-2xl font-bold py-6 border-b border-blue-500">
            <i class="fas fa-cog mr-2"></i> Admin Panel
        </h2>
        <nav class="flex-1 px-4 space-y-4 mt-6">
            <a href="/home" class="flex items-center space-x-4 p-3 rounded-lg hover:bg-blue-800">
                <i class="fas fa-calendar-alt"></i>
                <span>Rekap Jadwal</span>
            </a>
            <a href="/format" class="flex items-center space-x-4 p-3 rounded-lg bg-blue-700 hover:bg-blue-700">
                <i class="fas fa-file-alt"></i>
                <span>Format Jadwal</span>
            </a>
            <a href="/nilai" class="flex items-center space-x-4 p-3 rounded-lg hover:bg-blue-700">
                <i class="fas fa-chart-bar"></i>
                <span>Rekap Nilai</span>
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

    <!-- Main Content -->
    <main class="flex-1 overflow-y-auto p-6">
        <div class="container mx-auto max-w-5xl bg-white shadow rounded-lg p-6 space-y-6">
            <h1 class="text-3xl font-bold text-gray-800 text-center mb-6">Upload Format Jadwal</h1>
            
            <div class="bg-gray-50 p-6 rounded-lg shadow-md">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Upload File Format</h3>
                <form action="{{ route('excel.merge') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div class="relative">
                            <label for="file1" class="block text-sm font-medium text-gray-700">Data Peserta</label>
                            <div class="flex items-center mt-2">
                                <i class="fas fa-user-graduate text-blue-500 text-xl mr-3"></i>
                                <input type="file" name="file1" id="file1" required
                                       class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>
                        <div class="relative">
                            <label for="file2" class="block text-sm font-medium text-gray-700">Data Pewawancara</label>
                            <div class="flex items-center mt-2">
                                <i class="fas fa-chalkboard-teacher text-green-500 text-xl mr-3"></i>
                                <input type="file" name="file2" id="file2" required
                                       class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500">
                            </div>
                        </div>
                        <div class="relative">
                            <label for="file3" class="block text-sm font-medium text-gray-700">Data Host Zoom</label>
                            <div class="flex items-center mt-2">
                                <i class="fas fa-video text-purple-500 text-xl mr-3"></i>
                                <input type="file" name="file3" id="file3" required
                                       class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-purple-500 focus:border-purple-500">
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-6 rounded-lg text-lg">
                            Buat Format
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script>
        function addFileBlock() {
            document.getElementById('popup').classList.remove('hidden');
        }

        function closePopup() {
            document.getElementById('popup').classList.add('hidden');
        }
    </script>
</body>
</html>
