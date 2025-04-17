<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidateLicense extends Model
{
    use HasFactory;
    protected $fillable = [
        'id', 'license_status',
    ];
}
