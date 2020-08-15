<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VoteJawaban extends Model
{
    protected $table = 'vote_answers';
    protected $guarded = [];
    public $timestamps = true;
}
