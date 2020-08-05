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
        'created_at',
        'updated_at'
        ];
}
