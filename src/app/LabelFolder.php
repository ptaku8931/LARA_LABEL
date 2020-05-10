<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LabelFolder extends Model
{
    protected $fillable = [
        'user_id', 'title'
    ];

    public function labels() {
        return $this->hasMany('App\Label');
    }
}



