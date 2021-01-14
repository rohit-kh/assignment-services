<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Model implements AuthenticatableContract, AuthorizableContract, JWTSubject
{
    use Authenticatable, Authorizable, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];


    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function roles()
    {
        return $this->hasMany(UserRoles::class, "user_id", "id");
    }

    public function subjects()
    {
        return $this->hasMany(InstructorSubject::class, "created_by", "id");
    }

    public function assignments()
    {
        return $this->hasMany(Assignments::class, "created_by", "id");
    }

//    public function testHasOneThrough()
//    {
//        return $this->hasOneThrough(
//            Assignments::class,
//            InstructorSubject::class,
//            'instructor_id', // Foreign key on the InstructorSubject table...
//            'instructor_subject_id', // Foreign key on the owners table...
//            'id', // Local key on the Assignments table...
//            'id' // Local key on the InstructorSubject table...
//        );
//    }
}
