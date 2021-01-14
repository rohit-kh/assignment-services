<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignments extends Model
{
    use HasFactory;

    public function subject()
    {
        return $this->hasMany(InstructorSubject::class, "id", "instructor_subject_id");
    }
}
