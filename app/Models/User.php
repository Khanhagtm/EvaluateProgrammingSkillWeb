<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function isAdmin()
    {
        return $this->id === 1; // Assume 'role' is a field in your users table
    }

    public function problems(): BelongsToMany
    {
        return $this->belongsToMany(Problem::class);
    }

    public function assignedProblems()
    {
        return $this->hasMany(ProblemUser::class, 'assigner_id');
    }

    public function solvedProblems()
    {
        return $this->belongsToMany(Problem::class, 'problem_user', 'user_id', 'problem_id')
            ->withTimestamps()
            ->withPivot(['assigner_id']);
    }
    public function problem_user()
    {
        return $this->hasMany(ProblemUser::class);
    }
}
