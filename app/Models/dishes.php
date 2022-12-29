<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class dishes extends Model
{
    use HasFactory;
    protected $fillable = ['name','price','caloric','category_id','image'];

    public function order_dishes() {
        return $this->HasMany(orders_dishes::class, 'dishes_id', 'id');
    }
}
