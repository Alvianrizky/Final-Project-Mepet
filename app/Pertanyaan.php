<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pertanyaan extends Model
{
    protected $table = 'questions';
    protected $guarded = [];
    public $timestamps = true;

    public function tags()
    {
        return $this->belongsToMany('App\Tag', 'tag_questions', 'question_id', 'tag_id');
    }

    public function users()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function komentarper()
    {
        return $this->hasMany('App\KomentarPertanyaan', 'question_id');
    }

    public function jawaban()
    {
        return $this->hasMany('App\Jawaban', 'question_id');
    }
}
