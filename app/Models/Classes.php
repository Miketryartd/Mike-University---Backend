<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\User;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;

#[Fillable(["subject_name", "creator_id", "class_code", "user_email", "class_section"])]

class Classes extends Model
{
    use HasApiTokens;
  protected $table = "class";
    
    public function user(): BelongsTo{
        return $this->belongsTo(User::class, "creator_id");
    }

    public function email(): BelongsTo{
        return $this->belongsTo(User::class, "user_email");
    }
    public function students(): HasMany{
        return $this->hasMany(User::class);
    }
}
