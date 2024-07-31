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
    
    protected $fillable = ['projectNo','product_id','customer_id','amount','transport_cost','type','is_active','reason','survey_date','due_date',
        'created_at',
        'updated_at'];

    public function product()
    {
        return $this->belongsTo(Product::class,'product_id');
    }
    public function materials()
    {
        return $this->hasMany(ProjectMaterials::class, 'projectNo', 'projectNo');
    }

    public function steps()
    {
        return $this->hasMany(ProjectStep::class, 'projectNo', 'projectNo');
    }
    public function customer(){
        return $this->belongsTo(Customer::class,'customer_id');
    }
}

