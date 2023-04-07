<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'type',
        'price',
        'active'
    ];


    protected $table = 'article';

    public $timestamps = false;
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

}
