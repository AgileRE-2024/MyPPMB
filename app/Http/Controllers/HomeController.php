<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ParticipantsImport;
use App\Exports\ScheduleExport;
use App\Models\Schedule;
use App\Models\Gelombang;

class HomeController extends Controller
{
    public function index()
    {
        $gelombangData = Gelombang::all();
        return view('adminpage', compact('gelombangData'));
    }

    public function processParticipants(Request $request)
    {
        // Validasi file yang diupload
        $request->validate([
            'participants_file' => 'required|file|mimes:xlsx,xls,csv',
        ]);

        // Mengambil file yang diupload
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
        $groupSize = 5; // Misalnya, 5 peserta per sesi

        foreach (array_chunk($participants, $groupSize) as $index => $group) {
            $schedule[] = [
                'session' => 'Sesi ' . ($index + 1),
                'participants' => implode(', ', array_column($group, 'name')),
                'time' => '08:00 - 09:00', // Contoh waktu, bisa dimodifikasi sesuai kebutuhan
            ];
        }

        return $schedule;
    }
}
