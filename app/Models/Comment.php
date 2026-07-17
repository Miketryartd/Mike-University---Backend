<?php

namespace App\Models;

use App\Models\User;
use App\Models\Announcement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Sanctum\HasApiTokens;

class Comment extends Model
{
    use HasApiTokens;

    protected $table = "comments";
    
    protected $fillable = [
        "user_type", 
        "user_id", 
        "comment", 
        "announcement_id"
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, "user_id");
    }

    public function announcement(): BelongsTo
    {
        return $this->belongsTo(Announcement::class, "announcement_id");
    }
}