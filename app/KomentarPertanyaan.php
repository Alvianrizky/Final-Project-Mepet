<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KomentarPertanyaan extends Model
{
    protected $table = 'comment_questions';
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
}
