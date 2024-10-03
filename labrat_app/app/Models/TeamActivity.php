<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class TeamActivity extends Model
{
    use HasFactory;
//    protected $dates = ['created_at', 'updated_at'];
    protected $table = 'activity_team';

    protected $fillable = [
        'l_id',
        'title',
        'text',
        'created_at',
        'updated_at',
        'status',
    ];

    // Add any additional configuration or relationships here
}
