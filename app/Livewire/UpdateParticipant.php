<?php
namespace App\Livewire;
use App\Models\DetailWawancara;
use Livewire\Component;
class UpdateParticipant extends Component
{
    public $peserta;
    public $q1, $q2, $q3, $q4, $q5;

    public function mount($peserta)
    {
        $this->peserta = DetailWawancara::join('peserta', 'detail_wawancara.no_peserta', '=', 'peserta.no_peserta')
        ->where('detail_wawancara.no_peserta', $this->peserta->no_peserta)
        ->where('detail_wawancara.id_pewawancara', $this->peserta->id_pewawancara)
        ->select('detail_wawancara.*', 'peserta.peserta as nama', 'peserta.prodi')
        ->firstOrFail();

    $this->namaPeserta = $this->peserta->nama;
    $this->prodiPeserta = $this->peserta->prodi;

    $this->q1 = $this->peserta->q1;
    $this->q2 = $this->peserta->q2;
    $this->q3 = $this->peserta->q3;
    $this->q4 = $this->peserta->q4;
    $this->q5 = $this->peserta->q5;
    }

    public function updateParticipant()
    {
        $this->validate([
            'q1' => 'required|numeric|min:1|max:100',
            'q2' => 'required|numeric|min:1|max:100',
            'q3' => 'required|numeric|min:1|max:100',
            'q4' => 'required|string',
            'q5' => 'required|string',
        ]);
    
        $this->peserta->update([
            'q1' => $this->q1,
            'q2' => $this->q2,
            'q3' => $this->q3,
            'q4' => $this->q4,
            'q5' => $this->q5,
            'completion' => true,
        ]);
    
        $this->peserta = DetailWawancara::join('peserta', 'detail_wawancara.no_peserta', '=', 'peserta.no_peserta')
            ->where('detail_wawancara.no_peserta', $this->peserta->no_peserta)
            ->where('detail_wawancara.id_pewawancara', $this->peserta->id_pewawancara)
            ->select('detail_wawancara.*', 'peserta.peserta as nama', 'peserta.prodi')
            ->firstOrFail();
    
        $this->namaPeserta = $this->peserta->nama;
        $this->prodiPeserta = $this->peserta->prodi;
    }
    public function render()
    {
        return view('livewire.update-participant', [
            'peserta' => $this->peserta,
        ]);
    }
}
