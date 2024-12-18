<!DOCTYPE html>
<html lang="en">
<head>
    @livewireStyles
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" defer></script>
</head>
<body class="bg-gray-100 h-screen flex">
    <!-- Sidebar -->
    <aside class="bg-blue-600 text-white w-64 flex flex-col shadow-lg">
    <h2 class="text-center text-2xl font-bold py-6 border-b border-blue-500">
            <i class="fas fa-cog mr-2"></i> Admin Panel
        </h2>
        <nav class="flex-1 px-4 space-y-4 mt-6">
            <a href="/home" class="flex items-center space-x-4 p-3 rounded-lg hover:bg-blue-700">
                <i class="fas fa-calendar-alt"></i>
                <span>Rekap Jadwal</span>
            </a>
            <a href="/format" class="flex items-center space-x-4 p-3 rounded-lg hover:bg-blue-700">
                <i class="fas fa-file-alt"></i>
                <span>Format Jadwal</span>
            </a>
            <a href="/nilai" class="flex items-center space-x-4 p-3 rounded-lg bg-blue-700 hover:bg-blue-700">
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
        <div class="container mx-auto max-w-6xl bg-white shadow rounded-lg p-6 space-y-6">
            <h2 class="text-xl font-bold text-gray-800">Rekap Nilai</h2>
            @foreach ($detail as $key => $det)
            <div class="gelombang-block border-b border-gray-200 pb-4">
                <!-- Gelombang Header -->
                <div class="gelombang-header flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-700">
                            {{ $det->first()->gelombang_name }} - {{ $det->first()->date }}
                        </h3>
                        <p class="text-sm text-gray-500">
                            Total: {{ $det->first()->total_peserta }} - Status: 
                            <span class="text-green-600 font-semibold">{{ $det->first()->sudah_terisi }}</span> /
                            <span class="text-red-600 font-semibold">{{ $det->first()->belum_terisi }}</span>
                        </p>
                    </div>
                    <button 
                        class="toggle-button bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg"
                        onclick="toggleGelombang(this)">
                        Details
                    </button>
                </div>

                <!-- Gelombang Content -->
                <div class="gelombang-content mt-4 hidden space-y-4">
                    @foreach ($det as $d)
                    <div class="block p-4 rounded-lg shadow-sm transition-shadow duration-300 
                                {{ $d->completion == 1 ? 'bg-green-100' : 'bg-red-100' }}">
                        <h4 class="text-gray-700 font-medium">
                            {{ $d->no_peserta }} - {{ $d->peserta }} - {{ $d->prodi }} - {{ $d->pewawancara_name }}
                        </h4>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
    </main>

    <script>
        function toggleGelombang(button) {
            const gelombangContent = button.parentElement.nextElementSibling; 
            if (gelombangContent.classList.contains('hidden')) {
                gelombangContent.classList.remove('hidden');
            } else {
                gelombangContent.classList.add('hidden');
            }
        }
    </script>

    @livewireScripts
</body>
</html>
