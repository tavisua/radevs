<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestResult extends Model
{
    use HasFactory;
    protected $fillable = [
        'full_name',
        'date',
        'location',
        'rating',
        'criterion',
        'user_id',
        'test_id',
    ];
}
