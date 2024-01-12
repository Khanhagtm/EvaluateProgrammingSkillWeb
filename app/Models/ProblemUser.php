<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProblemUser extends Model
{
    use HasFactory;
    protected $table = 'problem_user';

    protected $fillable = [
        'user_id',
        'problem_id',
        'assigner_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'assigner_id');
    }
}
