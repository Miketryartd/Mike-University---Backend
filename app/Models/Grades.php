<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Sanctum\HasApiTokens;
use App\Models\User;
use App\Models\Subjects;

#[Fillable(['student_id', 'subject_id', 'score', 'remarks'])]
#[Hidden(['created_at', 'updated_at'])]
class Grades extends Model
{
    use  HasApiTokens;

    public function student_id(): BelongsTo{
        return $this->belongsTo(User::class, 'student_id');
    }
    
    public function subject_id(): BelongsTo{
        return $this->belongsTo(Subjects::class, 'subject_id');
    }
}
