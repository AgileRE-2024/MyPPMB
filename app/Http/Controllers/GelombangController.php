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
        $jadwal = Gelombang::findOrFail($id_gelombang); 
        $jadwal->delete(); 
        return redirect()->back()->with('success', 'Jadwal deleted successfully');
    }
}
