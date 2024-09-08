<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    // Sebenarnya di table user ditambah role_id agar
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
