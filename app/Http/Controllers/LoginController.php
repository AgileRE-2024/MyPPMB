<?php

namespace App\Http\Controllers;

use App\Models\Ruang;
use App\Models\Admin;
use App\Models\Pimpinan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Peserta;
use App\Models\Gelombang;
use App\Models\Host;
use App\Models\Pewawancara;

class LoginController extends Controller
{
    public function index(){
        return view('login');
    }
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $username = $request->input('username');
        $password = $request->input('password');

        $user = Admin::where( 'username', $username)->first();
        $pass = Admin::where( 'password', $password)->first();

        if ($user && $pass) {
            return redirect('/home');
        }

        $user = Pewawancara::where( 'id_pewawancara', $username)->first();
        $pass = Pewawancara::where( 'password', $password)->first();

        if ($user && $pass) {
            session([
                'id_pewawancara' => $user->id_pewawancara,
            ]);
            return redirect('/userhome');
        }

        $user = Host::where( 'id_host', $username)->first();
        $pass = Host::where( 'pass_zoom', $password)->first();

        if ($user && $pass) {
            session([
                'id_host' => $user -> id_host,
            ]);
            return redirect('/host');
        }

        $user = Pimpinan::where( 'id_pimpinan', $username)->first();
        $pass = Pimpinan::where( 'password', $password)->first();

        if ($user && $pass) {
            session([
                    'id_pimpinan' => $user -> id_pimpinan,
            ]);
            return redirect('/pimpinan');
        }

    return redirect()->back()->withErrors(['login_error' => 'Invalid username or password.']);
    }
    public function logout()
    {
        session()->flush();
        return redirect('/')->with('message', 'You have been logged out.');
    }
}
