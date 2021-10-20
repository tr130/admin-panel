<?php

namespace App\Models;

use App\Models\Job;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JobYear extends Model
{
    use HasFactory;

    public function job()
    {
        $this->belongsTo(Job::class);
    }
}
