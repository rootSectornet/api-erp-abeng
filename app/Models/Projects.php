<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projects extends Model
{
    use HasFactory;
    protected $primaryKey = 'projectNo';
    public $incrementing = false;
    protected $keyType = 'string';
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function materials()
    {
        return $this->hasMany(ProjectMaterial::class, 'projectNo', 'projectNo');
    }

    public function steps()
    {
        return $this->hasMany(ProjectStep::class, 'projectNo', 'projectNo');
    }
}

