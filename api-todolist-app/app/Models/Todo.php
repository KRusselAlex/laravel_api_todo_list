<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Todo extends Model
{
    protected $fillable = [
        'name',
        'user_id',
        'description',
    ];

    public function users() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
