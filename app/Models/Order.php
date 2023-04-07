<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'order';
    protected $primaryKey = 'order_id';

    protected $fillable = [
        'fk_table_id',
        'fk_receipt_id',
        'finalized_at',
        'voided_at',
        'fk_user_id',
        'fk_void_user_id',
    ];
    public function table()
    {
        return $this->belongsTo(Table::class, 'fk_table_id');
    }
    public function receipt()
    {
        return $this->belongsTo(Receipt::class, 'fk_receipt_id', 'receipt_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'fk_user_id', 'id');
    }

    public function voidUser()
    {
        return $this->belongsTo(User::class, 'fk_void_user_id', 'id');
    }
    public function articleOrders()
    {
        return $this->hasMany(ArticleOrder::class, 'fk_order_id');
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

}
