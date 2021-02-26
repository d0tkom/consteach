<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Teacher;

class Availability extends Model
{
    use HasFactory;

    protected $fillable = [
    	'teacher_id',
        'start',
        'end',
        'weekday',
    ];

    public function teacher()
    {
    	return $this->belongsTo(Teacher::class);
    }
}
