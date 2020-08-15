<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jawaban extends Model
{
    protected $table = 'answers';
    protected $guarded = [];
    public $timestamps = true;

    public function users()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function pertanyaan()
    {
        return $this->belongsTo('App\Pertanyaan', 'question_id');
    }

    public function komentar()
    {
        return $this->hasMany('App\KomentarJawaban', 'answer_id');
    }
}
