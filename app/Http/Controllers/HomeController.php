<?php

namespace App\Http\Controllers;
use App\Models\DetailWawancara;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ParticipantsImport;
use App\Exports\ScheduleExport;
use App\Models\Schedule;
use App\Models\Gelombang;
use App\Exports\GelombangDetailExport;

class HomeController extends Controller
{
    public function index()
    {
        $totalGelombang = Gelombang::count(); // Count total gelombang
        $activeGelombang = Gelombang::where('status', true)->count(); // Count active gelombang
        $inactiveGelombang = Gelombang::where('status', false)->count(); // Count inactive gelombang
        $importedGelombang = Gelombang::whereNotNull('file_path')->count(); // Count gelombang with imported files
    
        $gelombangData = Gelombang::all(); // Replace with your actual query
    
        // Pass variables to the view
        return view('adminpage', compact(
            'totalGelombang',
            'activeGelombang',
            'inactiveGelombang',
            'importedGelombang',
            'gelombangData'
        ));
    }
    public function processParticipants(Request $request)
    {
        $request->validate([
            'participants_file' => 'required|file|mimes:xlsx,xls,csv',
        ]);

        $file = $request->file('participants_file');

        try {
            $participants = Excel::toArray(new ParticipantsImport, $file)[0];
            $scheduleData = $this->generateSchedule($participants);
            return Excel::download(new ScheduleExport($scheduleData), 'schedule.xlsx');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    private function generateSchedule(array $participants)
    {
        $schedule = [];
        $groupSize = 5; 

        foreach (array_chunk($participants, $groupSize) as $index => $group) {
            $schedule[] = [
                'session' => 'Sesi ' . ($index + 1),
                'participants' => implode(', ', array_column($group, 'name')),
                'time' => '08:00 - 09:00', // Contoh waktu, bisa dimodifikasi sesuai kebutuhan
            ];
        }
        return $schedule;
    }

    public function nilai()
    {
        $detail = DetailWawancara::join('peserta', 'detail_wawancara.no_peserta', '=', 'peserta.no_peserta')
        ->join('gelombang', 'detail_wawancara.id_gelombang', '=', 'gelombang.id_gelombang')
        ->join('pewawancara','detail_wawancara.id_pewawancara','=','pewawancara.id_pewawancara')
        ->get()
        ->groupBy('id_gelombang'); 


        foreach ($detail as $gelombangId => $items) {
            $totalPeserta = $items->count();
            $sudahTerisi = $items->where('completion', 1)->count();
            $belumTerisi = $items->where('completion', 0)->count();
            $persentaseTerisi = $totalPeserta > 0 ? round(($sudahTerisi / $totalPeserta) * 100, 2) : 0;
    
            foreach ($items as $item) {
                $item->total_peserta = $totalPeserta;
                $item->sudah_terisi = $sudahTerisi;
                $item->belum_terisi = $belumTerisi;
                $item->persentase_terisi = $persentaseTerisi;
            }
        }
        session(['detail' => $detail]);
        return view('nilai', ['detail' => $detail]);
    }
    public function download($id_gelombang)
    {
    return Excel::download(new GelombangDetailExport($id_gelombang), 'gelombang_'.$id_gelombang.'_details.xlsx');
    }

    public function pimpinan(){
        $pimpinan = DetailWawancara::join('peserta', 'detail_wawancara.no_peserta', '=', 'peserta.no_peserta')
        ->join('gelombang', 'detail_wawancara.id_gelombang', '=', 'gelombang.id_gelombang')
        ->join('pewawancara','detail_wawancara.id_pewawancara','=','pewawancara.id_pewawancara')
        ->get()
        ->groupBy('id_gelombang'); 

        foreach ($pimpinan as $gelombangId => $items) {
            $totalPeserta = $items->count();
            $sudahTerisi = $items->where('completion', 1)->count();
            $belumTerisi = $items->where('completion', 0)->count();
            $persentaseTerisi = $totalPeserta > 0 ? round(($sudahTerisi / $totalPeserta) * 100, 2) : 0;
    
            foreach ($items as $item) {
                $item->total_peserta = $totalPeserta;
                $item->sudah_terisi = $sudahTerisi;
                $item->belum_terisi = $belumTerisi;
                $item->persentase_terisi = $persentaseTerisi;
            }
        }
        session(['detail' => $pimpinan]);
        return view('pimpinan', ['detail' => $pimpinan]);

    }

    public function format()
    {
        return view('format');
    }

}
