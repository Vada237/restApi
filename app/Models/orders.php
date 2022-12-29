<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class orders extends Model
{
    use HasFactory;
    protected $fillable = ['status'];

    public function orders_dishes() {
        return $this->HasMany(orders_dishes::class, 'order_id','id');
    }


}
