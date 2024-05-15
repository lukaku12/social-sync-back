<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserContact extends Model
{
    use HasFactory;

    protected $hidden = ['pivot'];

    protected $fillable = ['user_id', 'contact_id', 'accepted'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
