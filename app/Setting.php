<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    // Set which attributes can be filled by mass assignment (in a single go)
    protected $fillable = ['user_id', 'settings'];
    // Specify the associated table
    protected $table = 'settings';
}
