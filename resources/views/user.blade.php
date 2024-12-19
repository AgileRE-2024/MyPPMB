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
        <div class="container mx-auto max-w-7xl bg-white shadow rounded-lg p-6 space-y-8">
            <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                
            <div class="bg-blue-100 p-6 rounded-lg shadow-lg flex items-center space-x-4">
                    <i class="fas fa-user text-blue-600 text-3xl"></i>
                    <div>
                        <h3 class="text-xl font-bold text-gray-800">Total Peserta</h3>
                        <p class="text-lg text-blue-600">{{ $totalParticipants }}</p>
                    </div>
                </div>
                <div class="bg-green-100 p-6 rounded-lg shadow-lg flex items-center space-x-4">
                    <i class="fas fa-video text-green-600 text-3xl"></i>
                    <div>
                        <h3 class="text-xl font-bold text-gray-800">Total Ruang Zoom</h3>
                        <p class="text-lg text-green-600">{{ $totalZoomLinks }}</p>
                    </div>
                </div>
                <div class="bg-yellow-100 p-6 rounded-lg shadow-lg flex items-center space-x-4">
                    <i class="fas fa-clock text-yellow-600 text-3xl"></i>
                    <div>
                        <h3 class="text-xl font-bold text-gray-800">Gelombang Aktif</h3>
                        <p class="text-lg text-yellow-600">{{ $activeGelombang }}</p>
                    </div>
            </div>

            </section>

            <section>
                <h2 class="text-xl font-bold text-gray-800 mb-4">Daftar Ruang Zoom</h2>
                <div class="space-y-4">
                    @foreach ($link_detail as $link => $detail)
                        <div class="flex items-center justify-between bg-gray-50 p-4 rounded-lg shadow-sm hover:bg-blue-50 transition">
                            <h3 class="font-medium text-gray-700">{{ $detail->gelombang_name }} - {{ $detail->date }}</h3>
                            <button 
                                class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg"
                                onclick="enterZoom('{{ $detail->link_ruang }}')"
                            >
                                Masuk Ruang Zoom
                            </button>
                        </div>
                    @endforeach
                </div>
            </section>

            <section>
                <h2 class="text-xl font-bold text-gray-800 mb-4">Daftar Peserta Berdasarkan Gelombang</h2>
                <div class="space-y-6">
                    @foreach ($pesertaPerGelombang as $gelombangasek => $pesertas)
                        <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                            <h3 
                                class="font-medium text-gray-700 flex justify-between items-center cursor-pointer"
                                onclick="toggleGelombang(this.nextElementSibling)">
                                {{ $pesertas->first()->gelombang_name }} - {{ $pesertas->first()->gelombang_date }}
                                <span class="text-sm text-gray-500">&#9660;</span>
                            </h3>
                            <div class="gelombang-content hidden mt-4 space-y-4">
                                @foreach ($pesertas as $peserta)
                                    <div class="block bg-white border rounded-lg shadow-sm p-4">
                                        <livewire:update-participant :peserta="$peserta" />
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        </div>
    </main>

    <script>
        function toggleGelombang(contentElement) {
            if (contentElement.style.display === 'none' || !contentElement.style.display) {
                contentElement.style.display = 'block';
            } else {
                contentElement.style.display = 'none';
            }
        }

        function enterZoom(links) {
            let link = links;
            if (!/^https?:\/\//i.test(link)) {
                link = 'http://' + link; 
            }
            window.open(link, '_blank');
        }
    </script>
    @livewireScripts
</body>
</html>
