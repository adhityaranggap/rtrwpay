<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $table = "subscriptions";        
    protected $primaryKey = "id";

    protected $fillable = [
        'name',
        'price',
        'plan_period',
        'created_at',
        'updated_at'
        ];
}
