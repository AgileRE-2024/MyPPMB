<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Gelombang;

class GelombangController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'gelombangName' => 'required|string|max:255',
            'date' => 'required|date',
            'gelombang' => 'required|integer',
            'semester' => 'required|string',
        ]);

        Gelombang::create([
            'gelombang_name' => $request->input('gelombangName'),
            'date' => $request->input('date'),
            'gelombang' => $request->input('gelombang'),
            'semester' => $request->input('semester'),
        ]);
        return redirect()->back()->with('success', 'Gelombang created successfully!');
    }
    public function destroy($id_gelombang)
    {
        \DB::transaction(function () use ($id_gelombang) {

            \DB::table('detail_wawancara')->where('id_gelombang', $id_gelombang)->delete();
            \DB::table('ruang_host')->where('id_gelombang', $id_gelombang)->delete();
            \DB::table('ruang_pewawancara')->where('id_gelombang', $id_gelombang)->delete();
            
            Gelombang::where('id_gelombang', $id_gelombang)->delete();
    
            $unusedRuang = \DB::table('ruang')
                ->leftJoin('ruang_pewawancara', 'ruang.id_ruang', '=', 'ruang_pewawancara.id_ruang')
                ->whereNull('ruang_pewawancara.id_ruang') 
                ->pluck('ruang.id_ruang');
    
            \DB::table('ruang')->whereIn('id_ruang', $unusedRuang)->delete();

            $unusedHost = \DB::table('host')
                ->leftJoin('ruang_host', 'host.id_host', '=', 'ruang_host.id_host')
                ->whereNull('ruang_host.id_host') 
                ->pluck('host.id_host');
    
            \DB::table('host')->whereIn('id_host', $unusedHost)->delete();

            $unusedPeserta = \DB::table('peserta')
                ->leftJoin('detail_wawancara', 'peserta.no_peserta', '=', 'detail_wawancara.no_peserta')
                ->whereNull('detail_wawancara.no_peserta') 
                ->pluck('peserta.no_peserta');
    
            \DB::table('peserta')->whereIn('no_peserta', $unusedPeserta)->delete();
    
            $unusedPewawancara = \DB::table('pewawancara')
                ->leftJoin('detail_wawancara', 'pewawancara.id_pewawancara', '=', 'detail_wawancara.id_pewawancara')
                ->whereNull('detail_wawancara.id_pewawancara') 
                ->pluck('pewawancara.id_pewawancara');
    
            \DB::table('pewawancara')->whereIn('id_pewawancara', $unusedPewawancara)->delete();


        });
    
        return redirect()->back()->with('success', 'Gelombang and all related records deleted successfully!');
    }
    

    public function toggleStatus($id)
    {
        $gelombang = Gelombang::findOrFail($id);
        $newStatus = !$gelombang->status; 
    
        \DB::transaction(function () use ($gelombang, $newStatus) {
            $gelombang->status = $newStatus; 
            $gelombang->save();
       
            \DB::table('detail_wawancara')
                ->where('id_gelombang', $gelombang->id_gelombang)
                ->update(['status' => $newStatus]);
    
            \DB::table('ruang_host')
                ->where('id_gelombang', $gelombang->id_gelombang)
                ->update(['status' => $newStatus]);
    
            \DB::table('ruang_pewawancara')
                ->where('id_gelombang', $gelombang->id_gelombang)
                ->update(['status' => $newStatus]);
        });
        return redirect()->back()->with('success', 'Gelombang status and related statuses updated successfully!');
    }
    
    
}
