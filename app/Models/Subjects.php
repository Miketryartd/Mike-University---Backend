<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['subject_name', 'subject_code', "teacher_id"])]
#[Hidden(['created_at', 'updated_at', "teacher_id"])]
class Subjects extends Model
{
    use HasApiTokens;

    public function teacher_id(): BelongsTo{
        return $this->belongsTo(User::class, 'teacher_id');
    }
}
