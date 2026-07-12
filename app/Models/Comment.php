<?php

namespace App\Models;
use App\Models\User;
use App\Models\Announcement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Sanctum\HasApiTokens;
#[Fillable(["comment", "teacher_id", "student_id", "user_type"])]
#[Hidden(["teacher_id", "student_id", "created_at"])]
class Comment extends Model
{
    //
    use HasApiTokens;


    public function teacher_id(): BelongsTo{
        return $this->belongsTo(User::class);
    }

    public function student_id(): BelongsTo{
        return $this->belongsTo(User::class);
    }

    public function announcement(): BelongsTo{
        return $this->belongsTo(Announcement::class);
    }

}
