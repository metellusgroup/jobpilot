<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidateVisa extends Model
{
    use HasFactory;
    protected $fillable = [
        'id', 'visa_status',
    ];
}
