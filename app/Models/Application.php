<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;
    

    protected $fillable = [
        'user_id',
        'grade',
        'gpa',
        'sat_scores',
        'ap_scores',
        'extracurriculars',
        'awards',
        'nationality',
        'first_choice_major',
        'second_choice_major',
        'essay'
    ];
}
