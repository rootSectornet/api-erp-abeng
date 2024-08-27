<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectMaterials extends Model
{
    use HasFactory;
    protected $table = "project_materials";
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $fillable = [
        'projectNo',
        'materialId',
        'qty',
        'price',
        'customPrice',
        'deliveryStatus',
        'remainingQty',
    ];

    public function project()
    {
        return $this->belongsTo(Projects::class, 'projectNo', 'projectNo');
    }

    public function material()
    {
        return $this->belongsTo(Material::class, 'materialId');
    }
}
