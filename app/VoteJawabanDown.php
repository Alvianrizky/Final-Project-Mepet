<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VoteJawabanDown extends Model
{
    protected $table = 'vote_answer_down';
    protected $guarded = [];
    public $timestamps = true;
}
