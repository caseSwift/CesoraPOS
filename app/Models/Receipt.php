<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Receipt extends Model
{
    use HasFactory;

    protected $table = 'receipt';
    protected $primaryKey = 'receipt_id';
    protected $fillable = [
        'fk_table_id',
        'fk_user_id',
        'voided_at',
        'finalized_at',
        'fk_void_user_id'
    ];
}
