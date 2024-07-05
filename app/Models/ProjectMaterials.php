<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectMaterials extends Model
{
    use HasFactory;
    protected $table = "project_materials";
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_dt';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'projectNo',
        'materialId',
        'qty',
        'price',
        'customPrice',
        'deliveryStatus',
        'remainingQty',
    ];

    /**
     * Get the product that owns the step.
     */
    public function project()
    {
        return $this->belongsTo(Projects::class);
    }
}
