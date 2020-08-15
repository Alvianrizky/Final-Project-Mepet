<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pertanyaan;
use App\Jawaban;
use App\VoteJawaban;
use App\VoteJawabanDown;
use App\VotePertanyaan;
use App\VotePertanyaanDown;
use App\Profiles;
use Auth;

class JawabanController extends Controller
{
    public function store($id, Request $request)
    {

        $request->validate([
            'content' => 'required',
        ]);

        $pertanyaan = Pertanyaan::find($id);

        $komentar = $pertanyaan->jawaban()->create([
            'content' => $request['content'],
            'user_id' => Auth::id()
        ]);

        // dd($komentar);

        return redirect('/detail/'.$id);
    }

    public function edit($id)
    {
        $query = Jawaban::find($id);
        $data = [
            'query' => $query,
        ];
        return view('jawaban', $data);
    }

    public function update($id, Request $request)
    {
        $request->validate([
			'content' => 'required'
        ]);

        $query1 = Jawaban::where('id', $id)->first();

        $query = Jawaban::where('id', $id)->update([
			'content' => $request['content'],
        ]);

        return redirect('/detail/'.$query1->question_id);
    }

    public function destroy($id)
    {
        $query1 = Jawaban::where('id', $id)->first();
        $query = Jawaban::destroy($id);

        return redirect('/detail/'.$query1->question_id);
    }

    public function upper($id)
    {
        $where = [
            'user_id' => Auth::id(),
            'question_id' => $id
        ];
        $query = VotePertanyaan::where($where)->first();
        $query1 = Pertanyaan::where('id', $id)->first();
        $query2 = Profiles::where('user_id', $query1->user_id)->first();

        if(empty($query)) {
            $up = VotePertanyaan::create([
                'user_id' => Auth::id(),
                'question_id' => $id
            ]);
            $pertanyaan = Pertanyaan::where('id', $id)->update([
                'vote' => $query1->vote + 1,
            ]);
            $profile = Profiles::where('user_id', $query1->user_id)->update([
                'reputasi' => $query2->reputasi + 10,
            ]);
        } else {
            $up = VotePertanyaan::where($where)->delete();
            $pertanyaan = Pertanyaan::where('id', $id)->update([
                'vote' => $query1->vote - 1,
            ]);
            $profile = Profiles::where('user_id', $query1->user_id)->update([
                'reputasi' => $query2->reputasi - 10,
            ]);
        }

        return redirect('/detail/'.$id);
    }

    public function downper($id)
    {
        $where = [
            'user_id' => Auth::id(),
            'question_id' => $id
        ];
        $query = VotePertanyaanDown::where($where)->first();
        $query1 = Pertanyaan::where('id', $id)->first();
        $query2 = Profiles::where('user_id', $query1->user_id)->first();

        if(empty($query)) {
            if($query2->reputasi >= 15) {
                $down = VotePertanyaanDown::create([
                    'user_id' => Auth::id(),
                    'question_id' => $id
                ]);
                $pertanyaan = Pertanyaan::where('id', $id)->update([
                    'vote' => $query1->vote - 1,
                ]);
                $profile = Profiles::where('user_id', $query1->user_id)->update([
                    'reputasi' => $query2->reputasi - 1,
                ]);
            }
        } else {
            $down = VotePertanyaanDown::where($where)->delete();
            $pertanyaan = Pertanyaan::where('id', $id)->update([
                'vote' => $query1->vote + 1,
            ]);
            $profile = Profiles::where('user_id', $query1->user_id)->update([
                'reputasi' => $query2->reputasi + 1,
            ]);
        }

        return redirect('/detail/'.$id);
    }

    public function up($id)
    {
        $where = [
            'user_id' => Auth::id(),
            'answer_id' => $id
        ];
        $query = VoteJawaban::where($where)->first();
        $query1 = Jawaban::where('id', $id)->first();
        $query2 = Profiles::where('user_id', $query1->user_id)->first();

        if(empty($query)) {
            $up = VoteJawaban::create([
                'user_id' => Auth::id(),
                'answer_id' => $id
            ]);
            $jawaban = Jawaban::where('id', $id)->update([
                'vote' => $query1->vote + 1,
            ]);
            $profile = Profiles::where('user_id', $query1->user_id)->update([
                'reputasi' => $query2->reputasi + 10,
            ]);
        } else {
            $up = VoteJawaban::where($where)->delete();
            $jawaban = Jawaban::where('id', $id)->update([
                'vote' => $query1->vote - 1,
            ]);
            $profile = Profiles::where('user_id', $query1->user_id)->update([
                'reputasi' => $query2->reputasi - 10,
            ]);
        }

        return redirect('/detail/'.$query1->question_id);
    }

    public function down($id)
    {
        $where = [
            'user_id' => Auth::id(),
            'answer_id' => $id
        ];
        $query = VoteJawabanDown::where($where)->first();
        $query1 = Jawaban::where('id', $id)->first();
        $query2 = Profiles::where('user_id', $query1->user_id)->first();

        if(empty($query)) {
            if($query2->reputasi >= 15) {
                $down = VoteJawabanDown::create([
                    'user_id' => Auth::id(),
                    'answer_id' => $id
                ]);
                $jawaban = Jawaban::where('id', $id)->update([
                    'vote' => $query1->vote - 1,
                ]);
                $profile = Profiles::where('user_id', $query1->user_id)->update([
                    'reputasi' => $query2->reputasi - 1,
                ]);
            }
        } else {
            $down = VoteJawabanDown::where($where)->delete();
            $jawaban = Jawaban::where('id', $id)->update([
                'vote' => $query1->vote + 1,
            ]);
            $profile = Profiles::where('user_id', $query1->user_id)->update([
                'reputasi' => $query2->reputasi + 1,
            ]);
        }

        return redirect('/detail/'.$query1->question_id);
    }
}
