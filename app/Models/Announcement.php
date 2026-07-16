<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
#[Fillable(["title", "teacher_id", "body"])]

class Announcement extends Model
{
 use HasApiTokens;

 protected $table = 'announcements';

 public function teacher_id(): BelongsTo {
    return $this->belongsTo(User::class, 'teacher_id');
 }
}
