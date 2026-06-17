<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
    'total',
    'customer_name',
    'address',
    'phone',
    'status'
];
public function items()
{
    return $this->hasMany(OrderItem::class);
}
public function logistica()
{
    return $this->hasOne(Logistica::class, 'pedido_id');
}
}
