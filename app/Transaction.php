<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Transaction extends Model
{
    protected $table = "transactions";        
    protected $primaryKey = "id";

    protected $fillable = [
        'user_has_subscription_id',
        'notes',
        'expired_date',
        'status',
        'price',
        'paid',
        'file',
        'type_payment',
        'transaction_has_modified_id',
        'created_at',
        'updated_at'
        ];
}
