<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class orders_dishes extends Model
{
    use HasFactory;
    protected $fillable = ['order_id', 'dishes_id', 'count', 'sum'];

    public function order() {
        return $this->belongsTo(dishes::class);
    }

    public function dishes() {
        return $this->belongsTo(dishes::class);
    }
}
