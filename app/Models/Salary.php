<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    use HasFactory;
    protected $table = "salarys";
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_dt';

    protected $fillable = ['type', 'salary', 'position_id', 'is_active',
        'created_at',
        'updated_dt'];

    public function position()
    {
        return $this->belongsTo(Position::class);
    }
}
