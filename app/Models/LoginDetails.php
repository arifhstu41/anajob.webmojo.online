<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'ip',
        'date',
        'details',
        'created_by',
    ];
    
}
