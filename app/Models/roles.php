<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class roles extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name'
    ];

    public function Users() {
        return $this->hasMany(user::class, 'role_id', 'id');
    }
}
