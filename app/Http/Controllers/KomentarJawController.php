<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\KomentarJawaban;
use App\Jawaban;
use Auth;

class KomentarJawController extends Controller
{
    public function store($id, Request $request)
    {

        $request->validate([
            'komentar_jaw' => 'required',
        ]);

        $jawaban = Jawaban::find($id);

        $komentar = $jawaban->komentar()->create([
            'content' => $request['komentar_jaw'],
            'user_id' => Auth::id()
        ]);

        // dd($komentar);

        return redirect('/detail/'.$jawaban->question_id);
    }

    public function edit($id)
    {
        $query = KomentarJawaban::find($id);
        $data = [
            'query' => $query,
            'komentar' => 'Jawaban'
        ];
        return view('komentar', $data);
    }

    public function update($id, Request $request)
    {
        $request->validate([
			'content' => 'required'
        ]);

        $query1 = KomentarJawaban::where('id', $id)->first();
        $query2 = Jawaban::where('id', $query1->answer_id)->first();

        $query = KomentarJawaban::where('id', $id)->update([
			'content' => $request['content'],
        ]);

        return redirect('/detail/'.$query2->question_id);
    }

    public function destroy($id)
    {
        $query1 = KomentarJawaban::where('id', $id)->first();
        $query2 = Jawaban::where('id', $query1->answer_id)->first();

        $query = KomentarJawaban::destroy($id);

        return redirect('/detail/'.$query2->question_id);
    }
}
