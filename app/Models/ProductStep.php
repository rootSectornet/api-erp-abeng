<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductStep extends Model
{
    use HasFactory;
    protected $table = "product_steps";
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_dt';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'notes',
        'rank',
        'maxDuration',
        'product_id',
    ];

    /**
     * Get the product that owns the step.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
