<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KomentarJawaban extends Model
{
    protected $table = 'comment_answers';
    protected $guarded = [];
    public $timestamps = true;

    public function users()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function jawaban()
    {
        return $this->belongsTo('App\Jawaban', 'answer_id');
    }
}
