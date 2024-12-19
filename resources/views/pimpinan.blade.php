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
            <a href="/pimpinan" class="flex items-center justify-center space-x-4 p-3 rounded-lg bg-blue-700 hover:bg-blue-800">
                <i class="fas fa-book"></i>
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
    <main class="flex-1 overflow-y-auto p-6">
        <div class="container mx-auto max-w-7xl bg-white shadow rounded-lg p-6 space-y-6">
            <section>
                <h2 class="text-xl font-bold text-gray-800 mb-4">Rekap Nilai</h2>
                <p class="text-sm text-gray-500 mb-6">
                    Below is the progress and details for each session. Use the buttons to view more details or download the reports.
                </p>
                <div class="space-y-6">
                    @foreach ($detail as $key => $det)
                        @php
                            $total = $det->first()->total_peserta;
                            $filled = $det->first()->sudah_terisi;
                            $notFilled = $det->first()->belum_terisi;
                            $percentage = ($filled / $total) * 100;
                            $isComplete = $percentage === 100;
                        @endphp
                        <div class="p-4 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300" 
                            style="background-color: {{ $isComplete ? '#d4edda' : '#f8d7da' }};">
                            <div class="flex justify-between items-center">
                                <h3 class="font-medium text-gray-700">
                                    {{ $det->first()->gelombang_name }} - {{ $det->first()->date }}
                                </h3>
                                <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $isComplete ? 'bg-green-500 text-white' : 'bg-red-500 text-white' }}">
                                    {{ $isComplete ? 'Complete' : 'Ongoing' }}
                                </span>
                            </div>
                            <div class="mt-2 w-full bg-gray-200 rounded-full h-4">
                                <div 
                                    class="bg-blue-500 h-4 rounded-full text-center text-xs text-white" 
                                    style="width: {{ $percentage }}%;">
                                    {{ number_format($percentage, 0) }}%
                                </div>
                            </div>
                            <div class="flex space-x-4 mt-4">
                                <button 
                                    class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg text-center"
                                    onclick="toggleGelombang(this)">
                                    View Details
                                </button>
                                <a href="{{ route('download', $key) }}" class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded-lg text-center">
                                    Download
                                </a>
                            </div>
                            <!-- Hidden Content -->
                            <div class="mt-4 space-y-4 gelombang-content hidden">
                                <p>Total: {{ $total }} - Status: {{ $filled }} filled / {{ $notFilled }} not filled</p>
                                <div class="space-y-4">
                                    @foreach ($det as $d)
                                        <div class="p-4 rounded-lg shadow-sm border" 
                                            style="background-color: {{ $d->completion == 1 ? 'rgba(144, 238, 144, 0.5)' : 'rgba(255, 182, 193, 0.5)' }};">
                                            <h4>{{ $d->no_peserta }} - {{ $d->peserta }} - {{ $d->prodi }} - {{ $d->pewawancara_name }}</h4>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        </div>
    </main>

    <script>
        function toggleGelombang(buttonElement) {
            const contentElement = buttonElement.parentElement.nextElementSibling;
            if (contentElement.classList.contains('hidden')) {
                contentElement.classList.remove('hidden');
            } else {
                contentElement.classList.add('hidden');
            }
        }
    </script>
    @livewireScripts
</body>
</html>
