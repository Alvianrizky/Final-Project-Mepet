<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Profiles;
use Auth;

class ProfileController extends Controller
{
    public function create()
    {
        return view('profile');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required'
        ]);

        $pertanyaan = Profiles::create([
            'full_name' => $request['nama'],
            'user_id' => Auth::id()
        ]);

        return redirect('/');
    }
}
