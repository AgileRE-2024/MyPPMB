<?php

namespace App\Http\Controllers;
use App\Models\DetailWawancara;
use App\Models\Gelombang;
use App\Models\Peserta;
use App\Models\Ruang;
use App\Models\Pewawancara;
use App\Models\ruang_pewawancara;
use Illuminate\Http\Request;

class HostController extends Controller
{
   public function index()
{
    $id = session('id_host');

    $results = Gelombang::join('ruang_host', 'gelombang.id_gelombang', '=', 'ruang_host.id_gelombang')
    ->where('id_host', $id)
    ->where('ruang_host.status', '!=',0)
    ->join('ruang', 'ruang_host.id_ruang', '=', 'ruang.id_ruang')
    ->get();

    return view('host', [
        'link_detail' => $results,
    ]);
    }
}