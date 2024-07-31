<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CategoryProduct extends Model
{
    use HasFactory;
    protected $table = "category_products";
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_dt';
    protected $fillable = [
        'name',
        'is_active',
    ];

    public function products() : HasMany
    {
        return $this->hasMany(Product::class,"id_category","id");
    }

}
