<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryAudit extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $table = 'inventory_audit';

    protected $fillable = [
        'inventory_id',
        'user_id',
        'action',
        'old_quantity',
        'new_quantity',
    ];

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
