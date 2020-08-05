<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransactionHasModified extends Model
{
    protected $table = "transaction_has_modified";        
    protected $primaryKey = "id";

    protected $fillable = [
        'id',         
        'user_id',
        'transaction_id',
        'action',
        'created_at',
        'updated_at'
        ];
}
