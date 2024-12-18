<div class="block p-6 rounded-lg shadow-lg {{ $peserta->completion ? 'bg-green-100 border-green-400' : 'bg-gray-100 border-gray-200' }}">
    <h4 class="text-xl font-semibold text-gray-700 mb-4">
        {{ $peserta->no_peserta }} - {{ $peserta->nama }} - {{ $peserta->prodi }}
    </h4>

    <form wire:submit.prevent="updateParticipant" class="space-y-4">
        <div class="question">
            <label for="q1" class="block text-sm font-medium text-gray-600 mb-1">Motivasi:</label>
            <input type="number" id="q1" wire:model="q1" min="1" max="100" required 
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        </div>
        <div class="question">
            <label for="q2" class="block text-sm font-medium text-gray-600 mb-1">Kualitas Pra Proposal:</label>
            <input type="number" id="q2" wire:model="q2" min="1" max="100" required 
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        </div>
        <div class="question">
            <label for="q3" class="block text-sm font-medium text-gray-600 mb-1">Kemampuan Bidang Ilmu:</label>
            <input type="number" id="q3" wire:model="q3" min="1" max="100" required 
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        </div>
        <div class="question">
            <label for="q4" class="block text-sm font-medium text-gray-600 mb-1">Perlu Matrikulasi:</label>
            <select id="q4" wire:model="q4" required 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <option value="">Pilih</option>
                <option value="Ya">Ya</option>
                <option value="Tidak">Tidak</option>
            </select>
        </div>
        <div class="question">
            <label for="q5" class="block text-sm font-medium text-gray-600 mb-1">Catatan Wawancara:</label>
            <select id="q5" wire:model="q5" required 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <option value="">Pilih</option>
                <option value="Ya">Ya</option>
                <option value="Tidak">Tidak</option>
            </select>
        </div>
        <button id="simpan" type="submit" 
                class="w-full bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300">
            Simpan
        </button>
    </form>
</div>
