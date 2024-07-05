<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;
    protected $table = "positions";
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_dt';
    protected $fillable = [
        'name',
        'is_active',
    ];    
    public function salarys()
    {
        return $this->hasMany(Salary::class);
    }
}
