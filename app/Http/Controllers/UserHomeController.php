<?php
namespace App\Http\Controllers;
use App\Models\DetailWawancara;
use App\Models\Gelombang;
use App\Models\Peserta;
use App\Models\Ruang;
use Illuminate\Http\Request;

class UserHomeController extends Controller
{
    public function index()
    {
    $id = session('id_pewawancara');

    $results = Gelombang::join('ruang_pewawancara', 'gelombang.id_gelombang', '=', 'ruang_pewawancara.id_gelombang')
    ->where('id_pewawancara', $id)
    ->where('ruang_pewawancara.status', '!=',0)
    ->join('ruang', 'ruang_pewawancara.id_ruang', '=', 'ruang.id_ruang')
    ->get();

    $pesertaPerGelombang = DetailWawancara::where('id_pewawancara', $id)
    ->where('detail_wawancara.status', '!=', 0)
    ->join('gelombang', 'detail_wawancara.id_gelombang', '=', 'gelombang.id_gelombang')
    ->join('peserta', 'detail_wawancara.no_peserta', '=', 'peserta.no_peserta')
    ->select(
        'detail_wawancara.*',
        'peserta.peserta as peserta_name',
        'peserta.prodi',
        'gelombang.gelombang_name',
        'gelombang.date as gelombang_date'
    )
    ->get()
    ->groupBy('id_gelombang');
    
    foreach ($pesertaPerGelombang as $gelombangId => $peserta) {
        $gelombang = Gelombang::find($gelombangId);
        foreach ($peserta as $p) {
            $p->gelombang_date = $gelombang->date;
            $p->status = $gelombang->status;
        }
    }

        $link = Ruang::all();
        $totalParticipants = Peserta::count(); 
        $totalZoomLinks = $link->count(); 
        $activeGelombang = Gelombang::where('status', true)->count(); 
        $link_detail = $results;
        return view('user', compact('link_detail', 'pesertaPerGelombang', 'totalParticipants', 'totalZoomLinks', 'activeGelombang'));

    }
    public function updateDetail(Request $request, $id)
    {
        $request->validate([
            'question1' => 'required|numeric|min:1|max:100',
            'question2' => 'required|numeric|min:1|max:100',
            'question3' => 'required|numeric|min:1|max:100',
            'question4' => 'required|string',
            'question5' => 'required|string',
        ]);

        $participant = Peserta::where('no_peserta', $id)->firstOrFail();

        $participant->update([
            'q1' => $request->input('question1'),
            'q2' => $request->input('question2'),
            'q3' => $request->input('question3'),
            'q4' => $request->input('question4'),
            'q5' => $request->input('question5'),
        ]);
        return redirect()->back()->with('success', 'Participant details updated successfully!');
    }
}