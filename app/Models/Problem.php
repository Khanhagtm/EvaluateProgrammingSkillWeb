<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Problem extends Model
{
    use HasFactory;
    public function testCases()
    {
        return $this->hasMany(TestCase::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function solvers()
    {
        return $this->belongsToMany(User::class, 'problem_user', 'problem_id', 'user_id')
            ->withTimestamps()
            ->withPivot(['assigner_id']);
    }

    public function problem_user()
    {
        return $this->hasMany(ProblemUser::class);
    }

}

