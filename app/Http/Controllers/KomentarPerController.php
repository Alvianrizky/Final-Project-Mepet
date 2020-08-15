<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\KomentarPertanyaan;
use App\Pertanyaan;
use Auth;

class KomentarPerController extends Controller
{
    public function store($id, Request $request)
    {

        $request->validate([
            'komentar_per' => 'required',
        ]);

        $pertanyaan = Pertanyaan::find($id);

        $komentar = $pertanyaan->komentarper()->create([
            'content' => $request['komentar_per'],
            'user_id' => Auth::id()
        ]);

        // dd($komentar);

        return redirect('/detail/'.$id);
    }

    public function edit($id)
    {
        $query = KomentarPertanyaan::find($id);
        $data = [
            'query' => $query,
            'komentar' => 'Pertanyaan'
        ];
        return view('komentar', $data);
    }

    public function update($id, Request $request)
    {
        $request->validate([
			'content' => 'required'
        ]);

        $query1 = KomentarPertanyaan::where('id', $id)->first();

        $query = KomentarPertanyaan::where('id', $id)->update([
			'content' => $request['content'],
        ]);

        return redirect('/detail/'.$query1->question_id);
    }

    public function destroy($id)
    {
        $query = KomentarPertanyaan::where('id', $id)->first();

        $query1 = KomentarPertanyaan::destroy($id);

        return redirect('/detail/'.$query->question_id);
    }
}
