<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'name',
        'description',
        'user_id' // Ensure this is included
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function orders()
{
    return $this->hasMany(Order::class);
}
}
