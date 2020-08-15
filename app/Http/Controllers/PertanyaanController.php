<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Pertanyaan;
use App\Jawaban;
use App\VotePertanyaan;
use App\VotePertanyaanDown;
use App\VoteJawaban;
use App\VoteJawabanDown;
use App\Profiles;
use App\Tag;
use Auth;

class PertanyaanController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function index()
    {
        $pertanyaan = Pertanyaan::orderBy('id', 'desc')->get();

        $data = [
            'pertanyaan' => $pertanyaan
        ];

        return view('index', $data);
    }

    public function create()
    {
        $data = ['pertanyaan' => 'form'];
        return view('form', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'tag' => 'required'
        ]);

        $tags_arr = explode(',', $request['tag']);

        // dd($tags_arr);

        $tag_id = [];
        foreach($tags_arr as $key)
        {
            $tag = Tag::where('tag_name', $key)->first();
            if(!empty($tag))
            {
                $tag_id[] = $tag->id;
            } else {
                $new_tag = Tag::create(['tag_name' => $key]);
                $tag_id[] = $new_tag->id;
            }
        }

        $pertanyaan = Pertanyaan::create([
            'title' => $request['title'],
            'content' => $request['content'],
            'user_id' => Auth::id()
        ]);

        $pertanyaan->tags()->sync($tag_id);

        return redirect('/');
    }

    public function show($id)
    {
        $pertanyaan = Pertanyaan::find($id);

        $komentar = Pertanyaan::find($id)->komentarper;
        $jawaban = Pertanyaan::find($id)->jawaban;

        $data = [
            'pertanyaan' => $pertanyaan,
            'komentar' => $komentar,
            'jawaban' => $jawaban
        ];

        return view('detail', $data);
    }

    public function edit($id)
    {
        $query = Pertanyaan::find($id);
        $data = [
            'query' => $query,
            'pertanyaan' => 'Pertanyaan'
        ];
        return view('form', $data);
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'title' => 'required',
			'content' => 'required'
        ]);

        $query = Pertanyaan::where('id', $id)->update([
            'title'=> $request['title'],
			'content' => $request['content'],
        ]);

        return redirect('/detail/'.$id);
    }

    public function destroy($id)
    {
        $query1 = Pertanyaan::destroy($id);

        return redirect('/');
    }

    public function jawaban($id)
    {
        $query1 = Jawaban::find($id);
        $query = Pertanyaan::where('id', $query1->question_id)->update([
            'answer_right_id'=> $id,
        ]);

        return redirect('/detail/'.$query1->question_id);
    }

    public function up($id)
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

        return redirect('/');
    }

    public function down($id)
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

        return redirect('/');
    }
}
