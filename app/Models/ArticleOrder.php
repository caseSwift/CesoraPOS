<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleOrder extends Model
{
    use HasFactory;

    protected $table = 'article_order';

    protected $primaryKey = 'article_order_id';

    protected $fillable = [
        'fk_article_id',
        'fk_order_id',
        'quantity',
        'price',
        'voided_at',
        'fk_void_user_id',
        'fk_user_id',
    ];

    public function article()
    {
        return $this->belongsTo(Article::class, 'fk_article_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'fk_order_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'fk_user_id');
    }

    public function void_user()
    {
        return $this->belongsTo(User::class, 'fk_void_user_id');
    }
}
