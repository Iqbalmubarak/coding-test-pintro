<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $table = 'inventories';

    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    public function unit()
    {
        return $this->hasOne(Unit::class, 'id', 'unit_id');
    }

    public function details()
    {
        return $this->hasMany(InventoryDetail::class, 'inventory_id', 'id');
    }

    public function out()
    {
        return $this->hasMany(OutInventory::class, 'inventory_id', 'id');
    }
}
