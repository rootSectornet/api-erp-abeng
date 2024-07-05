<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Material extends Model
{
    use HasFactory;
    protected $table = "materials";
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_dt';
    protected $fillable = [
        'name',
        'price',
        'unit',
        'type',
        'is_active',
        'created_at',
        'updated_dt'
    ];
}
