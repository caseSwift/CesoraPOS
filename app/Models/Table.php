<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    use HasFactory;

    protected $table = 'table';
    protected $primaryKey = 'table_id';

    protected $fillable = [
        'name',
        'position',
    ];

    public function orders()
  {
       return $this->hasMany(Order::class, 'fk_table_id', 'table_id');
   }
}
