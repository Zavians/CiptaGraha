<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductsModel extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'products';

    protected $fillable = ['name','images','price'];

    protected $casts = [
        'images' => 'array', // This will automatically decode JSON strings to arrays
    ];
}
