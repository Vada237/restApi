<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class dishes_structures extends Model
{
    use HasFactory;
    protected $fillable = ['product_name','dishes_id'];
}
