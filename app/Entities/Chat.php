<?php

namespace App\Entities;

use App\Traits\BelongsToUser;
use App\Traits\Uploadable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chat extends Model
{
    use SoftDeletes, BelongsToUser, Uploadable;

    protected $fillable = [
        'user_id','inbound','platform','message','from', 'to', 'delivered', 'read', 'meta'
    ];

    protected $casts = [
        'meta' => 'array',
    ];

    public function chatable()
    {
        return $this->morphTo();
    }

    public function markRead()
    {
        $this->update(['read' => 1]);
        $this->chatable->update(['has_chats' => 0]);
    }
    public function isDelivered()
    {
        return $this->update(['delivered' => 1]);
    }

    public function scopeUnread($query)
    {
        return $query->whereRead(0);
    }
}
