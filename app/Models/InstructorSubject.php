<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstructorSubject extends Model
{

    use HasFactory;

    protected $table = 'instructor_subject';

    public function subjectDetail()
    {
        return $this->hasMany(Subjects::class, "id", "subject_id");
    }
}
