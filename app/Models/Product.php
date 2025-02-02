<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'quantity',
        'cost',
        'selling_price',
        'description',
        'image',
        'project_id'
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
