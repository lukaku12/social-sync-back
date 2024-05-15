<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MessageViewer extends Model
{
    use HasFactory;

    protected $fillable = ['message_id', 'user_id'];

    public function message(): BelongsTo
    {
        return $this->belongsTo(Message::class);
    }
}
