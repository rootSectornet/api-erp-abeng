<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Product extends Model
{
    use HasFactory;
    use HasFactory;
    protected $table = "products";
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_dt';
    protected $fillable = [
        'name',
        'id_category',
        'is_active',
        'created_at',
        'updated_dt'
    ];
    public function category() : BelongsTo
    {
        return $this->belongsTo(CategoryProduct::class,"id_category");
    }
}
