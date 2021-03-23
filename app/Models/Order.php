<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Teacher;
use App\Models\User;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
    	'transaction_id',
    	'teacher_id',
    	'user_id',
    	'total',
    	'lesson_number'
    ];

    public function teacher()
    {
    	return $this->belongsTo(Teacher::class);
    }

    public function user()
    {
    	return $this->belongsTo(User::class);
    }
}
