<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable=['l_id',
        'title',
        'description',
        't_id',
        'type',
        'area',
    ];

    protected $primaryKey = 'l_id';
    public $incrementing = false;
    protected $keyType = 'string';
}
