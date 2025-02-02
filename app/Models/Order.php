<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_number',
        'project_id',
        'products',
        'total_price',
        'customer_name',
        'customer_phone',
        'customer_email',
        'shipping_amount'
    ];

    protected $casts = [
        'products' => 'array'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function getProductsWithDetailsAttribute()
    {
        return collect($this->products)->map(function ($item) {
            return [
                'product' => Product::find($item['id']),
                'quantity' => $item['quantity']
            ];
        });
    }
}
