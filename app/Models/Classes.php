<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\User;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;

#[Fillable(["class_name", "teacher_id", "students"])]
#[Hidden(["created_at", "updated_at"])]
class Classes extends Model
{
    use HasApiTokens;

    public function teacher_id(): BelongsTo{
        return $this->belongsTo(User::class);
    }

    public function students(): HasMany{
        return $this->hasMany(User::class);
    }
}
