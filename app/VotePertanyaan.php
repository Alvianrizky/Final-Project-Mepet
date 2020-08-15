<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VotePertanyaan extends Model
{
    protected $table = 'vote_questions';
    protected $guarded = [];
    public $timestamps = true;
}
