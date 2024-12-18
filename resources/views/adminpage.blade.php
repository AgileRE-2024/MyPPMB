<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" defer></script>
</head>
<body class="bg-gradient-to-r from-gray-100 via-gray-200 to-gray-100 h-screen flex">
    <!-- Sidebar -->
    <aside class="bg-blue-600 text-white w-64 flex flex-col shadow-lg">
        <h2 class="text-center text-2xl font-bold py-6 border-b border-blue-500">
            <i class="fas fa-cog mr-2"></i> Admin Panel
        </h2>
        <nav class="flex-1 px-4 space-y-4 mt-6">
            <a href="/home" class="flex items-center space-x-4 p-3 rounded-lg bg-blue-700 hover:bg-blue-800">
                <i class="fas fa-calendar-alt"></i>
                <span>Rekap Jadwal</span>
            </a>
            <a href="/format" class="flex items-center space-x-4 p-3 rounded-lg hover:bg-blue-700">
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
        <div class="container mx-auto max-w-7xl bg-white shadow rounded-lg p-6 space-y-6">
            <h1 class="text-3xl font-bold text-gray-800 text-center mb-6">Rekap Jadwal</h1>
            <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-blue-100 p-6 rounded-lg shadow-lg flex items-center space-x-4">
                    <i class="fas fa-database text-blue-600 text-3xl"></i>
                    <div>
                        <h3 class="text-xl font-bold text-gray-800">Total Gelombang</h3>
                        <p class="text-lg text-blue-600">{{ $totalGelombang }}</p>
                    </div>
                </div>
                <div class="bg-green-100 p-6 rounded-lg shadow-lg flex items-center space-x-4">
                    <i class="fas fa-check-circle text-green-600 text-3xl"></i>
                    <div>
                        <h3 class="text-xl font-bold text-gray-800">Active Gelombang</h3>
                        <p class="text-lg text-green-600">{{ $activeGelombang }}</p>
                    </div>
                </div>
                <div class="bg-yellow-100 p-6 rounded-lg shadow-lg flex items-center space-x-4">
                    <i class="fas fa-exclamation-circle text-yellow-600 text-3xl"></i>
                    <div>
                        <h3 class="text-xl font-bold text-gray-800">Inactive Gelombang</h3>
                        <p class="text-lg text-yellow-600">{{ $inactiveGelombang }}</p>
                    </div>
                </div>
                <div class="bg-purple-100 p-6 rounded-lg shadow-lg flex items-center space-x-4">
                    <i class="fas fa-file-import text-purple-600 text-3xl"></i>
                    <div>
                        <h3 class="text-xl font-bold text-gray-800">Imported Gelombang</h3>
                        <p class="text-lg text-purple-600">{{ $importedGelombang }}</p>
                    </div>
                </div>
            </section>
            <button 
                class="bg-gradient-to-r from-blue-500 to-blue-700 hover:from-blue-600 hover:to-blue-800 text-white py-3 px-6 rounded-lg mb-6 text-lg shadow-lg"
                onclick="addFileBlock()">
                <i class="fas fa-plus mr-2"></i> Tambah Jadwal
            </button>

            <div class="space-y-6">
                @foreach ($gelombangData as $jadwal)
                    <div class="bg-gradient-to-r from-gray-50 to-gray-100 p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                        <h3 class="font-medium text-gray-700 text-lg">
                            <span class="text-blue-500 font-bold">{{ $jadwal->gelombang_name }}</span> 
                            - {{ $jadwal->date }} - Gelombang {{ $jadwal->gelombang }} - Semester {{ $jadwal->semester }}
                        </h3>
                        <p class="text-sm text-gray-500 mt-2">
                            Status: 
                            <span class="font-semibold {{ $jadwal->file_path ? 'text-green-500' : 'text-red-500' }}">
                                {{ $jadwal->file_path ? 'Imported' : 'Not Imported' }}
                            </span>
                        </p>
                        <div class="flex items-center space-x-4 mt-4">
                            <form action="{{ route('delete.store', $jadwal->id_gelombang) }}" method="POST" class="inline-block">
                                @csrf
                                <button 
                                    type="submit" 
                                    class="bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded-lg shadow-md"
                                    onclick="return confirm('Are you sure you want to delete this item?')">
                                    Hapus
                                </button>
                            </form>
                            <form action="{{ route('gelombang.toggleStatus', $jadwal->id_gelombang) }}" method="POST" class="inline-block">
                                @csrf
                                <button type="submit" 
                                    class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded-lg shadow-md">
                                    {{ $jadwal->status ? 'Matikan' : 'Aktifkan' }}
                                </button>
                            </form>
                            <form action="{{ route('excel.import', $jadwal->id_gelombang) }}" method="POST" enctype="multipart/form-data" class="inline-block">
                                @csrf
                                <input type="hidden" name="id_gelombang" value="{{ $jadwal->id_gelombang }}">
                                <label class="inline-block">
                                    <input type="file" name="file4" class="block w-full border border-gray-300 rounded-lg py-2 px-4 mt-1 text-sm text-gray-600">
                                </label>
                                <button 
                                    type="submit" 
                                    class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg shadow-md mt-2">
                                    Import Data
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </main>

    <!-- Popup Form -->
    <div id="popup" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg space-y-6 w-full max-w-md">
            <h2 class="text-xl font-bold text-gray-800">Tambah Gelombang</h2>
            <form id="jadwalForm" action="{{ route('gelombang.store') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <label class="block">
                        <span class="text-gray-700 font-medium">Nama Gelombang</span>
                        <input type="text" id="gelombangName" name="gelombangName" class="w-full mt-1 rounded-lg border-gray-300">
                    </label>
                    <label class="block">
                        <span class="text-gray-700 font-medium">Tanggal</span>
                        <input type="date" id="date" name="date" class="w-full mt-1 rounded-lg border-gray-300">
                    </label>
                    <label class="block">
                        <span class="text-gray-700 font-medium">Jam</span>
                        <input type="time" id="time" name="time" class="w-full mt-1 rounded-lg border-gray-300">
                    </label>
                    <label class="block">
                        <span class="text-gray-700 font-medium">Gelombang</span>
                        <select id="gelombang" name="gelombang" class="w-full mt-1 rounded-lg border-gray-300">
                            <option value="1">Gelombang 1</option>
                            <option value="2">Gelombang 2</option>
                            <option value="2">Gelombang 3</option>
                        </select>
                    </label>
                    <label class="block">
                        <span class="text-gray-700 font-medium">Semester</span>
                        <select id="semester" name="semester" class="w-full mt-1 rounded-lg border-gray-300">
                            <option value="genap">Semester Genap</option>
                            <option value="ganjil">Semester Ganjil</option>
                        </select>
                    </label>
                </div>
                <div class="flex justify-end space-x-4 mt-4">
                    <button type="button" class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded-lg" onclick="closePopup()">Batal</button>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg">Tambah</button>
                </div>
            </form>
        </div>
    </div>

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
