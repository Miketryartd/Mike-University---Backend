<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
#[Fillable(["title", "teacher_id", "body"])]

class Announcement extends Model
{
 use HasApiTokens;

 protected $table = 'announcements';

 public function teacher_id(): BelongsTo {
    return $this->belongsTo(User::class, 'teacher_id');
 }

 public function comments(): HasMany{
   return $this->hasMany(Comment::class, "announcement_id");
 }
}
