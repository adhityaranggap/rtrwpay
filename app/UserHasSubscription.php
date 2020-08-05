<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserHasSubscription extends Model
{
    protected $table = "user_has_subscription";        
    protected $primaryKey = "id";

    protected $fillable = [
        'id',
        'user_id',
        'subscription_id',
        'status',
        'created_at',
        'updated_at'
        ];
}
