<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Travel extends Model
{
    protected $table = "travel_plan";
    protected $fillable = [
        'destination',
        'start_date',
        'end_date',
        'description',
         'created_by',
        'shared_to'
    ];
}
