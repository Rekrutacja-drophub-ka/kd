<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['mpn', 'quantity', 'production_year', 'price'];
}
