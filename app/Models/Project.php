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
    public function projects()
    {
        return $this->hasMany(Project::class);
    }
}
