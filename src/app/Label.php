<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Label extends Model
{
    protected $fillable = [
        'label_folder_id', 'title', 'text', 'url', 'color'
    ];
}
