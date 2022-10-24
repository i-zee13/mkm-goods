<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherAddress extends Model
{
    use HasFactory;
    protected $table = 'teacher_address';

    public function teachers()
    {
        return $this->hasMany(Teacher::class);
    }
}
