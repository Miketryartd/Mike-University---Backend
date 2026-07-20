<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\User;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;

#[Fillable(["class_name", "creator_id", "class_code"])]

class Classes extends Model
{
    use HasApiTokens;
  protected $table = "class";
    
    public function user(): BelongsTo{
        return $this->belongsTo(User::class, "creator_id");
    }

    public function students(): HasMany{
        return $this->hasMany(User::class);
    }
}
